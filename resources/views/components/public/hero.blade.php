@props([
    'title',
    'subtitle' => null,
    'description' => null,
])

<section class="hero-paroquia animate-on-scroll">
    <div class="hero-content">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                    <h1 class="mb-4">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="mb-4 text-xl hero-subtitle">{{ $subtitle }}</p>
                    @endif
                    @if($description)
                        <p class="mb-0 hero-description">{{ $description }}</p>
                    @endif
                    {{ $slot }}
            </div>
        </div>
    </div>
</section>
