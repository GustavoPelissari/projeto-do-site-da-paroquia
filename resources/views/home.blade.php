@extends('layouts.public')

@section('title', 'Paróquia São Paulo Apóstolo - Diocese de Umuarama')
@section('description', 'Paróquia São Paulo Apóstolo em Umuarama - PR. Comunidade católica acolhedora com missas, sacramentos, pastorais e eventos. Venha fazer parte da nossa família de fé.')

@section('content')
<!-- Hero Section -->
<section class="hero-paroquia animate-on-scroll">
    <div class="hero-content">
        <div class="sp-page-container">
            <div class="mx-auto max-w-4xl text-center">
                    <h1 class="hero-title mb-4">
                        Bem-vindos à nossa paroquia
                    </h1>
                    <p class="hero-subtitle mb-4 text-xl">
                        Igreja: lugar onde a cidade encontra a graça
                    </p>
                    <p class="hero-description mb-5">
                        Somos uma comunidade católica inspirada no exemplo de São Paulo Apóstolo, 
                        dedicada a evangelizar, acolher e servir com amor e esperança.
                    </p>
                    <div class="flex flex-col justify-center gap-3 sm:flex-row">
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
</section>

<!-- Próxima Missa -->
<section id="proxima-missa" class="section-paroquia animate-on-scroll">
    <div class="sp-page-container">
        <div class="mx-auto max-w-4xl">
                <div class="card-paroquia text-center p-4">
                    <div class="card-header-paroquia mb-4">
                        <h3 class="mb-0">
                            <i data-lucide="church" class="icon-lg mr-2 text-dourado"></i>
                            Próxima Missa
                        </h3>
                    </div>
                    <div id="proxima-missa-info">
                        <!-- Conteúdo será atualizado dinamicamente pelo JavaScript -->
                        <div class="grid grid-cols-1 gap-4 text-center md:grid-cols-3">
                            <div>
                                <div class="proxima-missa-item">
                                    <i data-lucide="calendar-days" class="icon-lg text-dourado" aria-hidden="true"></i>
                                    <div>
                                        <strong>Carregando...</strong>
                                        <br>
                                        <small>Data</small>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="proxima-missa-item">
                                    <i data-lucide="clock-3" class="icon-lg text-dourado" aria-hidden="true"></i>
                                    <div>
                                        <strong>--:--</strong>
                                        <br>
                                        <small>Horário</small>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="proxima-missa-item">
                                    <i data-lucide="map-pin" class="icon-lg text-dourado" aria-hidden="true"></i>
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
</section>

<!-- Nossa Missão -->
<section class="section-paroquia section-bg-bege animate-on-scroll">
    <div class="sp-page-container">
        <div class="mx-auto mb-10 max-w-4xl text-center">
                <h2 class="mb-4">Nossa Missão</h2>
                <p class="text-lg text-gray-600">
                    Inspirados no exemplo de São Paulo Apóstolo, somos uma comunidade que 
                    acolhe, evangeliza e serve com amor fraterno.
                </p>
        </div>
        
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div>
                <div class="card-paroquia h-full text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="book-open" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Palavra de Deus</h4>
                    </div>
                    <p class="text-gray-600">
                        Aprofundamos nossa fé através do estudo das Escrituras e da tradição apostólica, 
                        seguindo o exemplo de São Paulo em suas cartas às primeiras comunidades.
                    </p>
                </div>
            </div>
            
            <div>
                <div class="card-paroquia h-full text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="heart" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Caridade</h4>
                    </div>
                    <p class="text-gray-600">
                        Praticamos o amor ao próximo através de obras de misericórdia e serviço 
                        aos mais necessitados de nossa comunidade e além dela.
                    </p>
                </div>
            </div>
            
            <div>
                <div class="card-paroquia h-full text-center p-4">
                    <div class="mb-4">
                        <i data-lucide="users" class="icon-lg text-vermelho mb-3"></i>
                        <h4>Comunhão</h4>
                    </div>
                    <p class="text-gray-600">
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
    <div class="sp-page-container">
        <div class="mx-auto mb-10 max-w-4xl text-center">
                <h2 class="mb-4">Pastorais e Movimentos</h2>
                <p class="text-lg text-gray-600">
                    Encontre seu lugar de serviço e crescimento espiritual em nossa comunidade
                </p>
        </div>
        
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($groups->take(6) as $group)
            <div>
                <div class="card-paroquia h-full">
                    <div class="card-header-paroquia text-center">
                        <div class="mb-3">
                            <i data-lucide="users" class="icon-lg text-vermelho"></i>
                        </div>
                        <h5 class="mb-0">{{ $group->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3 text-gray-600">{{ Str::limit($group->description ?? 'Grupo ativo da nossa paróquia', 100) }}</p>
                        
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
    <div class="sp-page-container">
        <div class="mx-auto mb-10 max-w-4xl text-center">
                <h2 class="mb-4">Horários de Missas</h2>
                <p class="text-lg text-gray-600">
                    Venha participar de nossas celebrações eucarísticas durante a semana
                </p>
        </div>
        
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($masses->take(6) as $mass)
            <div>
                <div class="card-paroquia text-center p-4">
                    <h5 class="text-vermelho mb-3">{{ ucfirst($mass->day_of_week) }}</h5>
                    <div class="mb-3">
                        <i data-lucide="clock" class="icon-lg text-dourado"></i>
                    </div>
                    <h4 class="mb-2">{{ $mass->time->format('H:i') }}</h4>
                    <small class="text-gray-600">{{ $mass->type ?? 'Missa' }}</small>
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
    <div class="sp-page-container">
        <div class="mx-auto max-w-4xl text-center">
                <div class="card-paroquia p-5">
                    <h3 class="mb-4 text-vermelho">Seja Parte da Nossa Família</h3>
                    <p class="mb-4 text-lg text-gray-600">
                        "Assim como o corpo é um só e tem muitos membros, e todos os membros do corpo, 
                        embora sejam muitos, formam um só corpo, assim também é Cristo."
                    </p>
                    <p class="mb-4 text-gray-600"><em>1 Coríntios 12:12</em></p>
                    
                    <div class="flex flex-col justify-center gap-3 sm:flex-row">
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
