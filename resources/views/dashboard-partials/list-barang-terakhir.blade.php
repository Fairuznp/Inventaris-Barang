<style>
.modern-table {
    border: none;
    background: transparent;
}

.modern-table thead th {
    background: #f3f4f6;
    color: #1a1a1a;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    padding: 12px 16px;
}

.modern-table thead th:first-child {
    border-radius: 8px 0 0 8px;
}

.modern-table thead th:last-child {
    border-radius: 0 8px 8px 0;
}

.modern-table tbody tr {
    border: none;
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background: #f3f4f6;
    transform: scale(1.01);
}

.modern-table tbody td {
    border: none;
    padding: 16px;
    color: #1a1a1a;
    font-size: 0.9rem;
    vertical-align: middle;
}

.modern-table tbody tr:not(:last-child) td {
    border-bottom: 1px solid #f3f4f6;
}

.item-name {
    font-weight: 600;
    color: #1a1a1a;
}

.item-location {
    color: #6b7280;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.item-location i {
    margin-right: 6px;
    font-size: 12px;
}

.item-date {
    color: #6b7280;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
}

.item-date i {
    margin-right: 6px;
    font-size: 12px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6b7280;
}

.empty-state i {
    font-size: 2rem;
    color: #f3f4f6;
    margin-bottom: 12px;
}

.empty-state p {
    margin: 0;
    font-size: 0.9rem;
}
</style>

<table class="table modern-table">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Lokasi dan Tanggal Pengadaan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($barangTerbaru as $barang)
            <tr>
                <td class="item-name">{{ $barang->nama_barang }}</td>
                <td class="item-location">
                    <i class="bi-geo-alt"></i>
                    {{ $barang->lokasi->nama_lokasi }}
                </td>
                <td class="item-date">
                    <i class="bi-calendar3"></i>
                    {{ date('d-m-Y', strtotime($barang->tanggal_pengadaan)) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="empty-state">
                    <i class="bi-inbox"></i>
                    <p>Belum ada data barang yang ditambahkan.</p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>