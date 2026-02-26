@props([
    'title',
    'subtitle' => null,
    'description' => null,
])

<section class="hero-paroquia animate-on-scroll">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="mb-4">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="lead mb-4 hero-subtitle">{{ $subtitle }}</p>
                    @endif
                    @if($description)
                        <p class="mb-0 hero-description">{{ $description }}</p>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>
