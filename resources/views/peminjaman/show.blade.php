<x-main-layout titlePage="{{ __('Detail Peminjaman') }}">
    <style>
    /* Modern Detail Styles */
    .detail-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .detail-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .detail-header {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 32px;
    }

    .info-section {
        background: #f3f4f6;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .info-title {
        color: #1a1a1a;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
    }

    .info-title i {
        margin-right: 8px;
        color: #6b7280;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #6b7280;
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: #1a1a1a;
        font-weight: 600;
        text-align: right;
    }

    .status-badge {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-dipinjam { background: #f3f4f6; color: #1a1a1a; }
    .status-dikembalikan { background: #1a1a1a; color: #fafafa; }
    .status-terlambat { background: #6b7280; color: #fafafa; }
    .status-hilang { background: #f3f4f6; color: #1a1a1a; border: 1px solid #6b7280; }

    .timeline-item {
        border-left: 2px solid #e5e7eb;
        padding-left: 20px;
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -5px;
        top: 0;
        width: 8px;
        height: 8px;
        background: #1a1a1a;
        border-radius: 50%;
    }

    .timeline-date {
        color: #6b7280;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .timeline-event {
        color: #1a1a1a;
        font-weight: 600;
        margin: 4px 0;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }
        
        .info-value {
            text-align: left;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
    </style>

    <div class="detail-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Header -->
                    <div class="detail-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-eye"></i>
                                Detail Peminjaman
                            </h4>
                            <span class="status-badge status-{{ $peminjaman->status }}">
                                {{ ucfirst($peminjaman->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Info Barang -->
                    <div class="info-section">
                        <h6 class="info-title">
                            <i class="fas fa-box"></i>
                            Informasi Barang
                        </h6>
                        <div class="info-row">
                            <span class="info-label">Nama Barang</span>
                            <span class="info-value">{{ $peminjaman->barang->nama_barang }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kode Barang</span>
                            <span class="info-value">{{ $peminjaman->barang->kode_barang }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kategori</span>
                            <span class="info-value">{{ $peminjaman->barang->kategori->nama_kategori }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Lokasi</span>
                            <span class="info-value">{{ $peminjaman->barang->lokasi->nama_lokasi }}</span>
                        </div>
                    </div>

                    <!-- Info Peminjam -->
                    <div class="info-section">
                        <h6 class="info-title">
                            <i class="fas fa-user"></i>
                            Informasi Peminjam
                        </h6>
                        <div class="info-row">
                            <span class="info-label">Nama Peminjam</span>
                            <span class="info-value">{{ $peminjaman->nama_peminjam_lengkap }}</span>
                        </div>
                        @if($peminjaman->kontak_peminjam)
                        <div class="info-row">
                            <span class="info-label">Kontak</span>
                            <span class="info-value">{{ $peminjaman->kontak_peminjam }}</span>
                        </div>
                        @endif
                        @if($peminjaman->instansi_peminjam)
                        <div class="info-row">
                            <span class="info-label">Instansi</span>
                            <span class="info-value">{{ $peminjaman->instansi_peminjam }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Info Peminjaman -->
                    <div class="info-section">
                        <h6 class="info-title">
                            <i class="fas fa-calendar"></i>
                            Informasi Peminjaman
                        </h6>
                        <div class="info-row">
                            <span class="info-label">Jumlah Dipinjam</span>
                            <span class="info-value">{{ $peminjaman->jumlah }} unit</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal Pinjam</span>
                            <span class="info-value">{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</span>
                        </div>
                        @if($peminjaman->tanggal_kembali)
                        <div class="info-row">
                            <span class="info-label">Tanggal Kembali (Rencana)</span>
                            <span class="info-value">{{ $peminjaman->tanggal_kembali->format('d F Y') }}</span>
                        </div>
                        @endif
                        @if($peminjaman->tanggal_kembali_aktual)
                        <div class="info-row">
                            <span class="info-label">Tanggal Kembali (Aktual)</span>
                            <span class="info-value">{{ $peminjaman->tanggal_kembali_aktual->format('d F Y') }}</span>
                        </div>
                        @endif
                        @if($peminjaman->keterangan)
                        <div class="info-row">
                            <span class="info-label">Keterangan</span>
                            <span class="info-value">{{ $peminjaman->keterangan }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Timeline -->
                    <div class="info-section">
                        <h6 class="info-title">
                            <i class="fas fa-history"></i>
                            Timeline Peminjaman
                        </h6>
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $peminjaman->created_at->format('d F Y, H:i') }}</div>
                            <div class="timeline-event">Peminjaman dibuat</div>
                        </div>
                        @if($peminjaman->tanggal_kembali_aktual)
                        <div class="timeline-item">
                            <div class="timeline-date">{{ $peminjaman->tanggal_kembali_aktual->format('d F Y') }}</div>
                            <div class="timeline-event">Barang {{ $peminjaman->status === 'dikembalikan' ? 'dikembalikan' : $peminjaman->status }}</div>
                        </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="detail-card">
                        <div class="action-buttons">
                            <a href="{{ route('peminjaman.index') }}" class="btn px-4 py-2"
                               style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 8px; text-decoration: none;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                            
                            @if($peminjaman->status === 'dipinjam')
                                @can('manage peminjaman')
                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn px-4 py-2"
                                   style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; text-decoration: none;">
                                    <i class="fas fa-undo me-2"></i>Proses Pengembalian
                                </a>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>