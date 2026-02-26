@props([
    'src',
    'alt' => 'Imagem',
    'width' => null,
    'height' => null,
    'class' => 'img-fluid',
    'style' => '',
    'lazy' => true,
])

@php
    $loadingAttr = $lazy ? 'lazy' : 'eager';
    $path = str_replace('/storage/', '', $src);
    
    // If it's a static image, use asset()
    if (!str_contains($path, '/storage')) {
        $imagePath = asset($src);
    } else {
        $imagePath = \Illuminate\Support\Facades\Storage::url($path);
    }
@endphp

<picture>
    <!-- WebP format for modern browsers -->
    <source srcset="{{ $imagePath }}?format=webp" type="image/webp">
    <!-- Fallback to original format -->
    <img 
        src="{{ $imagePath }}"
        alt="{{ $alt }}"
        @if ($width) width="{{ $width }}" @endif
        @if ($height) height="{{ $height }}" @endif
        loading="{{ $loadingAttr }}"
        class="{{ $class }}"
        @if ($style) style="{{ $style }}" @endif
        {{ $attributes }}
    >
</picture>
