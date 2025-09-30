<x-main-layout titlePage="{{ __('Pengembalian Barang') }}">
    <style>
    /* Modern Form Styles */
    .form-container {
        background: #fafafa;
        min-height: 100vh;
        padding: 20px 0;
    }

    .form-card {
        background: #fafafa;
        border: 1px solid #f3f4f6;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .form-header {
        background: #1a1a1a;
        color: #fafafa;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 32px;
    }

    .info-card {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .form-label {
        color: #1a1a1a;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 0.9rem;
        background: #fafafa;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a1a1a;
        box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
        background: #ffffff;
    }

    .status-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-top: 12px;
    }

    .status-option {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fafafa;
    }

    .status-option:hover {
        border-color: #1a1a1a;
        background: #f3f4f6;
    }

    .status-option.selected {
        border-color: #1a1a1a;
        background: #1a1a1a;
        color: #fafafa;
    }

    .status-option input[type="radio"] {
        display: none;
    }

    .status-title {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .status-desc {
        font-size: 0.85rem;
        opacity: 0.8;
        margin: 0;
    }
    </style>

    <div class="form-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Form Header -->
                    <div class="form-header">
                        <h4>
                            <i class="fas fa-undo"></i>
                            Pengembalian Barang
                        </h4>
                    </div>

                    <!-- Info Peminjaman -->
                    <div class="info-card">
                        <h6 class="mb-3" style="color: #1a1a1a; font-weight: 600;">Informasi Peminjaman</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">BARANG</small>
                                <div style="color: #1a1a1a; font-weight: 500;">
                                    {{ $peminjaman->barang->nama_barang }}
                                    <br><small style="color: #6b7280;">({{ $peminjaman->barang->kode_barang }})</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <small style="color: #6b7280; font-size: 0.75rem;">PEMINJAM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $peminjaman->nama_peminjam_lengkap }}</div>
                                @if($peminjaman->instansi_peminjam)
                                    <small style="color: #6b7280;">{{ $peminjaman->instansi_peminjam }}</small>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <small style="color: #6b7280; font-size: 0.75rem;">JUMLAH DIPINJAM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $peminjaman->jumlah }} unit</div>
                            </div>
                            <div class="col-md-4">
                                <small style="color: #6b7280; font-size: 0.75rem;">TGL PINJAM</small>
                                <div style="color: #1a1a1a; font-weight: 500;">{{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-md-4">
                                <small style="color: #6b7280; font-size: 0.75rem;">TGL KEMBALI</small>
                                <div style="color: #1a1a1a; font-weight: 500;">
                                    {{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d/m/Y') : 'Tidak ditentukan' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Pengembalian -->
                    <div class="form-card">
                        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" id="pengembalianForm">
                            @csrf
                            @method('PUT')

                            <!-- Status Pengembalian -->
                            <div class="mb-4">
                                <label class="form-label">Status Pengembalian</label>
                                <div class="status-options">
                                    <label class="status-option" data-status="dikembalikan">
                                        <input type="radio" name="status" value="dikembalikan" required>
                                        <div class="status-title">Dikembalikan</div>
                                        <p class="status-desc">Barang dikembalikan dalam kondisi baik</p>
                                    </label>
                                    <label class="status-option" data-status="terlambat">
                                        <input type="radio" name="status" value="terlambat" required>
                                        <div class="status-title">Terlambat</div>
                                        <p class="status-desc">Barang dikembalikan terlambat</p>
                                    </label>
                                    <label class="status-option" data-status="hilang">
                                        <input type="radio" name="status" value="hilang" required>
                                        <div class="status-title">Hilang</div>
                                        <p class="status-desc">Barang hilang atau tidak dikembalikan</p>
                                    </label>
                                </div>
                                @error('status')
                                    <div class="text-danger mt-2" style="font-size: 0.875rem;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jumlah Dikembalikan -->
                            <div class="mb-3" id="jumlahSection">
                                <label for="jumlah_kembali" class="form-label">Jumlah yang Dikembalikan</label>
                                <input type="number" 
                                       name="jumlah_kembali" 
                                       id="jumlah_kembali" 
                                       class="form-control @error('jumlah_kembali') is-invalid @enderror" 
                                       min="1" 
                                       max="{{ $peminjaman->jumlah }}"
                                       value="{{ old('jumlah_kembali', $peminjaman->jumlah) }}" 
                                       required>
                                <small style="color: #6b7280;">Maksimal {{ $peminjaman->jumlah }} unit</small>
                                @error('jumlah_kembali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali Aktual -->
                            <div class="mb-3">
                                <label for="tanggal_kembali_aktual" class="form-label">Tanggal Pengembalian</label>
                                <input type="date" 
                                       name="tanggal_kembali_aktual" 
                                       id="tanggal_kembali_aktual" 
                                       class="form-control @error('tanggal_kembali_aktual') is-invalid @enderror" 
                                       value="{{ old('tanggal_kembali_aktual', date('Y-m-d')) }}" 
                                       required>
                                @error('tanggal_kembali_aktual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <textarea name="keterangan" 
                                          id="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary px-4 py-2"
                                   style="background: #f3f4f6; color: #1a1a1a; border: none; border-radius: 8px; text-decoration: none;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary px-4 py-2"
                                        style="background: #1a1a1a; color: #fafafa; border: none; border-radius: 8px;">
                                    <i class="fas fa-save me-2"></i>Simpan Pengembalian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusOptions = document.querySelectorAll('.status-option');
        const jumlahSection = document.getElementById('jumlahSection');
        const jumlahInput = document.getElementById('jumlah_kembali');
        
        statusOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                statusOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Check the radio button
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Handle jumlah visibility based on status
                const status = radio.value;
                if (status === 'hilang') {
                    jumlahInput.value = 0;
                    jumlahSection.style.display = 'none';
                } else {
                    jumlahSection.style.display = 'block';
                    if (jumlahInput.value == 0) {
                        jumlahInput.value = {{ $peminjaman->jumlah }};
                    }
                }
            });
        });

        // Set minimum date untuk tanggal pengembalian
        const tanggalKembaliAktual = document.getElementById('tanggal_kembali_aktual');
        tanggalKembaliAktual.min = '{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}';
    });
    </script>
</x-main-layout>