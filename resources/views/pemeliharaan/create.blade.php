<x-main-layout titlePage="{{ __('Tambah Pemeliharaan') }}">
    <style>
    .form-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .form-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-header {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-section {
        margin-bottom: 30px;
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
    }

    .section-title i {
        margin-right: 8px;
        color: #6b7280;
    }

    .form-label {
        font-weight: 500;
        color: #374151;
        margin-bottom: 5px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        padding: 10px 12px;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a1a1a;
        box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
    }

    .btn-primary {
        background: #1a1a1a;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 500;
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 500;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s ease;
    }

    .upload-area:hover {
        border-color: #1a1a1a;
        background: #f3f4f6;
    }

    .stock-info {
        background: #e0f2fe;
        border: 1px solid #b3e5fc;
        border-radius: 8px;
        padding: 10px;
        font-size: 0.9rem;
        color: #0277bd;
    }
    </style>

    <div class="form-container">
        <div class="container">
            <div class="form-header">
                <h4><i class="fas fa-tools me-2"></i>Tambah Pemeliharaan Baru</h4>
                <p class="mb-0">Kirim barang rusak untuk diperbaiki oleh vendor terpercaya</p>
            </div>

            <form action="{{ route('pemeliharaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-card">
                    <!-- Informasi Barang -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-box"></i>
                            Informasi Barang
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="barang_id" class="form-label">Pilih Barang *</label>
                                <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" 
                                                data-rusak-ringan="{{ $barang->jumlah_rusak_ringan }}"
                                                data-rusak-berat="{{ $barang->jumlah_rusak_berat }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->kode_barang }} - {{ $barang->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kerusakan" class="form-label">Jenis Kerusakan *</label>
                                <select name="jenis_kerusakan" id="jenis_kerusakan" class="form-select @error('jenis_kerusakan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="rusak_ringan" {{ old('jenis_kerusakan') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="rusak_berat" {{ old('jenis_kerusakan') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('jenis_kerusakan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div id="stock-info" class="stock-info mb-3" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <span id="stock-text"></span>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_dipelihara" class="form-label">Jumlah Dipelihara *</label>
                                <input type="number" name="jumlah_dipelihara" id="jumlah_dipelihara" 
                                       class="form-control @error('jumlah_dipelihara') is-invalid @enderror" 
                                       value="{{ old('jumlah_dipelihara') }}" min="1" required>
                                @error('jumlah_dipelihara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_kirim" class="form-label">Tanggal Kirim *</label>
                                <input type="date" name="tanggal_kirim" id="tanggal_kirim" 
                                       class="form-control @error('tanggal_kirim') is-invalid @enderror" 
                                       value="{{ old('tanggal_kirim', date('Y-m-d')) }}" required>
                                @error('tanggal_kirim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_kerusakan" class="form-label">Deskripsi Kerusakan *</label>
                            <textarea name="deskripsi_kerusakan" id="deskripsi_kerusakan" rows="3" 
                                      class="form-control @error('deskripsi_kerusakan') is-invalid @enderror" 
                                      placeholder="Jelaskan kondisi kerusakan secara detail..." required>{{ old('deskripsi_kerusakan') }}</textarea>
                            @error('deskripsi_kerusakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Informasi Vendor -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-store"></i>
                            Informasi Vendor
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_vendor" class="form-label">Nama Vendor/Toko *</label>
                                <input type="text" name="nama_vendor" id="nama_vendor" 
                                       class="form-control @error('nama_vendor') is-invalid @enderror" 
                                       value="{{ old('nama_vendor') }}" placeholder="e.g., CV. Komputer Sejahtera" required>
                                @error('nama_vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="pic_vendor" class="form-label">PIC Vendor</label>
                                <input type="text" name="pic_vendor" id="pic_vendor" 
                                       class="form-control @error('pic_vendor') is-invalid @enderror" 
                                       value="{{ old('pic_vendor') }}" placeholder="e.g., Budi Santoso">
                                @error('pic_vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kontak_vendor" class="form-label">Kontak Vendor</label>
                                <input type="text" name="kontak_vendor" id="kontak_vendor" 
                                       class="form-control @error('kontak_vendor') is-invalid @enderror" 
                                       value="{{ old('kontak_vendor') }}" placeholder="e.g., 08123456789">
                                @error('kontak_vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="estimasi_selesai" class="form-label">Estimasi Selesai</label>
                                <input type="date" name="estimasi_selesai" id="estimasi_selesai" 
                                       class="form-control @error('estimasi_selesai') is-invalid @enderror" 
                                       value="{{ old('estimasi_selesai') }}">
                                @error('estimasi_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estimasi_biaya" class="form-label">Estimasi Biaya</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="estimasi_biaya" id="estimasi_biaya" 
                                           class="form-control @error('estimasi_biaya') is-invalid @enderror" 
                                           value="{{ old('estimasi_biaya') }}" min="0" step="1000" placeholder="0">
                                </div>
                                @error('estimasi_biaya')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="alamat_vendor" class="form-label">Alamat Vendor</label>
                                <textarea name="alamat_vendor" id="alamat_vendor" rows="2" 
                                          class="form-control @error('alamat_vendor') is-invalid @enderror" 
                                          placeholder="Alamat lengkap vendor...">{{ old('alamat_vendor') }}</textarea>
                                @error('alamat_vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Dokumentasi -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-camera"></i>
                            Dokumentasi & Catatan
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="foto_sebelum" class="form-label">Foto Sebelum Perbaikan</label>
                                <div class="upload-area">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2" style="color: #6b7280;"></i>
                                    <p class="mb-2">Klik untuk upload foto (multiple)</p>
                                    <input type="file" name="foto_sebelum[]" id="foto_sebelum" 
                                           class="form-control @error('foto_sebelum.*') is-invalid @enderror" 
                                           multiple accept="image/*" style="display: none;">
                                    <small class="text-muted">Format: JPG, PNG. Max: 2MB per file</small>
                                </div>
                                @error('foto_sebelum.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="catatan_internal" class="form-label">Catatan Internal</label>
                                <textarea name="catatan_internal" id="catatan_internal" rows="4" 
                                          class="form-control @error('catatan_internal') is-invalid @enderror" 
                                          placeholder="Catatan internal untuk tim...">{{ old('catatan_internal') }}</textarea>
                                @error('catatan_internal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pemeliharaan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Pemeliharaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const barangSelect = document.getElementById('barang_id');
        const jenisSelect = document.getElementById('jenis_kerusakan');
        const jumlahInput = document.getElementById('jumlah_dipelihara');
        const stockInfo = document.getElementById('stock-info');
        const stockText = document.getElementById('stock-text');
        const uploadArea = document.querySelector('.upload-area');
        const fileInput = document.getElementById('foto_sebelum');

        // Handle stock info update
        function updateStockInfo() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            const jenisKerusakan = jenisSelect.value;
            
            if (selectedOption.value && jenisKerusakan) {
                const stokRusakRingan = parseInt(selectedOption.dataset.rusakRingan) || 0;
                const stokRusakBerat = parseInt(selectedOption.dataset.rusakBerat) || 0;
                
                let availableStock = 0;
                let jenisText = '';
                
                if (jenisKerusakan === 'rusak_ringan') {
                    availableStock = stokRusakRingan;
                    jenisText = 'Rusak Ringan';
                } else if (jenisKerusakan === 'rusak_berat') {
                    availableStock = stokRusakBerat;
                    jenisText = 'Rusak Berat';
                }
                
                stockText.textContent = `Stok ${jenisText} tersedia: ${availableStock} unit`;
                stockInfo.style.display = 'block';
                jumlahInput.max = availableStock;
                
                if (availableStock === 0) {
                    stockInfo.style.background = '#fee2e2';
                    stockInfo.style.borderColor = '#fca5a5';
                    stockInfo.style.color = '#dc2626';
                } else {
                    stockInfo.style.background = '#e0f2fe';
                    stockInfo.style.borderColor = '#b3e5fc';
                    stockInfo.style.color = '#0277bd';
                }
            } else {
                stockInfo.style.display = 'none';
            }
        }

        barangSelect.addEventListener('change', updateStockInfo);
        jenisSelect.addEventListener('change', updateStockInfo);

        // Handle file upload
        uploadArea.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function() {
            const fileCount = this.files.length;
            if (fileCount > 0) {
                uploadArea.innerHTML = `
                    <i class="fas fa-check-circle fa-2x mb-2" style="color: #059669;"></i>
                    <p class="mb-2">${fileCount} file(s) dipilih</p>
                    <small class="text-muted">Klik untuk mengubah</small>
                `;
            }
        });

        // Initial stock info update
        updateStockInfo();
    });
    </script>
</x-main-layout>