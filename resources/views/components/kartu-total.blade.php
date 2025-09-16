@props(['text', 'total', 'route', 'icon', 'color'])

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card shadow py-2 border-{{ $color }}">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="text-xs fw-bold text-{{ $color }} mb-1">
                        {{ $text }}
                    </div>
                    <h5>{{ $total }}</h5>
                </div>
                <div class="col-auto">
                    <i class="{{ $icon }} text-{{ $color }} fs-1"></i>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route($route) }}" class="text-secondary text-decoration-none">
                <i class="bi bi-arrow-up-right"></i>
            </a>
        </div>
    </div>
</div>