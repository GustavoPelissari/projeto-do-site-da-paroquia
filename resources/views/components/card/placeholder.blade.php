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
<div class="card-img-top d-flex align-items-center justify-content-center" style="height: {{ $height }}; background: {{ $bg }};">
    @if($icon)
        <i class="{{ $icon }} {{ $iconClass }}" style="font-size: 3rem; opacity: 0.9;"></i>
    @else
        <img src="{{ $logoSrc }}" alt="Paróquia São Paulo Apóstolo" style="max-width: 140px; max-height: 140px; opacity: 0.85;">
    @endif
</div>
