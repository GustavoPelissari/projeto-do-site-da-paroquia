@extends('layout')

@section('title', 'Paróquia São Paulo Apóstolo - Diocese de Umuarama')

@push('styles')
<style>
/* Lazy loading para imagens */
img[loading="lazy"] {
    opacity: 0;
    transition: opacity 0.3s;
}

img[loading="lazy"].loaded {
    opacity: 1;
}
</style>
@endpush

@section('content')
<!-- Hero Section Moderno -->
<header class="hero-paroquia">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="display-4 fw-bold mb-4">Bem-vindos à nossa paróquia</h1>
                    <p class="lead mb-4">Onde a fé encontra acolhimento e a esperança se renova</p>
                    <p class="mb-5" style="font-size: 1.1rem; opacity: 0.9; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7); max-width: 600px; margin: 0 auto;">
                        Somos uma comunidade católica inspirada no exemplo de São Paulo Apóstolo, 
                        dedicada a evangelizar, acolher e servir com amor e esperança.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('masses') }}" class="btn-hero btn-hero-primary">
                            <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                            Participar da próxima celebração
                        </a>
                        <a href="#proxima-missa" class="btn-hero btn-hero-outline">
                            <i data-lucide="calendar-check" style="width: 20px; height: 20px;"></i>
                            Ver todos os horários
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Próxima Missa - Card Moderno -->
<section id="proxima-missa" class="section-paroquia animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-paroquia text-center p-4 proxima-missa-card">
                    <div class="card-header-paroquia mb-4">
                        <h3 class="mb-0">
                            <i data-lucide="church" class="icon-lg text-white me-2" style="width: 32px; height: 32px;"></i>
                            Próxima Missa
                        </h3>
                    </div>
                    
                    @if($masses->isNotEmpty())
                        @php
                            $proximaMissa = $masses->first();
                            $diasSemana = [
                                0 => 'Domingo', 1 => 'Segunda', 2 => 'Terça', 3 => 'Quarta',
                                4 => 'Quinta', 5 => 'Sexta', 6 => 'Sábado'
                            ];
                            
                            // Converter string do dia da semana para número
                            $diasParaNumero = [
                                'sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
                                'thursday' => 4, 'friday' => 5, 'saturday' => 6
                            ];
                            
                            // Calcular próxima data baseada no dia da semana
                            $hoje = now();
                            $diaAtual = $hoje->dayOfWeek;
                            $diaDaMissa = $diasParaNumero[$proximaMissa->day_of_week] ?? 0;
                            $diasParaProxima = ($diaDaMissa - $diaAtual + 7) % 7;
                            if ($diasParaProxima == 0) $diasParaProxima = 7; // Próxima semana se for hoje
                            $dataProxima = $hoje->addDays($diasParaProxima);
                        @endphp
                        
                        <div class="row text-center align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="d-flex flex-column">
                                    <small class="text-muted mb-1">{{ $diasParaProxima <= 1 ? 'Hoje' : $diasSemana[$diaDaMissa] }}</small>
                                    <h5 class="mb-0 text-vinho fw-bold">{{ $dataProxima->format('d/m/Y') }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="d-flex flex-column">
                                    <small class="text-muted mb-1">Horário</small>
                                    <h4 class="mb-0 text-vinho fw-bold">{{ $proximaMissa->time->format('H:i') }}</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <small class="text-muted mb-1">Local</small>
                                    <h5 class="mb-0 text-vinho fw-bold">{{ $proximaMissa->location ?? 'Igreja Matriz' }}</h5>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i data-lucide="calendar-x" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
                            <h5 class="text-muted">Nenhuma missa programada</h5>
                            <p class="text-muted mb-0">Entre em contato para mais informações</p>
                        </div>
                    @endif
                    
                    <div class="mt-4">
                        <a href="{{ route('masses') }}" class="btn btn-vinho rounded-pill px-5 py-2 fw-semibold">
                            <i data-lucide="calendar" class="me-2" style="width: 16px; height: 16px;"></i>
                            Ver todos os horários
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Horários de Missa -->
<section class="section-paroquia animate-on-scroll" style="background: white;">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="text-vinho mb-3">Horários das Celebrações</h2>
                <p class="lead text-muted">
                    Participe das nossas celebrações semanais e fortaleça sua fé em comunidade
                </p>
            </div>
        </div>
        
        @if($masses->isNotEmpty())
            <div class="horarios-grid">
                @foreach($masses as $mass)
                    @php
                        $diasSemana = [
                            'sunday' => 'Domingo', 'monday' => 'Segunda-feira', 'tuesday' => 'Terça-feira', 
                            'wednesday' => 'Quarta-feira', 'thursday' => 'Quinta-feira', 'friday' => 'Sexta-feira', 
                            'saturday' => 'Sábado'
                        ];
                        $diasNumeros = [
                            'sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
                            'thursday' => 4, 'friday' => 5, 'saturday' => 6
                        ];
                    @endphp
                    <div class="horario-card animate-on-scroll">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="text-vinho fw-bold mb-1">{{ $diasSemana[$mass->day_of_week] ?? $mass->day_of_week }}</h5>
                                <p class="text-muted mb-0 small">{{ $mass->location ?? 'Igreja Matriz' }}</p>
                            </div>
                            <div class="text-end">
                                <h4 class="text-vinho fw-bold mb-0">{{ $mass->time->format('H:i') }}</h4>
                                @if($mass->day_of_week == 'sunday')
                                    <span class="badge bg-vinho text-white small">Missa Principal</span>
                                @endif
                            </div>
                        </div>
                        
                        @if($mass->description)
                            <p class="text-muted small mb-3">{{ $mass->description }}</p>
                        @endif
                        
                        <div class="d-flex align-items-center text-muted small">
                            <i data-lucide="clock" class="me-2" style="width: 14px; height: 14px;"></i>
                            <span>Chegue 15 minutos antes do início</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i data-lucide="calendar-plus" class="text-muted mb-3" style="width: 64px; height: 64px;"></i>
                <h4 class="text-muted">Horários em breve</h4>
                <p class="text-muted">Os horários das missas serão divulgados em breve.</p>
            </div>
        @endif
    </div>
</section>

<!-- Quem Somos -->
<section class="section-paroquia animate-on-scroll" style="background: var(--bg-rose);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="pe-lg-4">
                    <h2 class="text-vinho mb-4">Nossa Comunidade</h2>
                    <p class="lead text-muted mb-4">
                        Somos uma paróquia católica dedicada a seguir os ensinamentos de Jesus Cristo, 
                        inspirados no exemplo missionário de São Paulo Apóstolo.
                    </p>
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-feature me-3">
                            <i data-lucide="heart" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="text-vinho fw-semibold mb-2">Amor e Acolhimento</h5>
                            <p class="text-muted mb-0">Recebemos a todos com carinho e respeito, construindo uma família de fé unida.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <div class="icon-feature me-3">
                            <i data-lucide="users" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="text-vinho fw-semibold mb-2">Comunidade Ativa</h5>
                            <p class="text-muted mb-0">Participamos ativamente da vida comunitária através de pastorais e grupos de oração.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="icon-feature me-3">
                            <i data-lucide="book-open" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="text-vinho fw-semibold mb-2">Formação e Fé</h5>
                            <p class="text-muted mb-0">Oferecemos formação cristã para todas as idades, fortalecendo nossa caminhada espiritual.</p>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline-vinho rounded-pill px-4 py-2">
                        <i data-lucide="arrow-right" class="me-2" style="width: 16px; height: 16px;"></i>
                        Conheça nossa história
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <div class="image-card-paroquia">
                        <img src="{{ asset('images/igreja-matriz.jpg') }}" 
                             alt="Igreja Matriz São Paulo Apóstolo" 
                             class="img-fluid rounded-3 shadow-lg"
                             loading="lazy">
                        <div class="image-overlay">
                            <div class="text-center text-white p-4">
                                <h4 class="fw-bold mb-2">Igreja Matriz</h4>
                                <p class="mb-0">São Paulo Apóstolo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pastorais em Destaque -->
@if(isset($groups) && $groups->count() > 0)
<section class="section-paroquia animate-on-scroll" style="background: white;">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="text-vinho mb-3">Pastorais e Movimentos</h2>
                <p class="lead text-muted">
                    Encontre seu lugar de serviço e crescimento espiritual em nossa comunidade
                </p>
            </div>
        </div>
        
        <div class="pastorais-grid">
            @foreach($groups->take(6) as $group)
                <div class="pastoral-card animate-on-scroll">
                    <div class="pastoral-header">
                        <div class="pastoral-icon">
                            <i data-lucide="users" style="width: 32px; height: 32px;"></i>
                        </div>
                        <h4 class="pastoral-title">{{ $group->name }}</h4>
                    </div>
                    
                    <div class="pastoral-content">
                        <p class="pastoral-description">
                            {{ Str::limit($group->description ?? 'Grupo ativo da nossa paróquia dedicado ao serviço e crescimento espiritual da comunidade.', 120) }}
                        </p>
                        
                        <div class="pastoral-action">
                            @auth
                                <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" 
                                   class="btn btn-outline-vinho rounded-pill px-4 py-2">
                                    <i data-lucide="user-plus" class="me-2" style="width: 16px; height: 16px;"></i>
                                    Participar
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-vinho rounded-pill px-4 py-2">
                                    <i data-lucide="log-in" class="me-2" style="width: 16px; height: 16px;"></i>
                                    Entrar para Participar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('groups') }}" class="btn btn-vinho rounded-pill px-5 py-2 fw-semibold">
                <i data-lucide="arrow-right" class="me-2" style="width: 16px; height: 16px;"></i>
                Ver Todas as Pastorais
            </a>
        </div>
    </div>
</section>
@endif

<!-- Notícias -->
@if($news->isNotEmpty())
<section class="section-paroquia animate-on-scroll" style="background: var(--bg-rose);">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="text-vinho mb-3">Últimas Notícias</h2>
                <p class="lead text-muted">
                    Fique por dentro das atividades e eventos da nossa comunidade paroquial
                </p>
            </div>
        </div>
        
        <div class="noticias-grid">
            @foreach($news->take(3) as $noticia)
                <article class="noticia-card animate-on-scroll">
                    @if($noticia->image)
                        <div class="noticia-image">
                            <img src="{{ asset('storage/' . $noticia->image) }}" 
                                 alt="{{ $noticia->title }}"
                                 loading="lazy">
                        </div>
                    @else
                        <div class="noticia-image noticia-placeholder">
                            <i data-lucide="image" style="width: 48px; height: 48px; opacity: 0.3;"></i>
                        </div>
                    @endif
                    
                    <div class="noticia-content">
                        <div class="noticia-meta">
                            <time class="text-muted">
                                <i data-lucide="calendar" class="me-1" style="width: 14px; height: 14px;"></i>
                                {{ $noticia->created_at->format('d/m/Y') }}
                            </time>
                        </div>
                        
                        <h4 class="noticia-title">
                            <a href="#" class="text-decoration-none text-vinho">{{ $noticia->title }}</a>
                        </h4>
                        
                        <p class="noticia-excerpt">
                            {{ Str::limit(strip_tags($noticia->content), 120) }}
                        </p>
                        
                        <a href="#" class="btn btn-sm btn-outline-vinho rounded-pill">
                            Ler mais
                            <i data-lucide="arrow-right" class="ms-1" style="width: 14px; height: 14px;"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('news') }}" class="btn btn-vinho rounded-pill px-5 py-2 fw-semibold">
                <i data-lucide="newspaper" class="me-2" style="width: 16px; height: 16px;"></i>
                Ver todas as notícias
            </a>
        </div>
    </div>
</section>
@endif

<!-- Eventos -->
@if($events->isNotEmpty())
<section class="section-paroquia animate-on-scroll" style="background: white;">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="text-vinho mb-3">Próximos Eventos</h2>
                <p class="lead text-muted">
                    Participe dos eventos e atividades da nossa comunidade paroquial
                </p>
            </div>
        </div>
        
        <div class="eventos-grid">
            @foreach($events->take(3) as $event)
                <div class="evento-card animate-on-scroll">
                    <div class="evento-date">
                        <span class="dia">{{ $event->start_date ? $event->start_date->format('d') : '--' }}</span>
                        <span class="mes">{{ $event->start_date ? $event->start_date->format('M') : '--' }}</span>
                    </div>
                    
                    <div class="evento-content">
                        <h4 class="evento-title">{{ $event->title }}</h4>
                        <div class="evento-meta">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i data-lucide="clock" class="me-2" style="width: 16px; height: 16px;"></i>
                                <span>{{ $event->start_date ? $event->start_date->format('H:i') : 'A definir' }}</span>
                            </div>
                            @if($event->location)
                                <div class="d-flex align-items-center text-muted">
                                    <i data-lucide="map-pin" class="me-2" style="width: 16px; height: 16px;"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>
                        
                        @if($event->description)
                            <p class="evento-description">
                                {{ Str::limit($event->description, 100) }}
                            </p>
                        @endif
                        
                        <a href="#" class="btn btn-sm btn-outline-vinho rounded-pill mt-3">
                            Saiba mais
                            <i data-lucide="arrow-right" class="ms-1" style="width: 14px; height: 14px;"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('events') }}" class="btn btn-vinho rounded-pill px-5 py-2 fw-semibold">
                <i data-lucide="calendar-days" class="me-2" style="width: 16px; height: 16px;"></i>
                Ver todos os eventos
            </a>
        </div>
    </div>
</section>
@endif

<!-- Call to Action -->
<section class="section-paroquia animate-on-scroll cta-paroquia">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-4">Venha fazer parte da nossa família</h2>
                <p class="lead text-white mb-5" style="opacity: 0.9;">
                    Nossa paróquia está de portas abertas para acolher você e sua família. 
                    Juntos, construímos uma comunidade de fé, esperança e amor.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="#" class="btn btn-white rounded-pill px-5 py-3 fw-semibold">
                        <i data-lucide="phone" class="me-2" style="width: 20px; height: 20px;"></i>
                        Entre em contato
                    </a>
                    <a href="{{ route('masses') }}" class="btn btn-outline-light rounded-pill px-5 py-3 fw-semibold">
                        <i data-lucide="map-pin" class="me-2" style="width: 20px; height: 20px;"></i>
                        Como chegar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lazy loading de imagens
    const images = document.querySelectorAll('img[loading="lazy"]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Animações on scroll
    const animateElements = document.querySelectorAll('.animate-on-scroll');
    
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        scrollObserver.observe(el);
    });
    
    // Smooth scroll para âncoras
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush
@endsection