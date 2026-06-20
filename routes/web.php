<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

// ==========================================================
// RUTE AUTENTIKASI MANUAL
// ==========================================================
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Inventori Obat
    Route::get('/obat', [ObatController::class, 'index']);
    Route::get('/obat/tambah', [ObatController::class, 'create']);
    Route::post('/obat/simpan', [ObatController::class, 'store']);
    Route::get('/obat/edit/{id}', [ObatController::class, 'edit']);
    Route::put('/obat/update/{id}', [ObatController::class, 'update']);
    // TAMBAHKAN BARIS INI:
    Route::delete('/obat/hapus/{id}', [ObatController::class, 'destroy']);

    // Terminal Kasir (Transaksi)
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('/transaksi/tambah', [TransaksiController::class, 'store']);
    Route::get('/transaksi/hapus-item/{id}', [TransaksiController::class, 'destroyItem']);
    Route::get('/transaksi/hapus-semua', [TransaksiController::class, 'clear']);
    Route::post('/transaksi/checkout', [TransaksiController::class, 'checkout']); // INI WAJIB
    Route::get('/transaksi/struk/{id}', [TransaksiController::class, 'struk']);   // INI WAJIB

    // Manajemen User (Sekarang bisa diakses semua user yang login)
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/tambah', [UserController::class, 'create']);
    Route::post('/user/simpan', [UserController::class, 'store']);
    Route::delete('/user/hapus/{id}', [UserController::class, 'destroy']);

    // Faktur Pembelian (Barang Masuk)
    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::get('/pembelian/tambah', [PembelianController::class, 'create']);
    Route::post('/pembelian/simpan', [PembelianController::class, 'store']);
    Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit']);
    Route::put('/pembelian/update/{id}', [PembelianController::class, 'update']);
    Route::delete('/pembelian/hapus/{id}', [PembelianController::class, 'destroy']);

    // Laporan Penjualan & Export
    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/export', [LaporanController::class, 'exportExcel']);
    // ==========================================================
    // KHUSUS ROLE: ADMIN
    // ==========================================================
    // Trik memanggil class langsung agar tidak kena error "Target class does not exist"
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        
        // Manajemen User (Hanya Admin yang bisa masuk ke sini)
        Route::get('/user', [UserController::class, 'index']);
        Route::get('/user/tambah', [UserController::class, 'create']);
        Route::post('/user/simpan', [UserController::class, 'store']);
        Route::delete('/user/hapus/{id}', [UserController::class, 'destroy']);


        
    });
});