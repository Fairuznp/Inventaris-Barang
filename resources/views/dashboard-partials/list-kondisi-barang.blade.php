<div class="card-body p-4">
    @php
    $kondisis = [
        ['judul' => 'Baik', 'jumlah' => $kondisiBaik, 'kondisi' => $kondisiBaik, 'color' => 'success', 'icon' => 'bi-check-circle'],
        [
            'judul' => 'Rusak Ringan',
            'jumlah' => $kondisiRusakRingan,
            'kondisi' => $kondisiRusakRingan,
            'color' => 'warning',
            'icon' => 'bi-exclamation-triangle'
        ],
        [
            'judul' => 'Rusak Berat', 
            'jumlah' => $kondisiRusakBerat, 
            'kondisi' => $kondisiRusakBerat,
            'color' => 'danger',
            'icon' => 'bi-x-circle'
        ],
    ];
    
    $total = $kondisiBaik + $kondisiRusakRingan + $kondisiRusakBerat;
    @endphp

    <style>
    .kondisi-item {
        background: #fafafa;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #f3f4f6;
        transition: all 0.2s ease;
    }

    .kondisi-item:hover {
        background: #f3f4f6;
        border-color: #1a1a1a;
    }

    .kondisi-item:last-child {
        margin-bottom: 0;
    }

    .kondisi-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #fafafa;
    }

    .kondisi-icon.success { background: #1a1a1a; }
    .kondisi-icon.warning { background: #6b7280; }
    .kondisi-icon.danger { background: #1a1a1a; }

    .kondisi-title {
        color: #1a1a1a;
        font-weight: 600;
        font-size: 0.95rem;
        margin: 0;
    }

    .kondisi-number {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
    }

    .kondisi-percentage {
        color: #6b7280;
        font-size: 0.8rem;
        margin: 0;
    }

    .progress-modern {
        height: 6px;
        background: #f3f4f6;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 8px;
    }

    .progress-bar-modern {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .progress-bar-modern.success { background: #1a1a1a; }
    .progress-bar-modern.warning { background: #6b7280; }
    .progress-bar-modern.danger { background: #1a1a1a; }
    </style>

    @foreach ($kondisis as $kondisi)
        @php
            extract($kondisi);
            $percentage = $total > 0 ? round(($jumlah / $total) * 100, 1) : 0;
        @endphp

        <div class="kondisi-item">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="kondisi-icon {{ $color }} me-3">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <h6 class="kondisi-title">{{ $judul }}</h6>
                        <p class="kondisi-percentage">{{ $percentage }}% dari total</p>
                    </div>
                </div>
                <div class="text-end">
                    <h5 class="kondisi-number">{{ number_format($jumlah) }}</h5>
                </div>
            </div>
            <div class="progress-modern">
                <div class="progress-bar-modern {{ $color }}" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    @endforeach
</div>