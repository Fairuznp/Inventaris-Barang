@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">📊 Laporan Barang per Kategori</h4>
                    <div>
                        <a href="{{ route('laporan.kategori.export-pdf') }}" class="btn btn-light btn-sm me-2">
                            <i class="bi bi-file-pdf"></i> Export PDF
                        </a>
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-light btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('laporan.kategori') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari kategori..." value="{{ $search }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($kategoris->count() > 0)
                        @foreach($kategoris as $kategori)
                        <div class="mb-4">
                            <div class="card border-info">
                                <div class="card-header bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0 text-info">
                                            <i class="bi bi-tag"></i> {{ $kategori->nama_kategori }}
                                        </h5>
                                        <span class="badge bg-info">{{ $kategori->barangs_count }} barang</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($kategori->barangs->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover table-sm">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th>Total</th>
                                                        <th>Baik</th>
                                                        <th>Rusak Ringan</th>
                                                        <th>Rusak Berat</th>
                                                        <th>Satuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($kategori->barangs as $barang)
                                                    <tr>
                                                        <td>
                                                            <code>{{ $barang->kode_barang }}</code>
                                                        </td>
                                                        <td>{{ $barang->nama_barang }}</td>
                                                        <td>
                                                            <span class="badge bg-primary">{{ $barang->jumlah_total }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success">{{ $barang->jumlah_baik }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-warning">{{ $barang->jumlah_rusak_ringan }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-danger">{{ $barang->jumlah_rusak_berat }}</span>
                                                        </td>
                                                        <td>{{ $barang->satuan }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-4">
                                            <i class="bi bi-inbox display-6"></i>
                                            <p>Belum ada barang di kategori ini</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $kategoris->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center">
                            <div class="text-muted">
                                <i class="bi bi-search display-1"></i>
                                <h4>Kategori tidak ditemukan</h4>
                                <p>Tidak ada kategori yang sesuai dengan pencarian Anda.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection