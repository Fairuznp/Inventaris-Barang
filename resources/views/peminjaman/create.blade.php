<x-main-layout titlePage="{{ __('Tambah Peminjaman') }}">
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

    .form-header h4 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }

    .form-header h4 i {
        margin-right: 12px;
    }

    .form-group {
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

    .barang-info {
        background: #f3f4f6;
        border-radius: 8px;
        padding: 16px;
        margin-top: 12px;
        display: none;
    }

    .stok-info {
        color: #6b7280;
        font-size: 0.85rem;
        margin: 0;
    }

    .btn-primary-custom {
        background: #1a1a1a;
        color: #fafafa;
        border: none;
        border-radius: 8px;
        padding: 12px 32px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .btn-primary-custom:hover {
        background: #374151;
        transform: translateY(-1px);
    }

    .btn-secondary-custom {
        background: #f3f4f6;
        color: #1a1a1a;
        border: none;
        border-radius: 8px;
        padding: 12px 32px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-secondary-custom:hover {
        background: #e5e7eb;
        color: #1a1a1a;
    }
    </style>

    <div class="form-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Form Header -->
                    <div class="form-header">
                        <h4>
                            <i class="fas fa-plus-circle"></i>
                            Tambah Peminjaman Barang
                        </h4>
                    </div>

                    <!-- Form Card -->
                    <div class="form-card">
                        <form action="{{ route('peminjaman.store') }}" method="POST" id="peminjamanForm">
                            @csrf

                            <!-- Pilih Barang -->
                            <div class="form-group">
                                <label for="barang_id" class="form-label">Pilih Barang</label>
                                <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Barang --</option>
                                    @forelse ($barangs as $barang)
                                        <option value="{{ $barang->id }}" 
                                                data-stok="{{ $barang->stok_tersedia }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} ({{ $barang->kode_barang }})
                                        </option>
                                    @empty
                                        <option value="" disabled>Tidak ada barang yang dapat dipinjam</option>
                                    @endforelse
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                @if($barangs->isEmpty())
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Tidak ada barang yang dapat dipinjam saat ini.</strong><br>
                                        Barang mungkin tidak tersedia untuk dipinjam atau stok sedang habis.
                                        <a href="{{ route('barang.index') }}" class="alert-link">Lihat semua barang</a>
                                    </div>
                                @endif
                                
                                <!-- Info Stok -->
                                <div id="barangInfo" class="barang-info">
                                    <p class="stok-info mb-0">
                                        <strong>Stok Baik Tersedia: </strong>
                                        <span id="stokTersedia">0</span> unit
                                    </p>
                                </div>
                            </div>

                            <!-- Data Peminjam -->
                            <div class="form-group">
                                <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                                <input type="text" 
                                       name="nama_peminjam" 
                                       id="nama_peminjam" 
                                       class="form-control @error('nama_peminjam') is-invalid @enderror" 
                                       value="{{ old('nama_peminjam') }}" 
                                       placeholder="Masukkan nama lengkap peminjam"
                                       required>
                                @error('nama_peminjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kontak_peminjam" class="form-label">Kontak (Opsional)</label>
                                        <input type="text" 
                                               name="kontak_peminjam" 
                                               id="kontak_peminjam" 
                                               class="form-control @error('kontak_peminjam') is-invalid @enderror" 
                                               value="{{ old('kontak_peminjam') }}" 
                                               placeholder="No. HP atau Email">
                                        @error('kontak_peminjam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instansi_peminjam" class="form-label">Instansi (Opsional)</label>
                                        <input type="text" 
                                               name="instansi_peminjam" 
                                               id="instansi_peminjam" 
                                               class="form-control @error('instansi_peminjam') is-invalid @enderror" 
                                               value="{{ old('instansi_peminjam') }}" 
                                               placeholder="Nama instansi/organisasi">
                                        @error('instansi_peminjam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Jumlah -->
                            <div class="form-group">
                                <label for="jumlah" class="form-label">Jumlah Barang</label>
                                <input type="number" 
                                       name="jumlah" 
                                       id="jumlah" 
                                       class="form-control @error('jumlah') is-invalid @enderror" 
                                       min="1" 
                                       value="{{ old('jumlah') }}" 
                                       required>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div class="form-group">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" 
                                       name="tanggal_pinjam" 
                                       id="tanggal_pinjam" 
                                       class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                       value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" 
                                       required>
                                @error('tanggal_pinjam')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali -->
                            <div class="form-group">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali (Opsional)</label>
                                <input type="date" 
                                       name="tanggal_kembali" 
                                       id="tanggal_kembali" 
                                       class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                       value="{{ old('tanggal_kembali') }}">
                                @error('tanggal_kembali')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="form-group">
                                <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                                <textarea name="keterangan" 
                                          id="keterangan" 
                                          class="form-control @error('keterangan') is-invalid @enderror" 
                                          rows="3" 
                                          placeholder="Tambahkan keterangan jika diperlukan...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-3 justify-content-end mt-4">
                                <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary-custom">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary-custom">
                                    <i class="fas fa-save me-2"></i>
                                    Simpan Peminjaman
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
        const barangSelect = document.getElementById('barang_id');
        const barangInfo = document.getElementById('barangInfo');
        const stokTersedia = document.getElementById('stokTersedia');
        const jumlahInput = document.getElementById('jumlah');

        barangSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                const stok = selectedOption.dataset.stok;
                stokTersedia.textContent = stok;
                barangInfo.style.display = 'block';
                jumlahInput.max = stok;
                
                // Reset jumlah jika melebihi stok
                if (parseInt(jumlahInput.value) > parseInt(stok)) {
                    jumlahInput.value = stok;
                }
            } else {
                barangInfo.style.display = 'none';
                jumlahInput.max = '';
            }
        });

        // Validasi real-time jumlah
        jumlahInput.addEventListener('input', function() {
            const maxStok = parseInt(this.max);
            const currentValue = parseInt(this.value);
            
            if (currentValue > maxStok && maxStok > 0) {
                this.value = maxStok;
            }
        });

        // Set minimum date untuk tanggal kembali
        const tanggalPinjam = document.getElementById('tanggal_pinjam');
        const tanggalKembali = document.getElementById('tanggal_kembali');
        
        tanggalPinjam.addEventListener('change', function() {
            tanggalKembali.min = this.value;
        });
    });
    </script>
</x-main-layout>