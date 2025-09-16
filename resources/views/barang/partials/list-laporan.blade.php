<table class="info-table">
    <tr>
        <td class="label">Total Data Barang</td>
        <td>: {{ $barangs->count() }} item</td>
        <td class="label">Total Stok</td>
        <td>: {{ $barangs->sum('jumlah') }} unit</td>
    </tr>
    <tr>
        <td class="label">Tanggal Laporan</td>
        <td>: {{ date('d F Y') }}</td>
        <td class="label">Jam Cetak</td>
        <td>: {{ date('H:i:s') }} WIB</td>
    </tr>
</table>

<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Kondisi</th>
            <th>Tgl. Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($barangs as $index => $barang)
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>{{ $barang->kode_barang }}</td>
            <td>{{ $barang->nama_barang }}</td>
            <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $barang->lokasi->nama_lokasi ?? '-' }}</td>
            <td class="text-center">{{ number_format($barang->jumlah) }} {{ $barang->satuan }}</td>
            <td class="text-center">{{ $barang->kondisi }}</td>
            <td class="text-center">{{ date('d-m-Y', strtotime($barang->tanggal_pengadaan)) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Tidak ada data barang</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($barangs->count() > 0)
<div class="summary">
    <h4>RINGKASAN LAPORAN</h4>
    <div class="summary-grid">
        <div class="summary-item">
            <span>Total Jenis Barang:</span>
            <strong>{{ $barangs->count() }} item</strong>
        </div>
        <div class="summary-item">
            <span>Total Stok Keseluruhan:</span>
            <strong>{{ number_format($barangs->sum('jumlah')) }} unit</strong>
        </div>
        <div class="summary-item">
            <span>Jumlah Kategori:</span>
            <strong>{{ $barangs->pluck('kategori.nama_kategori')->unique()->count() }} kategori</strong>
        </div>
        <div class="summary-item">
            <span>Jumlah Lokasi:</span>
            <strong>{{ $barangs->pluck('lokasi.nama_lokasi')->unique()->count() }} lokasi</strong>
        </div>
        <div class="summary-item">
            <span>Barang Stok Rendah (< 10):</span>
            <strong>{{ $barangs->where('jumlah', '<', 10)->count() }} item</strong>
        </div>
        <div class="summary-item">
            <span>Barang Stok Habis (0):</span>
            <strong>{{ $barangs->where('jumlah', 0)->count() }} item</strong>
        </div>
    </div>
</div>
@endif