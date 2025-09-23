<section id="fitur" class="py-5" style="padding: 6rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: var(--primary);">
                Fitur Unggulan
            </h2>
            <p class="lead" style="color: var(--secondary); max-width: 600px; margin: 0 auto;">
                Sistem inventaris yang dilengkapi dengan fitur-fitur canggih untuk memudahkan pengelolaan aset Anda
            </p>
        </div>
        
        <div class="row g-4">
            @php
            $fiturs = [
                [
                    'judul' => 'Manajemen Barang',
                    'deskripsi' => 'Tambah, edit, dan hapus barang dengan antarmuka yang intuitif. Kelola kategori, stok, dan detail barang secara efisien.',
                    'icon' => 'bi-box-seam'
                ],
                [
                    'judul' => 'Laporan Real-time',
                    'deskripsi' => 'Dapatkan insight mendalam dengan laporan stok, riwayat transaksi, dan analitik yang dapat disesuaikan.',
                    'icon' => 'bi-graph-up'
                ],
                [
                    'judul' => 'Akses Multi-User',
                    'deskripsi' => 'Kolaborasi tim dengan sistem role dan permission yang fleksibel. Kontrol akses yang aman dan terpercaya.',
                    'icon' => 'bi-people'
                ],
            ];
            @endphp
            
            @foreach($fiturs as $fitur)
                <div class="col-md-4">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="{{ $fitur['icon'] }}" style="font-size: 1.5rem; color: var(--primary);"></i>
                        </div>
                        <h4 class="fw-semibold mb-3" style="color: var(--primary);">
                            {{ $fitur['judul'] }}
                        </h4>
                        <p style="color: var(--secondary); line-height: 1.7;">
                            {{ $fitur['deskripsi'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>