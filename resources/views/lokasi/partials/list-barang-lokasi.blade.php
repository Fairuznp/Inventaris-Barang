<!-- Modern Card Layout untuk Barang di Lokasi -->
<div class="row g-3">
    @forelse ($barangs as $barang)
        <div class="col-12">
            <div class="card h-100 shadow-sm border-0" 
                 style="background: #fafafa; border-radius: 12px; transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <!-- Gambar Barang -->
                        <div class="col-md-2 col-3 mb-3 mb-md-0">
                            <div class="text-center">
                                @if($barang->gambar)
                                    <img src="{{ asset('gambar-barang/' . $barang->gambar) }}" 
                                         alt="{{ $barang->nama_barang }}"
                                         class="img-fluid rounded"
                                         style="width: 80px; height: 80px; object-fit: cover; border: 2px solid #f3f4f6;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded"
                                         style="width: 80px; height: 80px; background: #f3f4f6; border: 2px solid #e5e7eb;">
                                        <i class="fas fa-image" style="color: #6b7280; font-size: 1.5rem;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Info Barang -->
                        <div class="col-md-6 col-9">
                            <div class="mb-2">
                                <h5 class="fw-bold mb-1" style="color: #1a1a1a; font-size: 1.1rem;">
                                    {{ $barang->nama_barang }}
                                </h5>
                                <span class="badge px-3 py-2" 
                                      style="background: rgba(26, 26, 26, 0.1); color: #1a1a1a; font-size: 0.75rem; border-radius: 8px;">
                                    {{ $barang->kode_barang }}
                                </span>
                            </div>
                            
                            <div class="row g-2 small">
                                <div class="col-md-6">
                                    <div style="color: #6b7280;">
                                        <i class="fas fa-tag me-1" style="font-size: 0.75rem;"></i>
                                        <strong>Kategori:</strong>
                                    </div>
                                    <div style="color: #1a1a1a; font-weight: 500;">
                                        {{ $barang->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="color: #6b7280;">
                                        <i class="fas fa-calendar me-1" style="font-size: 0.75rem;"></i>
                                        <strong>Ditambahkan:</strong>
                                    </div>
                                    <div style="color: #1a1a1a; font-weight: 500;">
                                        {{ $barang->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stok dan Kondisi -->
                        <div class="col-md-4 col-12 text-md-center">
                            <div class="mb-2">
                                <div style="color: #6b7280; font-size: 0.8rem; font-weight: 500;">TOTAL STOK</div>
                                <div class="fw-bold" style="color: #1a1a1a; font-size: 1.2rem;">
                                    {{ $barang->jumlah_stok }}
                                </div>
                                <small style="color: #6b7280;">{{ $barang->satuan }}</small>
                                
                                <!-- Detail per kondisi -->
                                <div class="row g-1 mt-2">
                                    @if($barang->jumlah_baik > 0)
                                    <div class="col-4">
                                        <div class="text-center p-1" style="background: rgba(34, 197, 94, 0.1); border-radius: 4px;">
                                            <div style="color: #16a34a; font-size: 0.7rem; font-weight: 600;">{{ $barang->jumlah_baik }}</div>
                                            <div style="color: #16a34a; font-size: 0.6rem;">Baik</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($barang->jumlah_rusak_ringan > 0)
                                    <div class="col-4">
                                        <div class="text-center p-1" style="background: rgba(245, 158, 11, 0.1); border-radius: 4px;">
                                            <div style="color: #d97706; font-size: 0.7rem; font-weight: 600;">{{ $barang->jumlah_rusak_ringan }}</div>
                                            <div style="color: #d97706; font-size: 0.6rem;">Rusak Ringan</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($barang->jumlah_rusak_berat > 0)
                                    <div class="col-4">
                                        <div class="text-center p-1" style="background: rgba(239, 68, 68, 0.1); border-radius: 4px;">
                                            <div style="color: #dc2626; font-size: 0.7rem; font-weight: 600;">{{ $barang->jumlah_rusak_berat }}</div>
                                            <div style="color: #dc2626; font-size: 0.6rem;">Rusak Berat</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @can('manage barang')
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-sm px-3 py-2" 
                                        onclick="window.location.href='{{ route('barang.edit', $barang->id) }}'"
                                        style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='#374151'"
                                        onmouseout="this.style.background='#1a1a1a'">
                                    <i class="fas fa-edit me-1" style="font-size: 0.75rem;"></i>
                                    Edit
                                </button>
                                @can('delete barang')
                                <button type="button" class="btn btn-sm px-3 py-2" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDelete" 
                                        data-name="{{ $barang->nama_barang }}" 
                                        data-url="{{ route('barang.destroy', $barang->id) }}"
                                        style="background: rgba(239, 68, 68, 0.1); color: #dc2626; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;"
                                        onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'"
                                        onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'">
                                    <i class="fas fa-trash me-1" style="font-size: 0.75rem;"></i>
                                    Hapus
                                </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5" style="background: #fafafa; border-radius: 12px; border: 2px dashed #e5e7eb;">
                <div class="mb-3">
                    <i class="fas fa-box-open" style="font-size: 3rem; color: #9ca3af;"></i>
                </div>
                <h5 class="mb-2" style="color: #1a1a1a;">Belum Ada Barang di Lokasi Ini</h5>
                <p class="mb-4" style="color: #6b7280;">
                    Lokasi <strong>{{ $lokasi->nama_lokasi }}</strong> belum memiliki barang yang tersimpan.
                </p>
                @can('manage barang')
                <a href="{{ route('barang.create') }}" class="btn px-4 py-2" 
                   style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Barang
                </a>
                @endcan
            </div>
        </div>
    @endforelse
</div>

<style>
/* Hover effects */
.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
}

.card {
    transition: all 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-body {
        padding: 1rem !important;
    }
    
    .row.g-2 > * {
        padding-right: 0.25rem !important;
        padding-left: 0.25rem !important;
    }
}

/* Loading animation untuk card */
.card {
    animation: fadeInUp 0.5s ease-out forwards;
}

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

/* Stagger animation */
.col-12:nth-child(1) .card { animation-delay: 0.1s; }
.col-12:nth-child(2) .card { animation-delay: 0.2s; }
.col-12:nth-child(3) .card { animation-delay: 0.3s; }
.col-12:nth-child(4) .card { animation-delay: 0.4s; }
.col-12:nth-child(5) .card { animation-delay: 0.5s; }
.col-12:nth-child(6) .card { animation-delay: 0.6s; }
</style>