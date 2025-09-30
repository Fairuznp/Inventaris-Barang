@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">📅 Laporan Peminjaman Barang</h4>
                    <div>
                        <a href="{{ route('laporan.peminjaman.export-pdf', request()->query()) }}" class="btn btn-dark btn-sm me-2">
                            <i class="bi bi-file-pdf"></i> Export PDF
                        </a>
                        <a href="{{ route('laporan.index') }}" class="btn btn-outline-dark btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('laporan.peminjaman') }}" class="row g-3">
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
                                        <option value="dipinjam" {{ $status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="dikembalikan" {{ $status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="terlambat" {{ $status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="hilang" {{ $status == 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Pencarian</label>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Nama peminjam, instansi..." value="{{ $search }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-warning d-block">
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
                                    <h5>{{ $summary['total_peminjaman'] }}</h5>
                                    <small>Total Peminjaman</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['sedang_dipinjam'] }}</h5>
                                    <small>Sedang Dipinjam</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['sudah_dikembalikan'] }}</h5>
                                    <small>Sudah Dikembalikan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h5>{{ $summary['terlambat'] }}</h5>
                                    <small>Terlambat</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    @if($peminjamans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-warning">
                                    <tr>
                                        <th>Tanggal Pinjam</th>
                                        <th>Barang</th>
                                        <th>Peminjam</th>
                                        <th>Instansi</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</td>
                                        <td>
                                            <strong>{{ $peminjaman->barang->nama_barang }}</strong><br>
                                            <small class="text-muted">{{ $peminjaman->barang->kode_barang }}</small>
                                        </td>
                                        <td>
                                            {{ $peminjaman->nama_peminjam }}
                                            @if($peminjaman->kontak_peminjam)
                                                <br><small class="text-muted">{{ $peminjaman->kontak_peminjam }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $peminjaman->instansi_peminjam ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $peminjaman->jumlah }}</span>
                                        </td>
                                        <td>
                                            @if($peminjaman->tanggal_kembali)
                                                {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            @if($peminjaman->tanggal_kembali_aktual)
                                                <br><small class="text-success">Aktual: {{ $peminjaman->tanggal_kembali_aktual->format('d/m/Y') }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($peminjaman->status == 'dipinjam')
                                                <span class="badge bg-info">Dipinjam</span>
                                            @elseif($peminjaman->status == 'dikembalikan')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @elseif($peminjaman->status == 'terlambat')
                                                <span class="badge bg-danger">Terlambat</span>
                                            @elseif($peminjaman->status == 'hilang')
                                                <span class="badge bg-dark">Hilang</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ Str::limit($peminjaman->keterangan ?? '-', 50) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $peminjamans->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center">
                            <div class="text-muted">
                                <i class="bi bi-calendar-x display-1"></i>
                                <h4>Tidak ada data peminjaman</h4>
                                <p>Tidak ada peminjaman pada periode yang dipilih.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection