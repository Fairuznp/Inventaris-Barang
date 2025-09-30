<!-- Modern Data Display -->
<div class="row g-3">
    <!-- Basic Information Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: #fafafa; border-radius: 12px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="color: #1a1a1a;">
                    <i class="fas fa-info-circle me-2" style="color: #6b7280;"></i>
                    Informasi Dasar
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Nama Barang</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ $barang->nama_barang }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Kode Barang</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ $barang->kode_barang }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Kategori</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ $barang->kategori->nama_kategori }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Lokasi</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ $barang->lokasi->nama_lokasi }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Satuan</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ $barang->satuan }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Tanggal Pengadaan</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1.1rem;">{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Peminjaman Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: #fafafa; border-radius: 12px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="color: #1a1a1a;">
                    <i class="fas fa-handshake me-2" style="color: #6b7280;"></i>
                    Status Peminjaman
                </h5>
                
                <div class="d-flex align-items-center p-3 rounded" 
                     style="background: {{ ($barang->dapat_dipinjam ?? true) ? 'rgba(34, 197, 94, 0.05)' : 'rgba(239, 68, 68, 0.05)' }}; 
                            border: 1px solid {{ ($barang->dapat_dipinjam ?? true) ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)' }};">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                         style="width: 50px; height: 50px; 
                                background: {{ ($barang->dapat_dipinjam ?? true) ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }};">
                        <i class="fas {{ ($barang->dapat_dipinjam ?? true) ? 'fa-handshake' : 'fa-ban' }}" 
                           style="color: {{ ($barang->dapat_dipinjam ?? true) ? '#16a34a' : '#dc2626' }}; font-size: 1.2rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold mb-1" style="color: {{ ($barang->dapat_dipinjam ?? true) ? '#16a34a' : '#dc2626' }}; font-size: 1.1rem;">
                            {{ ($barang->dapat_dipinjam ?? true) ? 'Dapat Dipinjam' : 'Tidak Dapat Dipinjam' }}
                        </div>
                        <div style="color: #6b7280; font-size: 0.875rem;">
                            {{ ($barang->dapat_dipinjam ?? true) ? 'Barang ini tersedia untuk dipinjam' : 'Barang ini tidak tersedia untuk dipinjam' }}
                        </div>
                        @if($barang->dapat_dipinjam ?? true)
                            <div class="mt-2">
                                <small class="badge px-2 py-1" style="background: rgba(34, 197, 94, 0.1); color: #16a34a; border-radius: 6px;">
                                    <i class="fas fa-check me-1"></i>
                                    Stok Tersedia: {{ $barang->stok_baik_tersedia }} {{ $barang->satuan }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Metadata Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: #fafafa; border-radius: 12px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3" style="color: #1a1a1a;">
                    <i class="fas fa-clock me-2" style="color: #6b7280;"></i>
                    Informasi Sistem
                </h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Dibuat Pada</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1rem;">{{ $barang->created_at->translatedFormat('d F Y, H:i') }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #f3f4f6; border: 1px solid #e5e7eb;">
                            <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500; text-transform: uppercase; margin-bottom: 4px;">Terakhir Diperbarui</div>
                            <div class="fw-semibold" style="color: #1a1a1a; font-size: 1rem;">{{ $barang->updated_at->translatedFormat('d F Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}

/* Progress Bar Style */
.progress-bar-custom {
    height: 6px;
    border-radius: 3px;
    background: #f3f4f6;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    transition: width 0.3s ease;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.col-12:nth-child(1) .card { animation: fadeInUp 0.5s ease-out 0.1s both; }
.col-12:nth-child(2) .card { animation: fadeInUp 0.5s ease-out 0.2s both; }
.col-12:nth-child(3) .card { animation: fadeInUp 0.5s ease-out 0.3s both; }
</style>