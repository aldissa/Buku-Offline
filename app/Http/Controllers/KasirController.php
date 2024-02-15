<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Log;
use App\Models\Transaksi;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    public function home()
    {
        $buku = Buku::where('status', 'dijual')->get();

        return view('home', compact('buku'));
    }

    public function log()
    {
        if (auth()->user()->role == 'owner') {
            $log = Log::all();
        } else {
            $log = Log::where('user_id', auth()->id())->with('user')->get();
        }

        return view('kasir.logkasir', compact('log'));
    }

    function filterLog(Request $request)
    {
        $start = Carbon::parse($request->input('start'))->startOfDay();
        $end = Carbon::parse($request->input('end'))->endOfDay();

        if (auth()->user()->role == 'owner') {
            $log = Log::whereBetween('created_at', [$start, $end])->get();
        } else {
            $log = Log::where('user_id', auth()->id())->whereBetween('created_at', [$start, $end])->get();
        }

        return view('kasir.logkasir', compact('log'));
    }

    public function postkeranjang(Request $request, $id)
    {
        $buku = Buku::find($id);
        if ($request->qty > $buku->stok) {
            return redirect()->back()->with('err', 'Stok tidak mencukupi');
        }
        $cekTranksaksi = Transaksi::where(['user_id' => auth()->id(), 'status' => 'pending'])->with('detailtransaksi')->first();
        if ($cekTranksaksi) {
            if ($detailtransaksi = $cekTranksaksi->detailtransaksi->where('buku_id', $id)->first()) {
                $detailtransaksi->qty = $detailtransaksi->qty + $request->qty;
                $detailtransaksi->save();
                return redirect()->back()->with('msg', 'Dimasukan Keranjang');
            } else {
                DetailTransaksi::create([
                    'transaksi_id' => $cekTranksaksi->id,
                    'buku_id' => $id,
                    'qty' => $request->qty
                ]);
                return redirect()->back()->with('msg', 'Dimasukan keranjang');
            }
        }
        if (!$cekTranksaksi) {
            $createTran = Transaksi::create([
                'user_id' => auth()->id(),
                'status' => 'pending'
            ]);
            DetailTransaksi::create([
                'transaksi_id' => $createTran->id,
                'buku_id' => $id,
                'qty' => $request->qty
            ]);
            return redirect()->back()->with('msg', 'Dimasukan keranjang');
        }
    }

    public function keranjang()
    {
        $transaksi = Transaksi::where(['user_id' => auth()->id(), 'status' => 'pending'])->with('detailtransaksi.buku')->get();

        $isEmpty = $transaksi->isEmpty();

        return view('kasir.keranjang', compact('transaksi', 'isEmpty'));
    }

    public function hapusKeranjang($id)
    {
        $keranjang = DetailTransaksi::where('id', $id)->first();
        if (!$keranjang) {
            return redirect()->back();
        }
        if ($keranjang->delete()) {
            return redirect()->back()->with('hapus', 'Berhasil menghapus item');
        }
    }

    public function postcheckout(Request $request, $tranID)
    {
        $request->validate([
            'uang_bayar' => 'required',
            'nama_user' => 'required',
        ]);

        $transacId = json_decode($tranID);
        $transaksi = Transaksi::whereIn('id', $transacId)->with('detailtransaksi.buku')->get();

        $totalSemua = 0;

        foreach ($transaksi as $item) {
            foreach ($item->detailtransaksi as $dt) {
                $hargaAwal = $dt->buku->harga * $dt->qty;
                $totalSemua += $hargaAwal;
            }
        }

        $diskon = 0;
        $kodeVoucher = $request->input('kode_voucher');
        $voucherId = null;
        if (!empty($kodeVoucher)) {
            $voucher = Voucher::where('kode', $kodeVoucher)->where('kedaluwarsa', '>=', now())->first();
            if ($voucher) {
                // Menghitung diskon sesuai persentase voucher (10%)
                $diskon = ($voucher->diskon / 100) * $totalSemua;
                $totalSemua -= $diskon;
                $voucherId = $voucher->id;
            }
        }

        // Total akhir setelah diskon
        $totalAkhir = $totalSemua - $diskon;

        foreach ($transaksi as $item) {
            $totalHargaItem = 0;

            foreach ($item->detailtransaksi as $dt) {
                $hargaAwal = $dt->buku->harga * $dt->qty;
                $totalHargaItem += $hargaAwal;
                $buku = Buku::find($dt->buku->id);

                if ($buku->stok >= $dt->qty) {
                    $buku->stok -= $dt->qty;
                    $buku->save();
                } else {
                    return redirect()->back()->with('error', 'Insufficient stock for ' . $dt->buku->nama);
                }
            }

            $inv = 'INV' . Str::random(7);
            $item->update([
                'invoice' => $inv,
                'nama_user' => $request->nama_user,
                'status' => 'dibayar',
                'totalharga' => $totalSemua,
                'uang_bayar' => $request->uang_bayar,
                'uang_kembali' => $request->uang_bayar - $totalSemua,
                'voucher_id' => $voucherId,
                'created_at' => Carbon::now(),
            ]);
        }

        Log::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Melakukan checkout untuk pelanggan bernama: ' . $request->nama_user
        ]);

        return redirect()->route('home')->with('success', 'Berhasil mengcheckout barang');
    }



    public function history()
    {
        $transaksi = Transaksi::where([
            'user_id' => auth()->id(),
            'status' => 'dibayar'
        ])->with('detailtransaksi.buku')->get();

        return view('kasir.history', compact('transaksi'));
    }

    function detailHistory($id)
    {
        $transaksi = Transaksi::where('id', $id)->with('detailtransaksi.buku')->first();
        return view('kasir.detailHistory', compact('transaksi'));
    }

    public function pdf($id)
    {
        $transaksi = Transaksi::where('id', $id)->first();
        $data = [
            'data' => $transaksi
        ];
        $pdf = Pdf::loadView('pdf', $data);
        return $pdf->download($transaksi->invoice . '.pdf');
    }

    function search(Request $request)
    {
        $search = $request->input('cari');
        if ($search) {
            $buku = Buku::where('nama', 'LIKE', "%{$search}%")->get();
        } else {
            $buku = Buku::where('status', 'dijual')->get();
        }

        return view('home', compact('buku'));
    }
}
