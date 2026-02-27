@props([
    'title',
    'subtitle' => null,
])

<div class="mx-auto mb-10 max-w-4xl text-center">
        <h2 class="mb-4">{{ $title }}</h2>
        @if($subtitle)
            <p class="text-lg text-gray-600">{{ $subtitle }}</p>
        @endif
</div>
