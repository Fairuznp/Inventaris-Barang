@php
$kartus = [
    [
        'text' => 'TOTAL BARANG',
        'total' => $jumlahBarang,
        'route' => 'barang.index',
        'icon' => 'bi-box-seam',
        'color' => 'charcoal',
    ],
    [
        'text' => 'TOTAL KATEGORI',
        'total' => $jumlahKategori,
        'route' => 'kategori.index',
        'icon' => 'bi-tag',
        'color' => 'charcoal',
    ],
    [
        'text' => 'TOTAL LOKASI',
        'total' => $jumlahLokasi,
        'route' => 'lokasi.index',
        'icon' => 'bi-geo-alt',
        'color' => 'charcoal',
    ],
    [
        'text' => 'TOTAL USER',
        'total' => $jumlahUser,
        'route' => 'user.index',
        'icon' => 'bi-people',
        'color' => 'charcoal',
        'role' => 'admin',
    ],
];
@endphp

<style>
.modern-card {
    background: #fafafa;
    border: 1px solid #f3f4f6;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #1a1a1a;
}

.card-icon {
    width: 48px;
    height: 48px;
    background: #1a1a1a;
    color: #fafafa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.card-content h3 {
    color: #1a1a1a;
    font-weight: 600;
    margin: 0;
    font-size: 1.8rem;
}

.card-content p {
    color: #6b7280;
    margin: 0;
    font-size: 0.85rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.modern-link {
    text-decoration: none;
    color: inherit;
}
</style>

@foreach ($kartus as $kartu)
    @php
        extract($kartu);
    @endphp

    @isset($role)
        @role($role)
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route($route) }}" class="modern-link">
                    <div class="modern-card p-4">
                        <div class="d-flex align-items-center">
                            <div class="card-icon me-3">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div class="card-content">
                                <h3>{{ number_format($total) }}</h3>
                                <p>{{ $text }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endrole
    @else
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route($route) }}" class="modern-link">
                <div class="modern-card p-4">
                    <div class="d-flex align-items-center">
                        <div class="card-icon me-3">
                            <i class="{{ $icon }}"></i>
                        </div>
                        <div class="card-content">
                            <h3>{{ number_format($total) }}</h3>
                            <p>{{ $text }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endisset
@endforeach