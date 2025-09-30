<x-main-layout titlePage="{{ __('Daftar Peminjaman') }}">
    <style>
    /* Modern Peminjaman Styles */
    .peminjaman-container {
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

    .peminjaman-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }

    .peminjaman-card:hover {
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

    .status-dipinjam { background: #f3f4f6; color: #1a1a1a; }
    .status-dikembalikan { background: #1a1a1a; color: #fafafa; }
    .status-terlambat { background: #6b7280; color: #fafafa; }
    .status-hilang { background: #f3f4f6; color: #1a1a1a; border: 1px solid #6b7280; }
    </style>

    <div class="peminjaman-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center">
                <h4>
                    <i class="fas fa-handshake"></i>
                    Manajemen Peminjaman Barang
                </h4>
                @can('manage peminjaman')
                <a href="{{ route('peminjaman.create') }}" class="btn px-4 py-2"
                   style="background: #fafafa; color: #1a1a1a; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Peminjaman
                </a>
                @endcan
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $peminjaman->where('status', 'dipinjam')->count() }}</h4>
                    <p class="stats-label">Sedang Dipinjam</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $peminjaman->where('status', 'dikembalikan')->count() }}</h4>
                    <p class="stats-label">Dikembalikan</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $peminjaman->where('status', 'terlambat')->count() }}</h4>
                    <p class="stats-label">Terlambat</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stats-card">
                    <h4 class="stats-number">{{ $peminjaman->sum('jumlah') }}</h4>
                    <p class="stats-label">Total Unit</p>
                </div>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0" style="background: #fafafa; border-radius: 12px;">
                    <div class="card-body">
                        <form method="GET" action="{{ route('peminjaman.index') }}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="position-relative">
                                        <i class="fas fa-search position-absolute" 
                                           style="left: 12px; top: 50%; transform: translateY(-50%); color: #6b7280; z-index: 10;"></i>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Cari nama barang, kode, atau peminjam..."
                                               value="{{ request('search') }}"
                                               style="border-radius: 8px; border: 1px solid #e5e7eb; padding-left: 40px;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <select name="status" class="form-select" style="border-radius: 8px; border: 1px solid #e5e7eb;">
                                        <option value="">Semua Status</option>
                                        <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="hilang" {{ request('status') === 'hilang' ? 'selected' : '' }}>Hilang</option>
                                    </select>
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

        <!-- Peminjaman List -->
        <div class="row">
            @forelse ($peminjaman as $item)
                <div class="col-12 col-lg-6 mb-3">
                    <div class="peminjaman-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h6 class="mb-1" style="color: #1a1a1a; font-weight: 600;">
                                    {{ $item->barang->nama_barang }}
                                </h6>
                                <small style="color: #6b7280;">{{ $item->barang->kode_barang }}</small>
                            </div>
                            <span class="status-badge status-{{ $item->status }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">PEMINJAM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->nama_peminjam_lengkap }}</div>
                                @if($item->instansi_peminjam)
                                    <small style="color: #6b7280; font-size: 0.7rem;">{{ $item->instansi_peminjam }}</small>
                                @endif
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">JUMLAH</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->jumlah }} unit</div>
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">TGL PINJAM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $item->tanggal_pinjam->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">TGL KEMBALI</small>
                                <div style="color: #1a1a1a; font-weight: 500;">
                                    {{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d/m/Y') : '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-sm px-3 py-1"
                               style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 6px; font-size: 0.8rem;">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if($item->status === 'dipinjam')
                            @can('manage peminjaman')
                                <a href="{{ route('peminjaman.edit', $item->id) }}" class="btn btn-sm px-3 py-1"
                                   style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 6px; font-size: 0.8rem;">
                                    <i class="fas fa-undo"></i> Kembalikan
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
                            <i class="fas fa-handshake" style="font-size: 3rem; color: #9ca3af;"></i>
                        </div>
                        <h5 class="mb-2" style="color: #1a1a1a;">Belum Ada Data Peminjaman</h5>
                        <p class="mb-4" style="color: #6b7280;">
                            Data peminjaman belum tersedia. Silakan tambah peminjaman baru.
                        </p>
                        @can('manage peminjaman')
                        <a href="{{ route('peminjaman.create') }}" class="btn px-4 py-2" 
                           style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Peminjaman Pertama
                        </a>
                        @endcan
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($peminjaman->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>
</x-main-layout>