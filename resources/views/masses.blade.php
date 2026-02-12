@extends('layouts.public')

@section('title', 'Horários de Missas - Paróquia São Paulo Apóstolo')
@section('description', 'Confira os horários das celebrações eucarísticas na Paróquia São Paulo Apóstolo em Umuarama - PR.')

@section('content')
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-6 fw-bold mb-3">Horários de Missas</h1>
        <p class="lead mb-0">Confira os horários das nossas celebrações eucarísticas.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="h3">Horários Regulares</h2>
            <p class="text-muted mb-0">Nossas celebrações semanais para toda a comunidade.</p>
        </div>

        @if($masses->count() > 0)
            @php
                $orderedDays = ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'];
                $groupedMasses = $masses->groupBy(fn($mass) => mb_strtolower($mass->day_of_week));
            @endphp
            <div class="row g-4">
                @foreach($orderedDays as $day)
                    @if(isset($groupedMasses[$day]))
                    <div class="col-lg-4 col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h3 class="h5 text-primary mb-3">{{ ucfirst($day) }}</h3>
                                <ul class="list-group list-group-flush">
                                    @foreach($groupedMasses[$day] as $mass)
                                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <span>{{ $mass->type ?? 'Missa' }}</span>
                                        <strong>{{ $mass->time->format('H:i') }}</strong>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="card shadow-sm text-center">
                <div class="card-body py-5">
                    <h3 class="h4 text-muted">Horários em atualização</h3>
                    <p class="text-muted mb-0">Em breve publicaremos os horários das próximas celebrações.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<section class="py-5 bg-light" id="como-chegar">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h4 text-primary mb-3">Como Chegar</h2>
                        <p class="mb-2"><strong>Endereço:</strong> Av. General Mascarenhas de Morais, 4969 - Umuarama/PR</p>
                        <p class="mb-2"><strong>Estacionamento:</strong> Vagas no pátio da paróquia</p>
                        <p class="mb-4"><strong>Acessibilidade:</strong> Rampas e banheiro adaptado</p>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <a href="https://www.google.com/maps/dir//Av.+General+Mascarenhas+de+Morais,+4969+-+Umuarama+-+PR" target="_blank" class="btn btn-primary">Abrir no Google Maps</a>
                            <a href="https://waze.com/ul?q=Av.+General+Mascarenhas+de+Morais,+4969,+Umuarama,+PR" target="_blank" class="btn btn-outline-primary">Abrir no Waze</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h2 class="h5 text-primary mb-3">Contato da Secretaria</h2>
                        <p class="mb-2"><strong>Telefone:</strong> <a href="tel:+554430554464" class="text-decoration-none">(44) 3055-4464</a></p>
                        <p class="mb-3"><strong>Email:</strong> <a href="mailto:secretaria.pspaulo@hotmail.com" class="text-decoration-none">secretaria.pspaulo@hotmail.com</a></p>
                        <p class="mb-0 text-muted">Seg-Sex: 8h às 11h30 e 13h30 às 17h · Sáb: 8h às 11h30</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
