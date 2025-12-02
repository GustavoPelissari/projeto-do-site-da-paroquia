@extends('layout')

@section('title', 'Horários de Missas - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero title="Horários de Missas" subtitle="Confira os horários das nossas celebrações eucarísticas">
    <p class="mb-0" style="opacity: 0.9;">
        "Fazei isto em memória de mim" - Venha participar da mesa eucarística 
        e fortalecer sua fé em comunidade.
    </p>
</x-hero>

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Horários de Missas', 'icon' => 'calendar-week']
    ]" />
</div>

<!-- Horários Principais -->
<section class="section-paroquia">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-4">Horários Regulares</h2>
                <p class="lead text-muted">
                    Nossas celebrações semanais estão organizadas para atender toda a comunidade
                </p>
            </div>
        </div>
        
        @if($masses && $masses->count() > 0)
        @php
            $massesByDay = $masses->groupBy('day_of_week');
            $daysOrder = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            $dayNames = [
                'sunday' => 'Domingo',
                'monday' => 'Segunda-feira',
                'tuesday' => 'Terça-feira',
                'wednesday' => 'Quarta-feira',
                'thursday' => 'Quinta-feira',
                'friday' => 'Sexta-feira',
                'saturday' => 'Sábado'
            ];
            $dayIcons = [
                'sunday' => 'sun',
                'monday' => 'calendar',
                'tuesday' => 'calendar',
                'wednesday' => 'moon',
                'thursday' => 'calendar',
                'friday' => 'calendar',
                'saturday' => 'star'
            ];
        @endphp
        
        <div class="row g-4">
            @foreach($daysOrder as $day)
                @if(isset($massesByDay[$day]) && $massesByDay[$day]->count() > 0)
                <div class="col-lg-4 col-md-6">
                    <div class="card-paroquia h-100">
                        <div class="card-header-paroquia text-center">
                            <div class="mb-3">
                                <i data-lucide="{{ $dayIcons[$day] }}" class="icon-lg text-dourado"></i>
                            </div>
                            <h3 class="mb-0">{{ $dayNames[$day] }}</h3>
                            @if($day == 'sunday')
                                <small class="text-muted">Dia do Senhor</small>
                            @elseif($day == 'saturday')
                                <small class="text-muted">Véspera Dominical</small>
                            @endif
                        </div>
                        <div class="card-body">
                            @foreach($massesByDay[$day] as $mass)
                            <div class="mb-3">
                                <div class="p-3 rounded" style="background: var(--bege-claro);">
                                    <h4 class="text-vermelho mb-2 text-center">{{ \Carbon\Carbon::parse($mass->time)->format('H:i') }}</h4>
                                    <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                        <i data-lucide="map-pin" class="icon-paroquia text-verde"></i>
                                        <small class="text-muted fw-bold">{{ $mass->location }}</small>
                                    </div>
                                    @if($mass->description)
                                    <p class="text-muted small mb-0 text-center">{{ $mass->description }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        @else
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="alert alert-warning text-center">
                    <i data-lucide="alert-circle" class="icon-paroquia"></i>
                    <p class="mb-0">Nenhum horário de missa cadastrado no momento.</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Próxima Missa -->
<section class="section-paroquia section-bg-bege">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card-paroquia text-center p-5">
                    <div class="mb-4">
                        <i data-lucide="church" class="icon-lg text-vermelho" style="width: 64px; height: 64px;"></i>
                    </div>
                    <h3 class="mb-4">Próxima Celebração</h3>
                    
                    <div class="row g-4 align-items-center">
                        <div class="col-md-6">
                            <h4 class="text-vermelho mb-2">Domingo, 3 de Novembro</h4>
                            <p class="text-muted mb-3">32º Domingo do Tempo Comum</p>
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <i data-lucide="clock" class="icon-paroquia text-dourado"></i>
                                <span class="h5 mb-0">09:30</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="countdown-display" class="mb-3">
                                <div class="h4 text-verde" id="countdown-text">
                                    <!-- Countdown será preenchido via JavaScript -->
                                </div>
                                <small class="text-muted">para a próxima missa</small>
                            </div>
                            <a href="#como-chegar" class="btn-paroquia btn-primary-paroquia">
                                <i data-lucide="map-pin" class="icon-paroquia"></i>
                                Como Chegar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Celebrações Especiais -->
<section class="section-paroquia">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="mb-4">Celebrações Especiais</h2>
                <p class="lead text-muted">
                    Além das missas regulares, temos celebrações especiais durante o ano litúrgico
                </p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card-paroquia text-center p-4">
                    <div class="mb-3">
                        <i data-lucide="candle" class="icon-lg text-dourado"></i>
                    </div>
                    <h5 class="mb-2">Primeira Sexta</h5>
                    <p class="text-muted mb-3">Adoração ao Sagrado Coração</p>
                    <small class="text-verde fw-bold">19:30</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card-paroquia text-center p-4">
                    <div class="mb-3">
                        <i data-lucide="rosette" class="icon-lg text-dourado"></i>
                    </div>
                    <h5 class="mb-2">Terço</h5>
                    <p class="text-muted mb-3">Oração Mariana</p>
                    <small class="text-verde fw-bold">Terças 19:00</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card-paroquia text-center p-4">
                    <div class="mb-3">
                        <i data-lucide="cross" class="icon-lg text-dourado"></i>
                    </div>
                    <h5 class="mb-2">Via Sacra</h5>
                    <p class="text-muted mb-3">Sextas da Quaresma</p>
                    <small class="text-verde fw-bold">19:30</small>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="card-paroquia text-center p-4">
                    <div class="mb-3">
                        <i data-lucide="gift" class="icon-lg text-dourado"></i>
                    </div>
                    <h5 class="mb-2">Festa Patronal</h5>
                    <p class="text-muted mb-3">São Paulo Apóstolo</p>
                    <small class="text-verde fw-bold">29 de Junho</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Como Chegar -->
<section id="como-chegar" class="section-paroquia section-bg-verde">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card-paroquia p-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <h3 class="mb-4">Como Chegar na Paróquia</h3>
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i data-lucide="map-pin" class="icon-paroquia text-vermelho mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Endereço</h6>
                                    <p class="text-muted mb-0">
                                        Av. General Mascarenhas de Morais, 4969<br>
                                        Umuarama - PR, CEP 87501-100
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i data-lucide="car" class="icon-paroquia text-vermelho mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Estacionamento</h6>
                                    <p class="text-muted mb-0">
                                        Vagas disponíveis no pátio da paróquia<br>
                                        <small>Entrada pela Av. Mascarenhas de Morais</small>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start gap-3 mb-4">
                                <i data-lucide="accessibility" class="icon-paroquia text-vermelho mt-1"></i>
                                <div>
                                    <h6 class="mb-1">Acessibilidade</h6>
                                    <p class="text-muted mb-0">
                                        Igreja com acesso para cadeirantes<br>
                                        <small>Rampas e banheiro adaptado</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="rounded overflow-hidden" style="height: 100%; min-height: 350px;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14548.62969641595!2d-53.2972824!3d-23.7590074!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94f0f18d19ab85cd%3A0xd94e5f80df8017ab!2zUGFyw7NxdWlhIFNhbnRhIEplYW5lIGQnQXJj!5e0!3m2!1spt-BR!2sbr!4v1737564043558!5m2!1spt-BR!2sbr" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0; min-height: 350px;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                            <div class="mt-3">
                                <div class="d-grid gap-2">
                                    <a href="https://maps.app.goo.gl/RoEbuP19YY1AtxDk7" 
                                       target="_blank" 
                                       class="btn-paroquia btn-primary-paroquia">
                                        <i data-lucide="map" class="icon-paroquia"></i>
                                        Abrir no Google Maps
                                    </a>
                                    <a href="https://waze.com/ul?q=Av.+General+Mascarenhas+de+Morais,+4969,+Umuarama,+PR" 
                                       target="_blank" 
                                       class="btn-paroquia btn-outline-paroquia">
                                        <i data-lucide="navigation-2" class="icon-paroquia"></i>
                                        Abrir no Waze
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informações Adicionais -->
<section class="section-paroquia">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-paroquia h-100 p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i data-lucide="info" class="icon-lg text-vermelho"></i>
                        <h4 class="mb-0">Orientações Gerais</h4>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i data-lucide="clock" class="icon-paroquia text-dourado mt-1"></i>
                            <span>Chegue com 10-15 minutos de antecedência</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i data-lucide="volume-x" class="icon-paroquia text-dourado mt-1"></i>
                            <span>Mantenha o celular no silencioso durante a celebração</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i data-lucide="shirt" class="icon-paroquia text-dourado mt-1"></i>
                            <span>Traje adequado para o ambiente sagrado</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start gap-2">
                            <i data-lucide="heart" class="icon-paroquia text-dourado mt-1"></i>
                            <span>Participe ativamente dos cantos e orações</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card-paroquia h-100 p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <i data-lucide="phone" class="icon-lg text-vermelho"></i>
                        <h4 class="mb-0">Contato</h4>
                    </div>
                    <div class="mb-3">
                        <h6 class="mb-2">Secretaria Paroquial</h6>
                        <p class="text-muted mb-1">
                            <i data-lucide="phone" class="icon-paroquia me-2"></i>
                            (44) 3055-4464
                        </p>
                        <p class="text-muted mb-3">
                            <i data-lucide="mail" class="icon-paroquia me-2"></i>
                            secretaria.pspaulo@hotmail.com
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="mb-2">Horário de Atendimento</h6>
                        <p class="text-muted mb-1">Segunda a Sexta: 8h00 às 11h30 e 13h30 às 17h00</p>
                        <p class="text-muted">Sábado: 8h00 às 11h30</p>
                    </div>
                    
                    <a href="https://wa.me/554430554464?text=Olá,%20gostaria%20de%20mais%20informações%20sobre%20a%20paróquia" target="_blank" class="btn-paroquia btn-outline-paroquia">
                        <i data-lucide="message-circle" class="icon-paroquia"></i>
                        Falar no WhatsApp
                    </a>
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
        if (days > 0) countdownText += `${days}d `;
        if (hours > 0) countdownText += `${hours}h `;
        countdownText += `${minutes}min`;
        
        document.getElementById('countdown-text').textContent = countdownText;
    } else {
        document.getElementById('countdown-text').textContent = 'Missa em andamento';
    }
}

// Atualizar countdown a cada minuto
updateCountdown();
setInterval(updateCountdown, 60000);
</script>
@endpush



