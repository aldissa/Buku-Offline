<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        $buku = Buku::where('status','dijual')->get();
        return view('admin.index', compact('buku'));
    }

    function bukuTidakDijual(Request $request) {
        $buku = Buku::where('status',$request->statusBuku)->get();
        return view('admin.index', compact('buku'));
    }

    function tambah()
    {
        return view('admin.tambah');
    }

    function posttambah(Request $request)
    {
        if($request){
            $buku = Buku::create([
                'nama' => $request->nama,
                'foto' => $request->foto->store('img'),
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'stok' => $request->stok,
            ]);
        }

        if ($buku) {
            Log::create([
                'user_id' => auth()->id(),
                'aktivitas' => auth()->user()->name . ' Menambah Buku ' . $buku->nama
            ]);
        }
        return redirect()->route('index');
    }

    function edit(Buku $buku)
    {
        return view('admin.edit', compact('buku'));
    }

    function postedit(Request $request, Buku $buku)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'stok' => 'required',
        ]);

        $image = $request->file('foto')->store('img');
        $buku->update(array_merge($request->all(), ['foto' => $image]));

        Log::create([
            'user_id' => auth()->id(),
            'aktivitas' => auth()->user()->name . ' Mengedit Buku'
        ]);
        return redirect()->route('index');
    }

    function aktifkanBuku(Buku $buku) {
        $buku->update([
            'status' => 'dijual'
        ]);

        return redirect()->route('index');
    }

    function nonaktifkanBuku(Buku $buku) {
        $buku->update([
            'status' => 'tidak dijual'
        ]);

        return redirect()->route('index');
    }
}
