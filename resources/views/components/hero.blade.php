@props([
    'title',
    'subtitle' => null,
    'minHeight' => '50vh',
    'animate' => false,
    'titleSize' => '2.5rem',
    'subtitleSize' => '1.1rem',
])

<section class="hero-paroquia">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="mb-4 hero-title">
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="lead mb-4 hero-subtitle">
                            {{ $subtitle }}
                        </p>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-paroquia {
    min-height: 50vh;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
}

.hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.95;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
}
</style>
