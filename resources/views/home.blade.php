@extends('layouts.public')

@section('title', 'Paróquia São Paulo Apóstolo - Diocese de Umuarama')
@section('description', 'Paróquia São Paulo Apóstolo em Umuarama - PR. Comunidade católica acolhedora com missas, sacramentos, pastorais e eventos. Venha fazer parte da nossa família de fé.')

@section('content')
<!-- Hero Section -->
<section class="hero-paroquia animate-on-scroll">
    <div class="hero-content">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="mb-4" style="font-size: 3rem; font-weight: 700; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">
                        Bem-vindos à nossa paroquia
                    </h1>
                    <p class="lead mb-4" style="font-size: 1.25rem; opacity: 0.95; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                        Igreja: lugar onde a cidade encontra a graça
                    </p>
                    <p class="mb-5" style="font-size: 1.1rem; opacity: 0.9; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                        Somos uma comunidade católica inspirada no exemplo de São Paulo Apóstolo, 
                        dedicada a evangelizar, acolher e servir com amor e esperança.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('masses') }}" class="btn-hero btn-hero-primary">
                            <i data-lucide="clock"></i>
                            Ver Horários de Missa
                        </a>
                        <a href="#proxima-missa" class="btn-hero btn-hero-outline">
                            <i data-lucide="calendar-check"></i>
                            Próxima Celebração
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Próxima Missa -->
<section id="proxima-missa" class="section-paroquia animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-paroquia text-center p-4">
                    <div class="card-header-paroquia mb-4">
                        <h3 class="mb-0">
                            <i data-lucide="church" class="icon-lg text-dourado me-2"></i>
                            Próxima Missa
                        </h3>
                    </div>
                    <div id="proxima-missa-info">
                        <!-- Conteúdo será atualizado dinamicamente pelo JavaScript -->
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="proxima-missa-item">
                                    <i class="bi bi-calendar3"></i>
                                    <div>
                                        <strong>Carregando...</strong>
                                        <br>
                                        <small>Data</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="proxima-missa-item">
                                    <i class="bi bi-clock"></i>
                                    <div>
                                        <strong>--:--</strong>
                                        <br>
                                        <small>Horário</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="proxima-missa-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <div>
                                        <strong>Igreja Matriz</strong>
                                        <br>
                                        <small>Local</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('masses') }}" class="btn-hero btn-hero-primary">
                            <i data-lucide="calendar"></i>
                            Ver Todos os Horários
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nossa Missão -->
<section class="section-paroquia section-bg-bege animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-4">Nossa Missão</h2>
                <p class="lead text-muted">
                    Inspirados no exemplo de São Paulo Apóstolo, somos uma comunidade que 
                    acolhe, evangeliza e serve com amor fraterno.
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-paroquia h-100 text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="book-open" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Palavra de Deus</h4>
                    </div>
                    <p class="text-muted">
                        Aprofundamos nossa fé através do estudo das Escrituras e da tradição apostólica, 
                        seguindo o exemplo de São Paulo em suas cartas às primeiras comunidades.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card-paroquia h-100 text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="heart" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Caridade</h4>
                    </div>
                    <p class="text-muted">
                        Praticamos o amor ao próximo através de obras de misericórdia e serviço 
                        aos mais necessitados de nossa comunidade e além dela.
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card-paroquia h-100 text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="users" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Comunhão</h4>
                    </div>
                    <p class="text-muted">
                        Vivemos em fraternidade, compartilhando a alegria do Evangelho e 
                        crescendo juntos na caminhada da fé como uma verdadeira família.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pastorais em Destaque -->
@if(isset($groups) && $groups->count() > 0)
<section class="section-paroquia animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-4">Pastorais e Movimentos</h2>
                <p class="lead text-muted">
                    Encontre seu lugar de serviço e crescimento espiritual em nossa comunidade
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($groups->take(6) as $group)
            <div class="col-lg-4 col-md-6">
                <div class="card-paroquia h-100">
                    <div class="card-header-paroquia text-center">
                        <div class="mb-3">
                            <i data-lucide="users" class="icon-lg text-vermelho"></i>
                        </div>
                        <h5 class="mb-0">{{ $group->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">{{ Str::limit($group->description ?? 'Grupo ativo da nossa paróquia', 100) }}</p>
                        
                        <div class="text-center">
                            @auth
                                <a href="{{ route('group-requests.create', ['group' => $group->id]) }}" 
                                   class="btn-paroquia btn-outline-paroquia">
                                    <i data-lucide="user-plus" class="icon-paroquia"></i>
                                    Participar
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn-paroquia btn-outline-paroquia">
                                    <i data-lucide="log-in" class="icon-paroquia"></i>
                                    Entrar para Participar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('groups') }}" class="btn-paroquia btn-primary-paroquia">
                <i data-lucide="arrow-right" class="icon-paroquia"></i>
                Ver Todas as Pastorais
            </a>
        </div>
    </div>
</section>
@endif

<!-- Horários de Missa -->
@if(isset($masses) && $masses->count() > 0)
<section class="section-paroquia section-bg-verde animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-4">Horários de Missas</h2>
                <p class="lead text-muted">
                    Venha participar de nossas celebrações eucarísticas durante a semana
                </p>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            @foreach($masses->take(6) as $mass)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card-paroquia text-center p-4">
                    <h5 class="text-vermelho mb-3">{{ ucfirst($mass->day_of_week) }}</h5>
                    <div class="mb-3">
                        <i data-lucide="clock" class="icon-lg text-dourado"></i>
                    </div>
                    <h4 class="mb-2">{{ $mass->time->format('H:i') }}</h4>
                    <small class="text-muted">{{ $mass->type ?? 'Missa' }}</small>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('masses') }}" class="btn-paroquia btn-primary-paroquia">
                <i data-lucide="calendar" class="icon-paroquia"></i>
                Ver Calendário Completo
            </a>
        </div>
    </div>
</section>
@endif

<!-- Chamada Final -->
<section class="section-paroquia animate-on-scroll">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="card-paroquia p-5">
                    <h3 class="mb-4 text-vermelho">Seja Parte da Nossa Família</h3>
                    <p class="lead text-muted mb-4">
                        "Assim como o corpo é um só e tem muitos membros, e todos os membros do corpo, 
                        embora sejam muitos, formam um só corpo, assim também é Cristo."
                    </p>
                    <p class="text-muted mb-4"><em>1 Coríntios 12:12</em></p>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-paroquia btn-primary-paroquia">
                                    <i data-lucide="user-plus" class="icon-paroquia"></i>
                                    Cadastrar-se
                                </a>
                            @endif
                            <a href="{{ route('login') }}" class="btn-paroquia btn-outline-paroquia">
                                <i data-lucide="log-in" class="icon-paroquia"></i>
                                Fazer Login
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn-paroquia btn-primary-paroquia">
                                <i data-lucide="layout-dashboard" class="icon-paroquia"></i>
                                Acessar Painel
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// Countdown para próxima missa
function updateCountdown() {
    const now = new Date().getTime();
    const nextSunday = new Date();
    
    // Encontrar próximo domingo às 09:30
    const daysUntilSunday = (7 - nextSunday.getDay()) % 7;
    if (daysUntilSunday === 0 && nextSunday.getHours() >= 9 && nextSunday.getMinutes() >= 30) {
        nextSunday.setDate(nextSunday.getDate() + 7);
    } else {
        nextSunday.setDate(nextSunday.getDate() + daysUntilSunday);
    }
    nextSunday.setHours(9, 30, 0, 0);
    
    const distance = nextSunday.getTime() - now;
    
    if (distance > 0) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        
        let countdownText = '';
        if (days > 0) countdownText += days + 'd ';
        if (hours > 0) countdownText += hours + 'h ';
        countdownText += minutes + 'min';
        
        document.getElementById('countdown').textContent = 'Em ' + countdownText;
    } else {
        document.getElementById('countdown').textContent = 'Missa em andamento';
    }
}

// Atualizar countdown a cada minuto
updateCountdown();
setInterval(updateCountdown, 60000);

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
</script>
@endpush