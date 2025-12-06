@props([
    'height' => '200px',
    'bg' => '#f5f5f5',
    'logo' => 'images/sao-paulo-logo.png',
    'icon' => null,
    'iconClass' => 'text-white',
])
@php
    $logoSrc = asset($logo);
@endphp
<div class="card-img-top d-flex align-items-center justify-content-center card-placeholder">
    @if($icon)
        <i class="{{ $icon }} {{ $iconClass }} card-placeholder-icon"></i>
    @else
        <img src="{{ $logoSrc }}" alt="Paróquia São Paulo Apóstolo" class="card-placeholder-logo">
    @endif
</div>

<style>
.card-placeholder {
    height: 200px;
    background: #f5f5f5;
}

.card-placeholder-icon {
    font-size: 3rem;
    opacity: 0.9;
}

.card-placeholder-logo {
    max-width: 140px;
    max-height: 140px;
    opacity: 0.85;
}
</style>
