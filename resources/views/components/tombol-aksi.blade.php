@props(['href', 'type'])

@php
$configs = [
    'show' => ['class' => 'btn-info', 'icon' => 'bi-eye'],
    'edit' => ['class' => 'btn-warning', 'icon' => 'bi-pencil'],
    'delete' => ['class' => 'btn-danger', 'icon' => 'bi-trash'],
];
$config = $configs[$type] ?? $configs['show'];
@endphp

@switch($type)
    @case('show')
        <a href="{{ $href }}" class="btn btn-sm btn-info">
            <i class="bi bi-card-list"></i>
        </a>
        @break

    @case('edit')
        <a href="{{ $href }}" class="btn btn-sm btn-warning">
            <i class="bi bi-pencil-square"></i>
        </a>
        @break

    @case('delete')
        <button type="button" data-url="{{ $href }}" class="btn btn-sm btn-danger" data-bs-toggle="modal"
            data-bs-target="#deleteModal">
            <i class="bi bi-x-circle"></i>
        </button>
        @break
@endswitch