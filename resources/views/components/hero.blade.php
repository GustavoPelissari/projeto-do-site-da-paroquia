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
                <div class="col-lg-8 col-md-10">
                    <h1 class="mb-3 mb-md-4 hero-title">
                        {{ $title }}
                    </h1>
                    @if($subtitle)
                        <p class="lead mb-3 mb-md-4 hero-subtitle">
                            {{ $subtitle }}
                        </p>
                    @endif
                    <div class="hero-actions">
                        {{ $slot }}
                    </div>
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
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.1rem;
    opacity: 0.95;
    color: #fff;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
    line-height: 1.5;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    justify-content: center;
    align-items: center;
}

/* Responsivo - Hero mais compacto no mobile */
@media (max-width: 768px) {
    .hero-paroquia {
        min-height: 45vh;
    }
    
    .hero-title {
        font-size: 1.75rem;
        margin-bottom: 0.75rem !important;
    }
    
    .hero-subtitle {
        font-size: 0.95rem;
        margin-bottom: 1rem !important;
    }
    
    .hero-content {
        padding: 1.5rem 0;
    }
    
    .hero-actions {
        flex-direction: column;
        width: 100%;
        gap: 0.75rem;
    }
    
    .hero-actions > * {
        width: 100%;
        max-width: 100%;
    }
}

@media (max-width: 576px) {
    .hero-paroquia {
        min-height: 40vh;
    }
    
    .hero-title {
        font-size: 1.5rem;
    }
    
    .hero-subtitle {
        font-size: 0.9rem;
    }
}
</style>
