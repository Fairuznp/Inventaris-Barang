<div class="card-body p-4">
    @php
    $kondisis = [
        ['judul' => 'Baik', 'jumlah' => $kondisiBaik, 'kondisi' => $kondisiBaik, 'color' => 'success', 'icon' => 'bi-check-circle', 'bg_color' => '#1a1a1a', 'text_color' => '#fafafa'],
        [
            'judul' => 'Rusak Ringan',
            'jumlah' => $kondisiRusakRingan,
            'kondisi' => $kondisiRusakRingan,
            'color' => 'warning',
            'icon' => 'bi-exclamation-triangle',
            'bg_color' => '#6b7280',
            'text_color' => '#fafafa'
        ],
        [
            'judul' => 'Rusak Berat', 
            'jumlah' => $kondisiRusakBerat, 
            'kondisi' => $kondisiRusakBerat,
            'color' => 'danger',
            'icon' => 'bi-x-circle',
            'bg_color' => '#f3f4f6',
            'text_color' => '#1a1a1a'
        ],
    ];
    
    $total = $kondisiBaik + $kondisiRusakRingan + $kondisiRusakBerat;
    @endphp

    <!-- Total Stok Overview -->
    <div class="mb-4 p-3" style="background: #f3f4f6; border-radius: 8px; border: 1px solid #e5e7eb;">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0" style="color: #1a1a1a; font-weight: 600;">Total Stok Keseluruhan</h6>
                <small style="color: #6b7280;">Jumlah semua unit barang</small>
            </div>
            <div class="text-end">
                <h4 class="mb-0" style="color: #1a1a1a; font-weight: 700;">{{ number_format($total) }}</h4>
                <small style="color: #6b7280;">unit</small>
            </div>
        </div>
    </div>

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
    .kondisi-icon.danger { background: #f3f4f6; color: #1a1a1a !important; }

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
    .progress-bar-modern.danger { background: #f3f4f6; border: 1px solid #6b7280; }
    </style>

    @foreach ($kondisis as $kondisi)
        @php
            extract($kondisi);
            $percentage = $total > 0 ? round(($jumlah / $total) * 100, 1) : 0;
        @endphp

        <div class="kondisi-item" style="background: #fafafa; border: 1px solid #f3f4f6;">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="kondisi-icon {{ $color }} me-3" style="background: {{ $bg_color }}; color: {{ $text_color }};">
                        <i class="{{ $icon }}"></i>
                    </div>
                    <div>
                        <h6 class="kondisi-title">{{ $judul }}</h6>
                        <p class="kondisi-percentage">{{ $percentage }}% dari total unit</p>
                    </div>
                </div>
                <div class="text-end">
                    <h5 class="kondisi-number" style="color: {{ $bg_color }};">{{ number_format($jumlah) }}</h5>
                    <small style="color: #6b7280; font-size: 0.75rem;">unit</small>
                </div>
            </div>
            <div class="progress-modern">
                <div class="progress-bar-modern {{ $color }}" style="width: {{ $percentage }}%; background: {{ $bg_color }};"></div>
            </div>
        </div>
    @endforeach
</div>