@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">🔧 Laporan Pemeliharaan Barang</h4>
                    <div>
                        <a href="{{ route('laporan.pemeliharaan.export-pdf', request()->query()) }}" class="btn btn-light btn-sm me-2">
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
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('laporan.pemeliharaan') }}" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ $tanggal_mulai }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ $tanggal_selesai }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">Semua</option>
                                        <option value="dikirim" {{ $status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="dalam_perbaikan" {{ $status == 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                        <option value="menunggu_approval" {{ $status == 'menunggu_approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                        <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        <option value="tidak_bisa_diperbaiki" {{ $status == 'tidak_bisa_diperbaiki' ? 'selected' : '' }}>Tidak Bisa Diperbaiki</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Kode, vendor, deskripsi..." value="{{ $search }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-danger d-block">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['total_pemeliharaan'] }}</h5>
                                    <small>Total Pemeliharaan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['dalam_perbaikan'] }}</h5>
                                    <small>Dalam Perbaikan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['selesai'] }}</h5>
                                    <small>Selesai</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>Rp {{ number_format($summary['total_biaya'], 0, ',', '.') }}</h5>
                                    <small>Total Biaya</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    @if($pemeliharaans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Barang</th>
                                        <th>Vendor</th>
                                        <th>Jenis Kerusakan</th>
                                        <th>Jumlah</th>
                                        <th>Biaya</th>
                                        <th>Tanggal Kirim</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pemeliharaans as $pemeliharaan)
                                    <tr>
                                        <td>
                                            <code>{{ $pemeliharaan->kode_pemeliharaan }}</code>
                                        </td>
                                        <td>
                                            <strong>{{ $pemeliharaan->barang->nama_barang }}</strong><br>
                                            <small class="text-muted">{{ $pemeliharaan->barang->kode_barang }}</small>
                                        </td>
                                        <td>
                                            {{ $pemeliharaan->nama_vendor }}
                                            @if($pemeliharaan->pic_vendor)
                                                <br><small class="text-muted">PIC: {{ $pemeliharaan->pic_vendor }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($pemeliharaan->jenis_kerusakan == 'rusak_ringan')
                                                <span class="badge bg-warning">Rusak Ringan</span>
                                            @else
                                                <span class="badge bg-danger">Rusak Berat</span>
                                            @endif
                                            <br><small class="text-muted">{{ Str::limit($pemeliharaan->deskripsi_kerusakan, 50) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $pemeliharaan->jumlah_dipelihara }}</span>
                                        </td>
                                        <td>
                                            @if($pemeliharaan->biaya_aktual)
                                                <strong>Rp {{ number_format($pemeliharaan->biaya_aktual, 0, ',', '.') }}</strong>
                                            @elseif($pemeliharaan->estimasi_biaya)
                                                <span class="text-muted">Est: Rp {{ number_format($pemeliharaan->estimasi_biaya, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $pemeliharaan->tanggal_kirim->format('d/m/Y') }}</td>
                                        <td>
                                            @if($pemeliharaan->status == 'dikirim')
                                                <span class="badge bg-info">Dikirim</span>
                                            @elseif($pemeliharaan->status == 'dalam_perbaikan')
                                                <span class="badge bg-warning">Dalam Perbaikan</span>
                                            @elseif($pemeliharaan->status == 'menunggu_approval')
                                                <span class="badge bg-secondary">Menunggu Approval</span>
                                            @elseif($pemeliharaan->status == 'selesai')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($pemeliharaan->status == 'dibatalkan')
                                                <span class="badge bg-dark">Dibatalkan</span>
                                            @elseif($pemeliharaan->status == 'tidak_bisa_diperbaiki')
                                                <span class="badge bg-danger">Tidak Bisa Diperbaiki</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $pemeliharaans->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center">
                            <div class="text-muted">
                                <i class="bi bi-tools display-1"></i>
                                <h4>Tidak ada data pemeliharaan</h4>
                                <p>Tidak ada pemeliharaan pada periode yang dipilih.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection