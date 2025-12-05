@extends('layout')

@section('title', $event->title . ' - Paróquia São Paulo Apóstolo')

@section('content')
<!-- Hero Section -->
<x-hero 
    title="{{ $event->title }}" 
    subtitle="Evento da Paróquia São Paulo Apóstolo" 
    titleSize="2.5rem" 
    subtitleSize="1.1rem" 
/>

<!-- Botão de Voltar (Mobile) -->
<x-back-button />

<!-- Breadcrumbs -->
<div class="container mt-4">
    <x-breadcrumbs :items="[
        ['label' => 'Eventos', 'url' => route('events'), 'icon' => 'calendar-event'],
        ['label' => $event->title]
    ]" />
</div>

<!-- Conteúdo do Evento -->
<section class="section-paroquia">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <article class="card-paroquia">
                    @if($event->image)
                        <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="card-img-top" style="max-height: 400px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body">
                        <!-- Metadados -->
                        <div class="d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom">
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-calendar3 me-2"></i>
                                <span>{{ $event->start_date->format('d/m/Y') }}</span>
                            </div>
                            
                            @if($event->start_date)
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-clock me-2"></i>
                                    <span>{{ $event->start_date->format('H:i') }}</span>
                                </div>
                            @endif
                            
                            @if($event->location)
                                <div class="d-flex align-items-center text-muted">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                            
                            @if($event->category)
                                <div class="ms-auto">
                                    <span class="badge bg-secondary">
                                        @switch($event->category)
                                            @case('liturgy') Liturgia @break
                                            @case('formation') Formação @break
                                            @case('social') Social @break
                                            @case('youth') Juventude @break
                                            @case('family') Família @break
                                            @default {{ ucfirst($event->category) }}
                                        @endswitch
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Descrição -->
                        <div class="event-description">
                            {!! nl2br(e($event->description)) !!}
                        </div>

                        <!-- Informações Adicionais -->
                        @if($event->end_date || $event->max_participants || $event->requirements)
                            <div class="mt-4 pt-3 border-top">
                                <h5 class="text-vermelho mb-3">Informações Adicionais</h5>
                                
                                @if($event->end_date)
                                    <p class="mb-2">
                                        <strong>Término:</strong> {{ $event->end_date->format('d/m/Y H:i') }}
                                    </p>
                                @endif
                                
                                @if($event->max_participants)
                                    <p class="mb-2">
                                        <strong>Vagas:</strong> Limitado a {{ $event->max_participants }} participantes
                                    </p>
                                @endif
                                
                                @if($event->requirements)
                                    <p class="mb-2">
                                        <strong>Requisitos:</strong> {{ $event->requirements }}
                                    </p>
                                @endif

                                @if($event->status)
                                    <p class="mb-0">
                                        <strong>Status:</strong> 
                                        @switch($event->status)
                                            @case('scheduled')
                                                <span class="badge bg-info">Agendado</span>
                                                @break
                                            @case('confirmed')
                                                <span class="badge bg-success">Confirmado</span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge bg-danger">Cancelado</span>
                                                @break
                                        @endswitch
                                    </p>
                                @endif
                            </div>
                        @endif

                        <!-- Botão Voltar -->
                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('events') }}" class="btn btn-outline-success">
                                <i class="bi bi-arrow-left me-2"></i>Voltar para Eventos
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
