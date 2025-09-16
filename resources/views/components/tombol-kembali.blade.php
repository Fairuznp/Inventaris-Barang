@props(['href'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'btn btn-outline-secondary']) }}>
    Kembali
</a>