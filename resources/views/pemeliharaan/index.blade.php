<x-main-layout titlePage="{{ __('Manajemen Pemeliharaan') }}">
    <style>
    /* Modern Pemeliharaan Styles */
    .pemeliharaan-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .header-section {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .header-section h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .header-section h4 i {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .stats-card {
        background: #f3f4f6;
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1px solid #e5e7eb;
    }

    .stats-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .stats-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .pemeliharaan-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .pemeliharaan-card:hover {
        border-color: #1a1a1a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-dikirim { background: #dbeafe; color: #1e40af; }
    .status-dalam_perbaikan { background: #fef3c7; color: #d97706; }
    .status-menunggu_approval { background: #fed7aa; color: #ea580c; }
    .status-selesai { background: #1a1a1a; color: #fafafa; }
    .status-dibatalkan { background: #f3f4f6; color: #6b7280; }
    .status-tidak_bisa_diperbaiki { background: #fee2e2; color: #dc2626; }

    .jenis-badge {
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
    }

    .jenis-rusak_ringan { background: #fef3c7; color: #d97706; }
    .jenis-rusak_berat { background: #fee2e2; color: #dc2626; }

    .cost-info {
        font-size: 0.9rem;
        color: #1a1a1a;
        font-weight: 600;
    }

    .vendor-info {
        color: #6b7280;
        font-size: 0.8rem;
    }
    </style>

    <div class="pemeliharaan-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <h4>
                    <i class="fas fa-tools"></i>
                    Manajemen Pemeliharaan Barang
                </h4>
                @can('manage pemeliharaan')
                <a href="{{ route('pemeliharaan.create') }}" class="btn px-4 py-2"
                   style="background: #fafafa; color: #1a1a1a; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Pemeliharaan
                </a>
                @endcan
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $statistics['total_pemeliharaan'] }}</h4>
                    <p class="stats-label">Total Pemeliharaan</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $statistics['dalam_perbaikan'] }}</h4>
                    <p class="stats-label">Dalam Perbaikan</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $statistics['menunggu_approval'] }}</h4>
                    <p class="stats-label">Menunggu Approval</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">Rp {{ number_format($statistics['total_biaya_bulan_ini'], 0, ',', '.') }}</h4>
                    <p class="stats-label">Biaya Bulan Ini</p>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: #fafafa; border-radius: 12px;">
                    <div class="card-body">
                        <form method="GET" action="{{ route('pemeliharaan.index') }}">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="position-relative">
                                        <i class="fas fa-search position-absolute" 
                                           style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; z-index: 10;"></i>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Cari kode, vendor, atau barang..."
                                               value="{{ request('search') }}"
                                               style="border-radius: 8px; border: 1px solid #e5e7eb; padding-left: 40px;">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-select" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                                        <option value="">Semua Status</option>
                                        <option value="dikirim" {{ request('status') === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="dalam_perbaikan" {{ request('status') === 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                        <option value="menunggu_approval" {{ request('status') === 'menunggu_approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="vendor" class="form-control" 
                                           placeholder="Filter vendor..."
                                           value="{{ request('vendor') }}"
                                           style="border-radius: 8px; border: 1px solid #e5e7eb;">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn w-100" 
                                            style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500;">
                                        <i class="fas fa-search me-1"></i>
                                        Cari
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemeliharaan List -->
        <div class="row">
            @forelse ($pemeliharaan as $item)
                <div class="col-12 col-lg-6 mb-3">
                    <div class="pemeliharaan-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1" style="color: #1a1a1a; font-weight: 600;">
                                    {{ $item->kode_pemeliharaan }}
                                </h6>
                                <small style="color: #6b7280;">{{ $item->barang->nama_barang }}</small>
                                <span class="jenis-badge jenis-{{ $item->jenis_kerusakan }} ms-2">
                                    {{ ucwords(str_replace('_', ' ', $item->jenis_kerusakan)) }}
                                </span>
                            </div>
                            <span class="status-badge status-{{ $item->status }}">
                                {{ ucwords(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">VENDOR</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->nama_vendor }}</div>
                                @if($item->pic_vendor)
                                    <small class="vendor-info">PIC: {{ $item->pic_vendor }}</small>
                                @endif
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">JUMLAH</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->jumlah_dipelihara }} unit</div>
                                @if($item->status === 'selesai')
                                    <small style="color: #059669;">{{ $item->jumlah_berhasil_diperbaiki }} berhasil</small>
                                @endif
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">TGL KIRIM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->tanggal_kirim->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">BIAYA</small>
                                <div class="cost-info">
                                    @if($item->biaya_aktual)
                                        Rp {{ number_format($item->biaya_aktual, 0, ',', '.') }}
                                    @elseif($item->estimasi_biaya)
                                        Est. Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}
                                    @else
                                        <span style="color: #6b7280;">Belum ada</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('pemeliharaan.show', $item->id) }}" class="btn btn-sm px-3 py-1"
                               style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 6px; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if(!in_array($item->status, ['selesai', 'dibatalkan', 'tidak_bisa_diperbaiki']))
                            @can('manage pemeliharaan')
                                <a href="{{ route('pemeliharaan.edit', $item->id) }}" class="btn btn-sm px-3 py-1"
                                   style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 6px; font-size: 0.8rem;">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                            @endcan
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5" style="background: #fafafa; border-radius: 12px; border: 2px dashed #e5e7eb;">
                        <div class="mb-3">
                            <i class="fas fa-tools" style="font-size: 3rem; color: #9ca3af;"></i>
                        </div>
                        <h5 class="mb-2" style="color: #1a1a1a;">Belum Ada Data Pemeliharaan</h5>
                        <p class="mb-4" style="color: #6b7280;">
                            Data pemeliharaan belum tersedia. Silakan tambah pemeliharaan baru.
                        </p>
                        @can('manage pemeliharaan')
                        <a href="{{ route('pemeliharaan.create') }}" class="btn px-4 py-2" 
                           style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Pemeliharaan Pertama
                        </a>
                        @endcan
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination dengan info -->
        @if($pemeliharaan->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div>
                <small class="text-muted">
                    Menampilkan {{ $pemeliharaan->firstItem() ?: 0 }} - {{ $pemeliharaan->lastItem() ?: 0 }} 
                    dari {{ $pemeliharaan->total() }} pemeliharaan
                </small>
            </div>
            <div>
                {{ $pemeliharaan->appends(request()->query())->simplePaginate() }}
            </div>
        </div>
        @endif
    </div>
</x-main-layout>