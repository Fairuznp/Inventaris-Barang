<!-- Modern Image Display Card -->
<div class="card h-100 border-0 shadow-sm" style="background: #fafafa; border-radius: 12px;">
    <div class="card-body p-4">
        <div class="text-center">
            <!-- Kode Barang Badge -->
            <div class="mb-3">
                <span class="badge px-3 py-2" style="background: rgba(26, 26, 26, 0.1); color: #1a1a1a; font-size: 0.875rem; border-radius: 8px; font-weight: 600;">
                    {{ $barang->kode_barang }}
                </span>
            </div>
            
            <!-- Image Display -->
            <div class="mb-4">
                @if($barang->gambar)
                    <img src="{{ asset('gambar-barang/' . $barang->gambar) }}" 
                         alt="{{ $barang->nama_barang }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-width: 100%; max-height: 300px; object-fit: cover; border: 3px solid #f3f4f6;">
                @else
                    <div class="d-flex align-items-center justify-content-center rounded shadow-sm"
                         style="width: 100%; height: 300px; background: #f3f4f6; border: 3px solid #e5e7eb;">
                        <div class="text-center">
                            <i class="fas fa-image mb-3" style="color: #6b7280; font-size: 3rem;"></i>
                            <div style="color: #6b7280; font-weight: 500;">
                                Tidak ada gambar
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Quick Stats -->
            <div class="row g-2">
                <div class="col-12">
                    <div class="p-3 rounded" style="background: rgba(26, 26, 26, 0.05); border: 1px solid rgba(26, 26, 26, 0.1);">
                        <div style="color: #6b7280; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">Total</div>
                        <div class="fw-bold" style="color: #1a1a1a; font-size: 1.25rem;">
                            {{ $barang->jumlah_stok }}
                        </div>
                        <div style="color: #6b7280; font-size: 0.75rem;">{{ $barang->satuan }}</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded" style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2);">
                        <div style="color: #16a34a; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">Kondisi Baik</div>
                        <div class="fw-bold" style="color: #16a34a; font-size: 1.25rem;">
                            {{ $barang->jumlah_baik }}
                        </div>
                        <div style="color: #16a34a; font-size: 0.75rem;">{{ $barang->satuan }}</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded" style="background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.1);">
                        <div style="color: #d97706; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">Kondisi Baik</div>
                        <div class="fw-bold" style="color: #d97706; font-size: 1.25rem;">
                            {{ $barang->jumlah_rusak_ringan}}
                        </div>
                        <div style="color: #d97706; font-size: 0.75rem;">{{ $barang->satuan }}</div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="p-3 rounded" style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);">
                        <div style="color: #dc2626; font-size: 0.75rem; font-weight: 500; text-transform: uppercase;">Kondisi Baik</div>
                        <div class="fw-bold" style="color: #dc2626; font-size: 1.25rem;">
                            {{ $barang->jumlah_rusak_berat }}
                        </div>
                        <div style="color: #dc2626; font-size: 0.75rem;">{{ $barang->satuan }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
</style>