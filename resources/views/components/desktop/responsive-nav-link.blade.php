@props(['active' => false])

@php
    $classes = $active
        ? 'nav-link active fw-semibold d-block px-3 py-2'
        : 'nav-link d-block px-3 py-2';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
