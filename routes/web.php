<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\LaporanController;
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

    // Pemeliharaan Routes
    Route::resource('pemeliharaan', PemeliharaanController::class);

    // Laporan Routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/kategori', [LaporanController::class, 'kategori'])->name('kategori');
        Route::get('/lokasi', [LaporanController::class, 'lokasi'])->name('lokasi');
        Route::get('/peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/pemeliharaan', [LaporanController::class, 'pemeliharaan'])->name('pemeliharaan');

        // Export Routes
        Route::get('/kategori/export-pdf', [LaporanController::class, 'exportKategoriPdf'])->name('kategori.export-pdf');
        Route::get('/lokasi/export-pdf', [LaporanController::class, 'exportLokasiPdf'])->name('lokasi.export-pdf');
        Route::get('/peminjaman/export-pdf', [LaporanController::class, 'exportPeminjamanPdf'])->name('peminjaman.export-pdf');
        Route::get('/pemeliharaan/export-pdf', [LaporanController::class, 'exportPemeliharaanPdf'])->name('pemeliharaan.export-pdf');
    });
});

require __DIR__ . '/auth.php';
