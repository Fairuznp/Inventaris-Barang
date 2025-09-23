@csrf
<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Kode Barang" name="kode_barang" :value="$barang->kode_barang" />
    </div>
    <div class="col-md-6">
        <x-form-input label="Nama Barang" name="nama_barang" :value="$barang->nama_barang" />
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-select label="Kategori" name="kategori_id" :value="$barang->kategori_id" 
            :option-data="$kategori" option-label="nama_kategori" option-value="id" />
    </div>
    <div class="col-md-6">
        <x-form-select label="Lokasi" name="lokasi_id" :value="$barang->lokasi_id"
            :option-data="$lokasi" option-label="nama_lokasi" option-value="id" />
    </div>
</div>

<!-- Jumlah berdasarkan kondisi -->
<div class="mb-4">
    <label class="form-label fw-bold" style="color: #1a1a1a;">Jumlah Barang per Kondisi</label>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100" style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-2" style="color: #16a34a;"></i>
                        <span class="fw-semibold" style="color: #16a34a;">Kondisi Baik</span>
                    </div>
                    <input type="number" 
                           class="form-control @error('jumlah_baik') is-invalid @enderror" 
                           name="jumlah_baik" 
                           value="{{ old('jumlah_baik', $barang->jumlah_baik ?? 0) }}" 
                           min="0" 
                           placeholder="0"
                           style="border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 6px;">
                    @error('jumlah_baik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100" style="background: rgba(245, 158, 11, 0.05); border: 1px solid rgba(245, 158, 11, 0.2); border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #d97706;"></i>
                        <span class="fw-semibold" style="color: #d97706;">Rusak Ringan</span>
                    </div>
                    <input type="number" 
                           class="form-control @error('jumlah_rusak_ringan') is-invalid @enderror" 
                           name="jumlah_rusak_ringan" 
                           value="{{ old('jumlah_rusak_ringan', $barang->jumlah_rusak_ringan ?? 0) }}" 
                           min="0" 
                           placeholder="0"
                           style="border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 6px;">
                    @error('jumlah_rusak_ringan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-times-circle me-2" style="color: #dc2626;"></i>
                        <span class="fw-semibold" style="color: #dc2626;">Rusak Berat</span>
                    </div>
                    <input type="number" 
                           class="form-control @error('jumlah_rusak_berat') is-invalid @enderror" 
                           name="jumlah_rusak_berat" 
                           value="{{ old('jumlah_rusak_berat', $barang->jumlah_rusak_berat ?? 0) }}" 
                           min="0" 
                           placeholder="0"
                           style="border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 6px;">
                    @error('jumlah_rusak_berat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Real-time -->
    <div class="mt-3 p-3" style="background: #f3f4f6; border-radius: 8px;">
        <div class="d-flex justify-content-between align-items-center">
            <span class="fw-semibold" style="color: #1a1a1a;">Total Barang:</span>
            <span id="total-barang" class="fw-bold fs-5" style="color: #1a1a1a;">0</span>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6">
        <x-form-input label="Satuan" name="satuan" :value="$barang->satuan" />
    </div>
    <div class="col-md-6">
        @php
        $tanggal = $barang->tanggal_pengadaan ? 
            date('Y-m-d', strtotime($barang->tanggal_pengadaan)) : null;
        @endphp
        <x-form-input label="Tanggal Pengadaan" name="tanggal_pengadaan" type="date" :value="$tanggal" />
    </div>
</div>

<div class="mb-3">
    <x-form-input label="Gambar Barang" name="gambar" type="file" />
</div>

<div class="mt-4">
    <x-primary-button>
        {{ isset($update) ? __('Update') : __('Simpan') }}
    </x-primary-button>

    <x-tombol-kembali :href="route('barang.index')" />
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = {
        baik: document.querySelector('input[name="jumlah_baik"]'),
        rusakRingan: document.querySelector('input[name="jumlah_rusak_ringan"]'),
        rusakBerat: document.querySelector('input[name="jumlah_rusak_berat"]')
    };
    
    const totalElement = document.getElementById('total-barang');
    
    function updateTotal() {
        const baik = parseInt(inputs.baik.value) || 0;
        const rusakRingan = parseInt(inputs.rusakRingan.value) || 0;
        const rusakBerat = parseInt(inputs.rusakBerat.value) || 0;
        
        const total = baik + rusakRingan + rusakBerat;
        totalElement.textContent = total;
        
        // Update warna berdasarkan total
        if (total === 0) {
            totalElement.style.color = '#6b7280';
        } else {
            totalElement.style.color = '#1a1a1a';
        }
    }
    
    // Event listeners untuk semua input
    Object.values(inputs).forEach(input => {
        input.addEventListener('input', updateTotal);
        input.addEventListener('change', updateTotal);
    });
    
    // Update total saat halaman dimuat
    updateTotal();
});
</script>
@endpush