<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Log;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function user()
    {
        $user = User::all();
        return view('admin.user', compact('user'));
    }

    function tambahUser()
    {
        return view('admin.tambahuser');
    }

    function postUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        if ($user) {
            Log::create([
                'user_id' => auth()->id(),
                'aktivitas' => auth()->user()->name . ' Menambah User ' . $request->username
            ]);
            return redirect()->route('user');
        }
    }

    function editUser(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    function postEditUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique',
            'password' => 'required',
            'role' => 'required'
        ]);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        if ($user) {
            Log::create([
                'user_id' => auth()->id(),
                'aktivitas' => auth()->user()->name . ' Mengedit User ' . $request->username
            ]);
            return redirect()->route('user');
        }
    }

    function index()
    {
        $buku = Buku::where('status', 'dijual')->get();
        return view('admin.index', compact('buku'));
    }

    function bukuTidakDijual(Request $request)
    {
        $buku = Buku::where('status', $request->statusBuku)->get();
        return view('admin.index', compact('buku'));
    }

    function tambah()
    {
        return view('admin.tambah');
    }

    function posttambah(Request $request)
    {
        if ($request) {
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

    function delete(User $user) {
        $user->delete();

        return redirect()->back();
    }

    function aktifkanBuku(Buku $buku)
    {
        $buku->update([
            'status' => 'dijual'
        ]);

        return redirect()->route('index');
    }

    function nonaktifkanBuku(Buku $buku)
    {
        $buku->update([
            'status' => 'tidak dijual'
        ]);

        return redirect()->route('index');
    }

    function indexDiskon() {
        $voucher = Voucher::all();

        return view('admin.indexdiskon', compact('voucher'));
    }
    
    function diskon()
    {
        return view('admin.diskon');
    }

    function postdiskon(Request $request)
    {
        if ($request) {
            $buku = Voucher::create([
                'kode' => $request->kode,
                'diskon' => $request->diskon,
                'kedaluwarsa' => $request->kedaluwarsa,
            ]);
        }

        if ($buku) {
            Log::create([
                'user_id' => auth()->id(),
                'aktivitas' => auth()->user()->name . ' Menambah Diskon ' . $buku->kode
            ]);
        }
        return redirect()->route('index');
    }
    
    function editDiskon(Voucher $voucher)
    {
        return view('admin.editdiskon', compact('voucher'));
    }

    function postEditDiskon(Request $request, Buku $buku)
    {
        if ($request) {
            $buku->update([
                'kode' => $request->kode,
                'diskon' => $request->diskon,
                'kedaluwarsa' => $request->kedaluwarsa,
            ]);
        }

        if ($buku) {
            Log::create([
                'user_id' => auth()->id(),
                'aktivitas' => auth()->user()->name . ' Menambah Diskon ' . $buku->kode
            ]);
        }
        return redirect()->route('index');
    }
}
