<x-main-layout titlePage="{{ __('Detail Pemeliharaan') }}">
    <style>
    .detail-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .detail-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        text-align: center;
    }

    .info-section {
        margin-bottom: 25px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 10px;
    }

    .section-title i {
        margin-right: 10px;
        color: #6b7280;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: #6b7280;
        min-width: 150px;
    }

    .info-value {
        color: #1a1a1a;
        font-weight: 500;
        text-align: right;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-dikirim { background: #dbeafe; color: #1e40af; }
    .status-dalam_perbaikan { background: #fef3c7; color: #d97706; }
    .status-menunggu_approval { background: #fed7aa; color: #ea580c; }
    .status-selesai { background: #1a1a1a; color: #fafafa; }
    .status-dibatalkan { background: #f3f4f6; color: #6b7280; }
    .status-tidak_bisa_diperbaiki { background: #fee2e2; color: #dc2626; }

    .timeline {
        position: relative;
        padding-left: 20px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 15px;
        padding: 15px;
        background: #fafafa;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #1a1a1a;
        border: 3px solid #fafafa;
    }

    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .photo-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .photo-item img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .photo-item img:hover {
        transform: scale(1.05);
    }

    .cost-summary {
        background: linear-gradient(135deg, #1a1a1a 0%, #374151 100%);
        color: #fafafa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .cost-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cost-item:last-child {
        border-bottom: none;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .document-link {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background: #f3f4f6;
        color: #1a1a1a;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .document-link:hover {
        background: #e5e7eb;
        color: #1a1a1a;
        text-decoration: none;
    }

    .action-buttons {
        position: sticky;
        bottom: 20px;
        background: #fafafa;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    </style>

    <div class="detail-container">
        <div class="container">
            <!-- Header -->
            <div class="detail-header">
                <h4><i class="fas fa-tools me-2"></i>{{ $pemeliharaan->kode_pemeliharaan }}</h4>
                <p class="mb-2">{{ $pemeliharaan->barang->nama_barang }} - {{ $pemeliharaan->barang->kode_barang }}</p>
                <span class="status-badge status-{{ $pemeliharaan->status }}">
                    {{ ucwords(str_replace('_', ' ', $pemeliharaan->status)) }}
                </span>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Informasi Barang -->
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-box"></i>
                                Informasi Barang
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Nama Barang:</span>
                                <span class="info-value">{{ $pemeliharaan->barang->nama_barang }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kode Barang:</span>
                                <span class="info-value">{{ $pemeliharaan->barang->kode_barang }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Kategori:</span>
                                <span class="info-value">{{ $pemeliharaan->barang->kategori->nama_kategori }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Lokasi:</span>
                                <span class="info-value">{{ $pemeliharaan->barang->lokasi->nama_lokasi }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jenis Kerusakan:</span>
                                <span class="info-value">
                                    <span class="badge bg-warning text-dark">
                                        {{ ucwords(str_replace('_', ' ', $pemeliharaan->jenis_kerusakan)) }}
                                    </span>
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Jumlah Dipelihara:</span>
                                <span class="info-value">{{ $pemeliharaan->jumlah_dipelihara }} unit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi Kerusakan -->
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-exclamation-triangle"></i>
                                Deskripsi Kerusakan
                            </div>
                            <p class="mb-0" style="line-height: 1.6;">{{ $pemeliharaan->deskripsi_kerusakan }}</p>
                        </div>
                    </div>

                    <!-- Informasi Vendor -->
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-store"></i>
                                Informasi Vendor
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Nama Vendor:</span>
                                <span class="info-value">{{ $pemeliharaan->nama_vendor }}</span>
                            </div>
                            @if($pemeliharaan->pic_vendor)
                            <div class="info-row">
                                <span class="info-label">PIC:</span>
                                <span class="info-value">{{ $pemeliharaan->pic_vendor }}</span>
                            </div>
                            @endif
                            @if($pemeliharaan->kontak_vendor)
                            <div class="info-row">
                                <span class="info-label">Kontak:</span>
                                <span class="info-value">{{ $pemeliharaan->kontak_vendor }}</span>
                            </div>
                            @endif
                            @if($pemeliharaan->alamat_vendor)
                            <div class="info-row">
                                <span class="info-label">Alamat:</span>
                                <span class="info-value">{{ $pemeliharaan->alamat_vendor }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timeline & Progress -->
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-history"></i>
                                Timeline Pemeliharaan
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Tanggal Kirim:</span>
                                <span class="info-value">{{ $pemeliharaan->tanggal_kirim->format('d/m/Y') }}</span>
                            </div>
                            @if($pemeliharaan->estimasi_selesai)
                            <div class="info-row">
                                <span class="info-label">Estimasi Selesai:</span>
                                <span class="info-value">{{ $pemeliharaan->estimasi_selesai->format('d/m/Y') }}</span>
                            </div>
                            @endif
                            @if($pemeliharaan->tanggal_selesai_aktual)
                            <div class="info-row">
                                <span class="info-label">Selesai Aktual:</span>
                                <span class="info-value">{{ $pemeliharaan->tanggal_selesai_aktual->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Durasi:</span>
                                <span class="info-value">{{ $pemeliharaan->durasi_pemeliharaan }} hari</span>
                            </div>
                            @endif
                            @if($pemeliharaan->terlambat)
                            <div class="info-row">
                                <span class="info-label">Status Waktu:</span>
                                <span class="info-value">
                                    <span class="badge bg-danger">Terlambat</span>
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- History Status -->
                    @if($pemeliharaan->history->count() > 0)
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-list-alt"></i>
                                Riwayat Perubahan Status
                            </div>
                            
                            <div class="timeline">
                                @foreach($pemeliharaan->history as $history)
                                <div class="timeline-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $history->status_label }}</h6>
                                            @if($history->keterangan)
                                                <p class="mb-1 text-muted">{{ $history->keterangan }}</p>
                                            @endif
                                            @if($history->biaya_perubahan)
                                                <small class="text-success">
                                                    <i class="fas fa-money-bill-wave me-1"></i>
                                                    Rp {{ number_format($history->biaya_perubahan, 0, ',', '.') }}
                                                </small>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $history->created_at->format('d/m/Y H:i') }}</small>
                                            @if($history->user)
                                                <br><small class="text-muted">oleh {{ $history->user->name }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <!-- Ringkasan Biaya -->
                    <div class="detail-card">
                        <div class="cost-summary">
                            <h5 class="mb-3"><i class="fas fa-calculator me-2"></i>Ringkasan Biaya</h5>
                            
                            @if($pemeliharaan->estimasi_biaya)
                            <div class="cost-item">
                                <span>Estimasi Biaya:</span>
                                <span>Rp {{ number_format($pemeliharaan->estimasi_biaya, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            
                            @if($pemeliharaan->biaya_aktual)
                            <div class="cost-item">
                                <span>Biaya Aktual:</span>
                                <span>Rp {{ number_format($pemeliharaan->biaya_aktual, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($pemeliharaan->selisih_biaya !== null)
                            <div class="cost-item">
                                <span>Selisih:</span>
                                <span class="{{ $pemeliharaan->selisih_biaya >= 0 ? 'text-warning' : 'text-success' }}">
                                    {{ $pemeliharaan->selisih_biaya >= 0 ? '+' : '' }}Rp {{ number_format($pemeliharaan->selisih_biaya, 0, ',', '.') }}
                                </span>
                            </div>
                            @endif
                            @else
                            <div class="cost-item">
                                <span>Biaya Aktual:</span>
                                <span class="text-muted">Belum ada</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Hasil Pemeliharaan -->
                    @if($pemeliharaan->status === 'selesai')
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-chart-pie"></i>
                                Hasil Pemeliharaan
                            </div>
                            
                            <div class="info-row">
                                <span class="info-label">Berhasil Diperbaiki:</span>
                                <span class="info-value text-success">{{ $pemeliharaan->jumlah_berhasil_diperbaiki }} unit</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tidak Bisa Diperbaiki:</span>
                                <span class="info-value text-danger">{{ $pemeliharaan->jumlah_tidak_bisa_diperbaiki }} unit</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Efisiensi:</span>
                                <span class="info-value">
                                    <span class="badge {{ $pemeliharaan->efisiensi_perbaikan >= 80 ? 'bg-success' : ($pemeliharaan->efisiensi_perbaikan >= 60 ? 'bg-warning' : 'bg-danger') }}">
                                        {{ number_format($pemeliharaan->efisiensi_perbaikan, 1) }}%
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan -->
                    @if($pemeliharaan->catatan_vendor || $pemeliharaan->catatan_internal)
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-sticky-note"></i>
                                Catatan
                            </div>
                            
                            @if($pemeliharaan->catatan_vendor)
                            <div class="mb-3">
                                <h6 class="text-muted">Catatan Vendor:</h6>
                                <p class="mb-0">{{ $pemeliharaan->catatan_vendor }}</p>
                            </div>
                            @endif
                            
                            @if($pemeliharaan->catatan_internal)
                            <div class="mb-0">
                                <h6 class="text-muted">Catatan Internal:</h6>
                                <p class="mb-0">{{ $pemeliharaan->catatan_internal }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Dokumentasi -->
                    @if($pemeliharaan->foto_sebelum || $pemeliharaan->foto_sesudah || $pemeliharaan->dokumen_invoice)
                    <div class="detail-card">
                        <div class="info-section">
                            <div class="section-title">
                                <i class="fas fa-camera"></i>
                                Dokumentasi
                            </div>
                            
                            @if($pemeliharaan->foto_sebelum)
                            <h6 class="text-muted mb-2">Foto Sebelum:</h6>
                            <div class="photo-grid">
                                @foreach($pemeliharaan->foto_sebelum as $foto)
                                <div class="photo-item">
                                    <img src="{{ asset('foto-pemeliharaan/' . $foto) }}" alt="Foto Sebelum" 
                                         onclick="showPhotoModal('{{ asset('foto-pemeliharaan/' . $foto) }}')">
                                </div>
                                @endforeach
                            </div>
                            @endif
                            
                            @if($pemeliharaan->foto_sesudah)
                            <h6 class="text-muted mb-2 mt-3">Foto Sesudah:</h6>
                            <div class="photo-grid">
                                @foreach($pemeliharaan->foto_sesudah as $foto)
                                <div class="photo-item">
                                    <img src="{{ asset('foto-pemeliharaan/' . $foto) }}" alt="Foto Sesudah" 
                                         onclick="showPhotoModal('{{ asset('foto-pemeliharaan/' . $foto) }}')">
                                </div>
                                @endforeach
                            </div>
                            @endif
                            
                            @if($pemeliharaan->dokumen_invoice)
                            <div class="mt-3">
                                <h6 class="text-muted mb-2">Invoice:</h6>
                                <a href="{{ asset('foto-pemeliharaan/' . $pemeliharaan->dokumen_invoice) }}" 
                                   target="_blank" class="document-link">
                                    <i class="fas fa-file-pdf me-2"></i>
                                    Lihat Invoice
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <div class="d-flex gap-2">
                        @if(!in_array($pemeliharaan->status, ['selesai', 'dibatalkan', 'tidak_bisa_diperbaiki']))
                        @can('manage pemeliharaan')
                            <a href="{{ route('pemeliharaan.edit', $pemeliharaan->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Update Status
                            </a>
                        @endcan
                        @endif
                        
                        <button type="button" class="btn btn-info" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Photo Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img id="modalPhoto" src="" class="w-100" style="max-height: 80vh; object-fit: contain;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showPhotoModal(photoUrl) {
        document.getElementById('modalPhoto').src = photoUrl;
        new bootstrap.Modal(document.getElementById('photoModal')).show();
    }
    </script>
</x-main-layout>