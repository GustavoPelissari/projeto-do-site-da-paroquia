@props([
    'title',
    'subtitle' => null,
    'minHeight' => '50vh',
    'animate' => false,
    'titleSize' => '2.5rem',
    'subtitleSize' => '1.1rem',
])

<section class="hero-paroquia {{ $animate ? 'animate-on-scroll' : '' }}" style="min-height: {{ $minHeight }};">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="mb-4" style="font-size: {{ $titleSize }}; font-weight: 700; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="lead mb-4" style="font-size: {{ $subtitleSize }}; opacity: 0.95; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                            {{ $subtitle }}
                        </p>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>
