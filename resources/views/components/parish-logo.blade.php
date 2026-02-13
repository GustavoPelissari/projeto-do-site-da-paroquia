@props([
    'class' => '',
    'alt' => 'Logo da Paróquia São Paulo Apóstolo',
])

@php
    $transparentPng = public_path('images/sao-paulo-logo-transparent.png');
    $svgFallback = public_path('images/sao-paulo-apostolo.svg');

    if (file_exists($transparentPng)) {
        $logoSrc = asset('images/sao-paulo-logo-transparent.png');
    } elseif (file_exists($svgFallback)) {
        $logoSrc = asset('images/sao-paulo-apostolo.svg');
    } else {
        $logoSrc = asset('images/sao-paulo-logo.png');
    }
@endphp

<img src="{{ $logoSrc }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => trim('parish-logo bg-transparent border-0 shadow-none '.$class)]) }}>
