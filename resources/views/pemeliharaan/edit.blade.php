<x-main-layout titlePage="{{ __('Update Pemeliharaan') }}">
    <style>
    .edit-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .edit-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .edit-header {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-section {
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

    .form-label {
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a1a1a;
        box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
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

    .current-info {
        background: linear-gradient(135deg, #1a1a1a 0%, #374151 100%);
        color: #fafafa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px 0;
    }

    .photo-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .photo-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
    }

    .photo-item img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s ease;
    }

    .file-upload-area:hover {
        border-color: #1a1a1a;
        background: #f3f4f6;
    }

    .btn-primary {
        background: #1a1a1a;
        border-color: #1a1a1a;
        color: #fafafa;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #374151;
        border-color: #374151;
        color: #fafafa;
    }

    .btn-secondary {
        background: #6b7280;
        border-color: #6b7280;
        color: #fafafa;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-danger {
        background: #dc2626;
        border-color: #dc2626;
        color: #fafafa;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 500;
    }

    .readonly-field {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        color: #6b7280;
    }
    </style>

    <div class="edit-container">
        <div class="container">
            <!-- Header -->
            <div class="edit-header">
                <h4><i class="fas fa-edit me-2"></i>Update Pemeliharaan</h4>
                <p class="mb-2">{{ $pemeliharaan->kode_pemeliharaan }}</p>
                <span class="status-badge status-{{ $pemeliharaan->status }}">
                    {{ ucwords(str_replace('_', ' ', $pemeliharaan->status)) }}
                </span>
            </div>

            <form action="{{ route('pemeliharaan.update', $pemeliharaan->id) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Informasi Barang (Read Only) -->
                        <div class="edit-card">
                            <div class="current-info">
                                <h5 class="mb-3"><i class="fas fa-box me-2"></i>Informasi Barang</h5>
                                <div class="info-row">
                                    <span>Nama Barang:</span>
                                    <span>{{ $pemeliharaan->barang->nama_barang }}</span>
                                </div>
                                <div class="info-row">
                                    <span>Kode Barang:</span>
                                    <span>{{ $pemeliharaan->barang->kode_barang }}</span>
                                </div>
                                <div class="info-row">
                                    <span>Jenis Kerusakan:</span>
                                    <span>{{ ucwords(str_replace('_', ' ', $pemeliharaan->jenis_kerusakan)) }}</span>
                                </div>
                                <div class="info-row">
                                    <span>Jumlah Dipelihara:</span>
                                    <span>{{ $pemeliharaan->jumlah_dipelihara }} unit</span>
                                </div>
                            </div>
                        </div>

                        <!-- Update Status -->
                        <div class="edit-card">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-tasks"></i>
                                    Update Status Pemeliharaan
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" 
                                                    id="status" name="status" required onchange="toggleStatusFields()">
                                                <option value="">Pilih Status</option>
                                                @if($pemeliharaan->status === 'dikirim')
                                                    <option value="dalam_perbaikan" {{ old('status') === 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                                    <option value="dibatalkan" {{ old('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                @elseif($pemeliharaan->status === 'dalam_perbaikan')
                                                    <option value="menunggu_approval" {{ old('status') === 'menunggu_approval' ? 'selected' : '' }}>Menunggu Approval</option>
                                                    <option value="tidak_bisa_diperbaiki" {{ old('status') === 'tidak_bisa_diperbaiki' ? 'selected' : '' }}>Tidak Bisa Diperbaiki</option>
                                                @elseif($pemeliharaan->status === 'menunggu_approval')
                                                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="dalam_perbaikan" {{ old('status') === 'dalam_perbaikan' ? 'selected' : '' }}>Kembali ke Perbaikan</option>
                                                @endif
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="keterangan_update" class="form-label">Keterangan Update</label>
                                            <input type="text" class="form-control @error('keterangan_update') is-invalid @enderror" 
                                                   id="keterangan_update" name="keterangan_update" value="{{ old('keterangan_update') }}"
                                                   placeholder="Keterangan perubahan status">
                                            @error('keterangan_update')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Biaya & Timeline -->
                        <div class="edit-card">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Biaya & Timeline
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estimasi_biaya" class="form-label">Estimasi Biaya</label>
                                            <input type="number" class="form-control @error('estimasi_biaya') is-invalid @enderror" 
                                                   id="estimasi_biaya" name="estimasi_biaya" 
                                                   value="{{ old('estimasi_biaya', $pemeliharaan->estimasi_biaya) }}"
                                                   placeholder="0">
                                            @error('estimasi_biaya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6" id="biaya_aktual_field" style="display: none;">
                                        <div class="mb-3">
                                            <label for="biaya_aktual" class="form-label">Biaya Aktual</label>
                                            <input type="number" class="form-control @error('biaya_aktual') is-invalid @enderror" 
                                                   id="biaya_aktual" name="biaya_aktual" 
                                                   value="{{ old('biaya_aktual', $pemeliharaan->biaya_aktual) }}"
                                                   placeholder="0">
                                            @error('biaya_aktual')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="estimasi_selesai" class="form-label">Estimasi Selesai</label>
                                            <input type="date" class="form-control @error('estimasi_selesai') is-invalid @enderror" 
                                                   id="estimasi_selesai" name="estimasi_selesai" 
                                                   value="{{ old('estimasi_selesai', $pemeliharaan->estimasi_selesai?->format('Y-m-d')) }}">
                                            @error('estimasi_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6" id="tanggal_selesai_field" style="display: none;">
                                        <div class="mb-3">
                                            <label for="tanggal_selesai_aktual" class="form-label">Tanggal Selesai Aktual</label>
                                            <input type="date" class="form-control @error('tanggal_selesai_aktual') is-invalid @enderror" 
                                                   id="tanggal_selesai_aktual" name="tanggal_selesai_aktual" 
                                                   value="{{ old('tanggal_selesai_aktual', $pemeliharaan->tanggal_selesai_aktual?->format('Y-m-d')) }}">
                                            @error('tanggal_selesai_aktual')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hasil Perbaikan (untuk status selesai) -->
                        <div class="edit-card" id="hasil_perbaikan_section" style="display: none;">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-chart-pie"></i>
                                    Hasil Perbaikan
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jumlah_berhasil_diperbaiki" class="form-label">Berhasil Diperbaiki</label>
                                            <input type="number" class="form-control @error('jumlah_berhasil_diperbaiki') is-invalid @enderror" 
                                                   id="jumlah_berhasil_diperbaiki" name="jumlah_berhasil_diperbaiki" 
                                                   value="{{ old('jumlah_berhasil_diperbaiki', $pemeliharaan->jumlah_berhasil_diperbaiki) }}"
                                                   min="0" max="{{ $pemeliharaan->jumlah_dipelihara }}" 
                                                   onchange="calculateNotRepaired()">
                                            @error('jumlah_berhasil_diperbaiki')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="jumlah_tidak_bisa_diperbaiki" class="form-label">Tidak Bisa Diperbaiki</label>
                                            <input type="number" class="form-control readonly-field" 
                                                   id="jumlah_tidak_bisa_diperbaiki" name="jumlah_tidak_bisa_diperbaiki" 
                                                   value="{{ old('jumlah_tidak_bisa_diperbaiki', $pemeliharaan->jumlah_tidak_bisa_diperbaiki) }}"
                                                   readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="edit-card">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-sticky-note"></i>
                                    Catatan
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="catatan_vendor" class="form-label">Catatan Vendor</label>
                                            <textarea class="form-control @error('catatan_vendor') is-invalid @enderror" 
                                                      id="catatan_vendor" name="catatan_vendor" rows="3"
                                                      placeholder="Catatan dari vendor">{{ old('catatan_vendor', $pemeliharaan->catatan_vendor) }}</textarea>
                                            @error('catatan_vendor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="catatan_internal" class="form-label">Catatan Internal</label>
                                            <textarea class="form-control @error('catatan_internal') is-invalid @enderror" 
                                                      id="catatan_internal" name="catatan_internal" rows="3"
                                                      placeholder="Catatan internal">{{ old('catatan_internal', $pemeliharaan->catatan_internal) }}</textarea>
                                            @error('catatan_internal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Dokumentasi -->
                        <div class="edit-card">
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-camera"></i>
                                    Dokumentasi
                                </div>
                                
                                <!-- Foto Sebelum -->
                                <div class="mb-4">
                                    <label class="form-label">Foto Sebelum Perbaikan</label>
                                    @if($pemeliharaan->foto_sebelum && count($pemeliharaan->foto_sebelum) > 0)
                                        <div class="photo-preview">
                                            @foreach($pemeliharaan->foto_sebelum as $foto)
                                            <div class="photo-item">
                                                <img src="{{ asset('foto-pemeliharaan/' . $foto) }}" alt="Foto Sebelum">
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="file-upload-area mt-2">
                                        <input type="file" class="form-control @error('foto_sebelum') is-invalid @enderror" 
                                               id="foto_sebelum" name="foto_sebelum[]" accept="image/*" multiple>
                                        <small class="text-muted">Upload foto tambahan (opsional)</small>
                                        @error('foto_sebelum')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Foto Sesudah -->
                                <div class="mb-4" id="foto_sesudah_section" style="display: none;">
                                    <label class="form-label">Foto Sesudah Perbaikan</label>
                                    @if($pemeliharaan->foto_sesudah && count($pemeliharaan->foto_sesudah) > 0)
                                        <div class="photo-preview">
                                            @foreach($pemeliharaan->foto_sesudah as $foto)
                                            <div class="photo-item">
                                                <img src="{{ asset('foto-pemeliharaan/' . $foto) }}" alt="Foto Sesudah">
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="file-upload-area mt-2">
                                        <input type="file" class="form-control @error('foto_sesudah') is-invalid @enderror" 
                                               id="foto_sesudah" name="foto_sesudah[]" accept="image/*" multiple>
                                        <small class="text-muted">Upload foto hasil perbaikan</small>
                                        @error('foto_sesudah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Invoice -->
                                <div class="mb-3" id="invoice_section" style="display: none;">
                                    <label for="dokumen_invoice" class="form-label">Invoice/Dokumen</label>
                                    @if($pemeliharaan->dokumen_invoice)
                                        <div class="mb-2">
                                            <a href="{{ asset('foto-pemeliharaan/' . $pemeliharaan->dokumen_invoice) }}" 
                                               target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf me-1"></i>Lihat Invoice Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <div class="file-upload-area">
                                        <input type="file" class="form-control @error('dokumen_invoice') is-invalid @enderror" 
                                               id="dokumen_invoice" name="dokumen_invoice" accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Upload invoice baru (opsional)</small>
                                        @error('dokumen_invoice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="edit-card">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary" id="updateButton">
                                    <i class="fas fa-save me-2"></i>Update Pemeliharaan
                                </button>
                                
                                <a href="{{ route('pemeliharaan.show', $pemeliharaan->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                
                                @if(!in_array($pemeliharaan->status, ['selesai', 'dibatalkan', 'tidak_bisa_diperbaiki']))
                                <button type="button" class="btn btn-danger" onclick="confirmCancel()">
                                    <i class="fas fa-times me-2"></i>Batalkan Pemeliharaan
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
    function toggleStatusFields() {
        const status = document.getElementById('status').value;
        const biayaAktualField = document.getElementById('biaya_aktual_field');
        const tanggalSelesaiField = document.getElementById('tanggal_selesai_field');
        const hasilPerbaikanSection = document.getElementById('hasil_perbaikan_section');
        const fotoSesudahSection = document.getElementById('foto_sesudah_section');
        const invoiceSection = document.getElementById('invoice_section');
        
        // Reset visibility
        biayaAktualField.style.display = 'none';
        tanggalSelesaiField.style.display = 'none';
        hasilPerbaikanSection.style.display = 'none';
        fotoSesudahSection.style.display = 'none';
        invoiceSection.style.display = 'none';
        
        if (status === 'menunggu_approval' || status === 'selesai') {
            biayaAktualField.style.display = 'block';
            fotoSesudahSection.style.display = 'block';
            invoiceSection.style.display = 'block';
        }
        
        if (status === 'selesai') {
            tanggalSelesaiField.style.display = 'block';
            hasilPerbaikanSection.style.display = 'block';
        }
    }

    function calculateNotRepaired() {
        const total = {{ $pemeliharaan->jumlah_dipelihara }};
        const berhasil = parseInt(document.getElementById('jumlah_berhasil_diperbaiki').value) || 0;
        const tidakBisa = total - berhasil;
        document.getElementById('jumlah_tidak_bisa_diperbaiki').value = tidakBisa >= 0 ? tidakBisa : 0;
    }

    function confirmCancel() {
        if (confirm('Apakah Anda yakin ingin membatalkan pemeliharaan ini?')) {
            document.getElementById('status').value = 'dibatalkan';
            document.getElementById('updateForm').submit();
        }
    }

    // Initialize form based on current status
    document.addEventListener('DOMContentLoaded', function() {
        const currentStatus = '{{ $pemeliharaan->status }}';
        
        // Show appropriate fields for current status
        if (currentStatus === 'menunggu_approval' || currentStatus === 'selesai') {
            document.getElementById('foto_sesudah_section').style.display = 'block';
            document.getElementById('invoice_section').style.display = 'block';
        }
    });
    </script>
</x-main-layout>