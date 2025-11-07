@extends('layout')

@section('title', 'Eventos - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero title="Eventos da Paróquia" subtitle="Participe das atividades da nossa comunidade de fé" titleSize="3rem" subtitleSize="1.25rem" />

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Eventos', 'icon' => 'calendar-event']
    ]" />
</div>

<!-- Eventos -->
<section class="section-paroquia">
    <div class="container">
        @if($events->count() > 0)
            <div class="row g-4">
                @foreach($events as $event)
                <div class="col-lg-6 col-xl-4">
                    <div class="card-paroquia h-100">
                        @if($event->image)
                            <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <x-card.placeholder height="200px" bg="linear-gradient(135deg, var(--sp-vermelho-manto) 0%, var(--sp-vermelho-bordô) 100%)" icon="bi bi-calendar-event" iconClass="text-white" />
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3 text-muted">
                                <i class="bi bi-calendar3 me-2"></i>
                                <small>{{ $event->start_date->format('d/m/Y') }}</small>
                                @if($event->start_time)
                                    <i class="bi bi-clock ms-3 me-1"></i>
                                    <small>{{ $event->start_time->format('H:i') }}</small>
                                @endif
                                @if($event->category)
                                    <span class="badge bg-secondary ms-auto">{{ $event->category }}</span>
                                @endif
                            </div>
                            
                            <h5 class="card-title text-vermelho">{{ $event->title }}</h5>
                            
                            @if($event->location)
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
                                </p>
                            @endif
                            
                            @if($event->summary)
                                <p class="card-text flex-grow-1">{{ Str::limit($event->summary, 150) }}</p>
                            @else
                                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($event->description), 150) }}</p>
                            @endif
                            
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('events.show', $event) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-eye me-1"></i>Ver Detalhes
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#eventModal{{ $event->id }}">
                                    <i class="bi bi-info-circle me-1"></i>Resumo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal para evento completo -->
                <div class="modal fade" id="eventModal{{ $event->id }}" tabindex="-1" aria-labelledby="eventModalLabel{{ $event->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-vermelho" id="eventModalLabel{{ $event->id }}">{{ $event->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($event->image)
                                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-3">
                                @endif
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-calendar3 me-2 text-vermelho"></i>
                                            <strong>Data:</strong>
                                            <span class="ms-2">{{ $event->start_date->format('d/m/Y') }}</span>
                                        </div>
                                        @if($event->start_time)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clock me-2 text-vermelho"></i>
                                            <strong>Horário:</strong>
                                            <span class="ms-2">{{ $event->start_time->format('H:i') }}</span>
                                            @if($event->end_time)
                                                - {{ $event->end_time->format('H:i') }}
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if($event->location)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt me-2 text-vermelho"></i>
                                            <strong>Local:</strong>
                                            <span class="ms-2">{{ $event->location }}</span>
                                        </div>
                                        @endif
                                        @if($event->category)
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-tag me-2 text-vermelho"></i>
                                            <strong>Categoria:</strong>
                                            <span class="ms-2 badge bg-secondary">{{ $event->category }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($event->description)
                                <div class="content">
                                    <h6 class="text-vermelho">Descrição:</h6>
                                    {!! nl2br(e($event->description)) !!}
                                </div>
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
            
            <!-- Paginação -->
            @if($events->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $events->links() }}
                </div>
            </div>
            @endif
        @else
            <div class="row">
                <div class="col-12">
                    <div class="card-paroquia text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-calendar-event icon-lg mb-4" style="font-size: 4rem; opacity: 0.5;"></i>
                            <h3 class="text-vermelho mb-3">Nenhum evento programado</h3>
                            <p class="text-muted">Não há eventos programados no momento. Fique atento às nossas redes sociais e volte em breve!</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Seção de chamada para ação -->
<section class="section-paroquia" style="background: rgba(139, 21, 56, 0.03);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card-paroquia p-5">
                    <h3 class="text-vermelho mb-3">
                        <i class="bi bi-people me-2"></i>
                        Participe da Nossa Comunidade
                    </h3>
                    <p class="mb-4">
                        Venha fazer parte das nossas pastorais e grupos de oração. Há sempre um lugar para você!
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('groups') }}" class="btn btn-success">
                            <i class="bi bi-people me-1"></i>Conhecer Pastorais
                        </a>
                        <a href="{{ route('masses') }}" class="btn btn-warning">
                            <i class="bi bi-clock me-1"></i>Ver Horários
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.content {
    line-height: 1.8;
    font-size: 1.05rem;
}

.content p {
    margin-bottom: 1rem;
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.modal-header {
    border-bottom: 1px solid rgba(139, 21, 56, 0.1);
    background: rgba(139, 21, 56, 0.03);
}

.pagination {
    --bs-pagination-active-bg: var(--sp-vermelho-manto);
    --bs-pagination-active-border-color: var(--sp-vermelho-manto);
}
</style>
@endpush
