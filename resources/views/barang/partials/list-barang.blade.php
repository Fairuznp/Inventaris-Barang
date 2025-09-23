<div class="row g-4">
    @forelse ($barangs as $index => $barang)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="background: #fafafa; border-radius: 12px; transition: all 0.3s ease;">
                <!-- Card Header -->
                <div class="card-header border-0 d-flex justify-content-between align-items-center" style="background: transparent; padding: 1.25rem 1.25rem 0.75rem;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px; background: #f3f4f6; color: #1a1a1a;">
                            <i class="bi-box-seam" style="font-size: 16px;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold" style="color: #1a1a1a; font-size: 0.9rem;">
                                {{ $barang->kode_barang }}
                            </h6>
                            <small class="text-muted" style="color: #6b7280 !important; font-size: 0.75rem;">
                                Item #{{ $barangs->firstItem() + $index }}
                            </small>
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <span class="badge rounded-pill px-3 py-2" 
                          style="background: rgba(59, 130, 246, 0.1); color: #1a1a1a; font-size: 0.75rem; font-weight: 500;">
                        {{ $barang->kondisi }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="card-body" style="padding: 0.75rem 1.25rem 1.25rem;">
                    <!-- Nama Barang -->
                    <h5 class="card-title mb-3 fw-bold lh-base" style="color: #1a1a1a; font-size: 1.1rem;">
                        {{ $barang->nama_barang }}
                    </h5>

                    <!-- Info Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Kategori
                                </span>
                                <span class="fw-semibold mt-1" style="color: #1a1a1a; font-size: 0.875rem;">
                                    {{ $barang->kategori->nama_kategori }}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Lokasi
                                </span>
                                <span class="fw-semibold mt-1" style="color: #1a1a1a; font-size: 0.875rem;">
                                    {{ $barang->lokasi->nama_lokasi }}
                                </span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <span class="small fw-medium" style="color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Jumlah Stok
                                </span>
                                <span class="fw-bold mt-1 d-flex align-items-center" style="color: #1a1a1a; font-size: 1.25rem;">
                                    {{ $barang->jumlah }}
                                    <span class="ms-2 fw-normal" style="font-size: 0.875rem; color: #6b7280;">
                                        {{ $barang->satuan }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-end">
                        @can('manage barang')
                            <button type="button" class="btn btn-sm px-3 py-2" 
                                    onclick="window.location.href='{{ route('barang.show', $barang->id) }}'"
                                    style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;"
                                    onmouseover="this.style.background='#e5e7eb'"
                                    onmouseout="this.style.background='#f3f4f6'">
                                <i class="fas fa-eye me-1" style="font-size: 0.75rem;"></i>
                                Lihat
                            </button>
                            <button type="button" class="btn btn-sm px-3 py-2" 
                                    onclick="window.location.href='{{ route('barang.edit', $barang->id) }}'"
                                    style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; font-size: 0.8rem; transition: all 0.2s ease;"
                                    onmouseover="this.style.background='#374151'"
                                    onmouseout="this.style.background='#1a1a1a'">
                                <i class="fas fa-edit me-1" style="font-size: 0.75rem;"></i>
                                Edit
                            </button>
                        @endcan
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
        </div>
    @empty
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5" style="background: #fafafa; border-radius: 12px; border: 2px dashed #e5e7eb;">
                <div class="mb-3">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #9ca3af;"></i>
                </div>
                <h5 class="mb-2" style="color: #1a1a1a;">Belum Ada Data Barang</h5>
                <p class="mb-4" style="color: #6b7280;">
                    Data barang belum tersedia. Silakan tambah barang baru untuk memulai.
                </p>
                <a href="{{ route('barang.create') }}" class="btn px-4 py-2" 
                   style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px; font-weight: 500; text-decoration: none;">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Barang Pertama
                </a>
            </div>
        </div>
    @endforelse
</div>

<style>
.card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
}

@media (max-width: 768px) {
    .col-6 {
        margin-bottom: 1rem;
    }
    
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .d-flex.gap-2 .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Custom scrollbar untuk mobile */
@media (max-width: 768px) {
    .card-body::-webkit-scrollbar {
        width: 4px;
    }
    
    .card-body::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 4px;
    }
    
    .card-body::-webkit-scrollbar-thumb {
        background: #6b7280;
        border-radius: 4px;
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