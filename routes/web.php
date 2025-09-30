<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('user', UserController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('barang', BarangController::class);
    Route::get('barang-laporan', [BarangController::class, 'cetakLaporan'])->name('barang.laporan');
    
    // Peminjaman Routes
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});

require __DIR__ . '/auth.php';
