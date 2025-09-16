@php
$message = session('success') ?? session('error');
$type = session('success') ? 'success' : 'danger';
@endphp

@if ($message)
    <div 
        {{ $attributes->merge([
            'class' => 'alert alert-' . $type . ' alert-dismissible fade show alert-' . $type,
        ]) }}>
        {{ $message }}
    </div>
@endif