@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📊 Laporan Inventaris</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Pilih jenis laporan yang ingin Anda lihat:</p>
                    
                    <div class="row g-4">
                        <!-- Laporan Kategori -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-info h-100">
                                <div class="card-body text-center">
                                    <div class="display-6 text-info mb-3">
                                        <i class="bi bi-tags"></i>
                                    </div>
                                    <h5 class="card-title">Laporan Kategori</h5>
                                    <p class="card-text text-muted">Lihat barang berdasarkan kategori yang tersedia</p>
                                    <a href="{{ route('laporan.kategori') }}" class="btn btn-info">
                                        <i class="bi bi-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Lokasi -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-success h-100">
                                <div class="card-body text-center">
                                    <div class="display-6 text-success mb-3">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <h5 class="card-title">Laporan Lokasi</h5>
                                    <p class="card-text text-muted">Lihat barang berdasarkan lokasi penyimpanan</p>
                                    <a href="{{ route('laporan.lokasi') }}" class="btn btn-success">
                                        <i class="bi bi-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Peminjaman -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-warning h-100">
                                <div class="card-body text-center">
                                    <div class="display-6 text-warning mb-3">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <h5 class="card-title">Laporan Peminjaman</h5>
                                    <p class="card-text text-muted">Lihat riwayat peminjaman barang inventaris</p>
                                    <a href="{{ route('laporan.peminjaman') }}" class="btn btn-warning">
                                        <i class="bi bi-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Laporan Pemeliharaan -->
                        <div class="col-md-6 col-lg-3">
                            <div class="card border-danger h-100">
                                <div class="card-body text-center">
                                    <div class="display-6 text-danger mb-3">
                                        <i class="bi bi-tools"></i>
                                    </div>
                                    <h5 class="card-title">Laporan Pemeliharaan</h5>
                                    <p class="card-text text-muted">Lihat riwayat pemeliharaan dan perbaikan barang</p>
                                    <a href="{{ route('laporan.pemeliharaan') }}" class="btn btn-danger">
                                        <i class="bi bi-eye"></i> Lihat Laporan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection