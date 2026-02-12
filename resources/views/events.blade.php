@extends('layouts.public')

@section('title', 'Eventos - Paróquia São Paulo Apóstolo')
@section('description', 'Participe dos eventos e atividades da Paróquia São Paulo Apóstolo em Umuarama - PR.')

@section('content')
<section class="py-5 bg-dark text-white text-center">
    <div class="container py-4">
        <h1 class="display-6 fw-bold mb-3">Eventos da Paróquia</h1>
        <p class="lead mb-0">Participe das atividades da nossa comunidade de fé.</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                <div class="col-lg-6 col-xl-4">
                    <div class="card shadow-sm h-100">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="card-img-top" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 220px;">
                                <i class="bi bi-calendar-event fs-1 text-primary"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-2 text-muted small">
                                <span>{{ $event->start_date->format('d/m/Y') }}</span>
                                @if($event->start_time)
                                    <span class="ms-2">{{ $event->start_time->format('H:i') }}</span>
                                @endif
                                @if($event->category)
                                    <span class="badge bg-secondary ms-auto">{{ $event->category }}</span>
                                @endif
                            </div>

                            <h2 class="h5 text-primary">{{ $event->title }}</h2>

                            @if($event->location)
                                <p class="small text-muted mb-2">{{ $event->location }}</p>
                            @endif

                            <p class="text-muted flex-grow-1">{{ Str::limit($event->summary ?: strip_tags($event->description), 150) }}</p>

                            <div class="mt-auto">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->id }}">
                                    Ver Detalhes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title h5" id="eventModalLabel{{ $event->id }}">{{ $event->title }}</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-3">
                                @endif

                                <p class="mb-1"><strong>Data:</strong> {{ $event->start_date->format('d/m/Y') }}</p>
                                @if($event->start_time)
                                    <p class="mb-1"><strong>Horário:</strong> {{ $event->start_time->format('H:i') }}@if($event->end_time) - {{ $event->end_time->format('H:i') }}@endif</p>
                                @endif
                                @if($event->location)
                                    <p class="mb-1"><strong>Local:</strong> {{ $event->location }}</p>
                                @endif
                                @if($event->category)
                                    <p class="mb-3"><strong>Categoria:</strong> <span class="badge bg-secondary">{{ $event->category }}</span></p>
                                @endif

                                @if($event->description)
                                    <div>{!! nl2br(e($event->description)) !!}</div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($events->hasPages())
            <div class="d-flex justify-content-center mt-4">{{ $events->links() }}</div>
            @endif
        @else
            <div class="card shadow-sm text-center">
                <div class="card-body py-5">
                    <h2 class="h4 text-muted">Nenhum evento programado</h2>
                    <p class="text-muted mb-0">Volte em breve para conferir os próximos eventos.</p>
                </div>
            </div>
        @endif
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="h4 text-primary mb-3">Participe da Nossa Comunidade</h2>
                <p class="mb-4">Conheça as pastorais e acompanhe os horários de celebração.</p>
                <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center">
                    <a href="{{ route('groups') }}" class="btn btn-primary">Conhecer Pastorais</a>
                    <a href="{{ route('masses') }}" class="btn btn-outline-primary">Ver Horários</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
