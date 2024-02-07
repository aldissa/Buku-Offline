<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class,'login'])->name('login');
Route::post('/postlogin', [AuthController::class,'postlogin'])->name('postlogin');

Route::middleware('auth')->group(function() {
    Route::get('/', [KasirController::class,'home'])->name('home');
    Route::get('/pdf/{id}', [KasirController::class, 'pdf'])->name('pdf');
    Route::prefix('kasir')->group(function(){
        Route::post('/postkeranjang/{id}', [KasirController::class,'postkeranjang'])->name('postkeranjang');
        Route::get('/keranjang', [KasirController::class,'keranjang'])->name('keranjang');
        Route::get('/hapus/{id}', [KasirController::class,'hapusKeranjang'])->name('hapusKeranjang');
        Route::post('/postcheckout/{tranID}', [KasirController::class, 'postcheckout'])->name('postcheckout');
        Route::get('/history', [KasirController::class, 'history'])->name('history');
        Route::get('/detail-history/{id}', [KasirController::class, 'detailHistory'])->name('detailHistory');
        Route::get('/log', [KasirController::class, 'log'])->name('log');
    });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->group(function() {
        Route::get('/home', [AdminController::class, 'index'])->name('index');
        Route::get('/home-filter', [AdminController::class, 'bukuTidakDijual'])->name('filteradmin');
        Route::get('/tambah', [AdminController::class, 'tambah'])->name('tambah');
        Route::post('/posttambah', [AdminController::class, 'posttambah'])->name('posttambah');
        Route::get('/edit/{buku}', [AdminController::class, 'edit'])->name('edit');
        Route::post('/postedit/{buku}', [AdminController::class, 'postedit'])->name('postedit');
        Route::get('/aktifkanbuku/{buku}', [AdminController::class, 'aktifkanbuku'])->name('aktifkanbuku');
        Route::get('/nonaktifkanbuku/{buku}', [AdminController::class, 'nonaktifkanbuku'])->name('nonaktifkanbuku');
    });
    Route::prefix('owner')->group(function() {
        Route::get('/home', [OwnerController::class, 'index'])->name('home.owner');
        Route::get('/homes', [OwnerController::class, 'filteredChart'])->name('filteredhome.owner');
    });
});