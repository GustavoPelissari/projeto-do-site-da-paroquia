@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'type' => 'button',
    'ariaLabel' => null,
])

@php
    $sizeClass = match($size) {
        'sm' => 'btn-sm px-3 py-1',
        'lg' => 'btn-lg px-5 py-3',
        default => 'px-4 py-2',
    };

    $variantClass = match($variant) {
        'primary' => 'btn-vinho',
        'secondary' => 'btn-outline-secondary',
        'danger' => 'btn-danger',
        'success' => 'btn-success',
        default => 'btn-primary',
    };

    $ariaLabelAttr = $ariaLabel ? "aria-label=\"{$ariaLabel}\"" : '';
@endphp

<button
    type="{{ $type }}"
    class="btn {{ $variantClass }} {{ $sizeClass }} fw-semibold"
    @if ($disabled) disabled aria-disabled="true" @endif
    @if ($loading) aria-busy="true" @endif
    {!! $ariaLabelAttr !!}
    {{ $attributes }}
>
    @if ($loading)
        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
    @endif
    {{ $slot }}
</button>
