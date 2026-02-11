@extends('admin.layout')

@section('title', $event->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <div>
        <h2 class="h2 fw-bold text-dark">{{ $event->title }}</h2>
        <div class="d-flex align-items-center gap-3 mt-2 small text-secondary">
            <span>Por {{ $event->user->name }}</span>
            <span>•</span>
            <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
            <span>•</span>
            <span class="px-2 py-1 rounded small
                @switch($event->status)
                    @case('confirmed') bg-success-subtle text-success-emphasis @break
                    @case('scheduled') bg-info-subtle text-info-emphasis @break
                    @case('cancelled') bg-danger-subtle text-danger-emphasis @break
                    @case('completed') bg-secondary-subtle text-secondary-emphasis @break
                    @default bg-warning-subtle text-warning-emphasis
                @endswitch">
                @switch($event->status)
                    @case('confirmed') Confirmado @break
                    @case('scheduled') Agendado @break
                    @case('cancelled') Cancelado @break
                    @case('completed') Concluído @break
                    @default {{ ucfirst($event->status) }}
                @endswitch
            </span>
        </div>
    </div>
    
    <div class="d-flex gap-3">
        <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
           class="btn btn-success px-4 py-2">
            Editar
        </a>
        <a href="{{ route('admin.administrativo.events.index') }}" 
           class="btn btn-outline-secondary px-4 py-2">
            Voltar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-success-subtle border border-success text-success-emphasis px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-lg-8">
        <div class="bg-white rounded shadow">
            <!-- Event Image -->
            @if($event->image)
                <div class="mb-6">
                    <img src="{{ Storage::url($event->image) }}" 
                         alt="{{ $event->title }}" 
                         class="w-100 rounded-top" style="height: 16rem; object-fit: cover;">
                </div>
            @endif
            
            <div class="p-6">
                <!-- Event Description -->
                <div class="prose mb-6">
                    <h3 class="h5 fw-semibold text-dark mb-3">Descrição</h3>
                    <div class="text-dark">{!! nl2br(e($event->description)) !!}</div>
                </div>

                <!-- Event Details -->
                <div class="row g-4 mb-6">
                    <div class="col-md-6">
                        <h4 class="fw-semibold text-dark mb-2">📅 Data e Horário</h4>
                        <div class="text-dark">
                            <p><strong>Início:</strong> {{ $event->start_date->format('d/m/Y H:i') }}</p>
                            @if($event->end_date)
                                <p><strong>Término:</strong> {{ $event->end_date->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($event->location)
                        <div class="col-md-6">
                            <h4 class="fw-semibold text-dark mb-2">📍 Local</h4>
                            <p class="text-dark">{{ $event->location }}</p>
                        </div>
                    @endif
                </div>

                @if($event->requirements)
                    <div class="mb-6">
                        <h4 class="fw-semibold text-dark mb-2">📋 Requisitos</h4>
                        <div class="text-dark">{!! nl2br(e($event->requirements)) !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4 d-flex flex-column gap-4">
        <!-- Quick Actions -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="fw-semibold text-dark mb-4">Ações Rápidas</h3>
            <div class="d-flex flex-column gap-3">
                <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
                   class="btn btn-success w-100 text-center py-2">
                    ✏️ Editar Evento
                </a>
                
                @if($event->status !== 'confirmed')
                    <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}" class="d-block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="confirmed">
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                        <button type="submit" 
                                class="btn btn-primary w-100 py-2">
                            ✅ Confirmar Evento
                        </button>
                    </form>
                @endif

                @if($event->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}" class="d-block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                        <button type="submit" 
                                class="btn btn-danger w-100 py-2"
                                onclick="return confirm('Tem certeza que deseja cancelar este evento?')">
                            ❌ Cancelar Evento
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="btn btn-secondary w-100 py-2">
                        🗑️ Excluir Evento
                    </button>
                </form>
            </div>
        </div>

        <!-- Event Information -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="fw-semibold text-dark mb-4">Informações do Evento</h3>
            <div class="d-flex flex-column gap-3 small">
                <div>
                    <span class="fw-medium text-dark">Status:</span>
                    <span class="ms-2 px-2 py-1 rounded small
                        @switch($event->status)
                            @case('confirmed') bg-success-subtle text-success-emphasis @break
                            @case('scheduled') bg-info-subtle text-info-emphasis @break
                            @case('cancelled') bg-danger-subtle text-danger-emphasis @break
                            @case('completed') bg-secondary-subtle text-secondary-emphasis @break
                            @default bg-warning-subtle text-warning-emphasis
                        @endswitch">
                        @switch($event->status)
                            @case('confirmed') Confirmado @break
                            @case('scheduled') Agendado @break
                            @case('cancelled') Cancelado @break
                            @case('completed') Concluído @break
                            @default {{ ucfirst($event->status) }}
                        @endswitch
                    </span>
                </div>
                
                @if($event->category)
                    <div>
                        <span class="fw-medium text-dark">Categoria:</span>
                        <span class="ms-2 text-secondary">
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
                
                <div>
                    <span class="fw-medium text-dark">Criado por:</span>
                    <span class="ms-2 text-secondary">{{ $event->user->name }}</span>
                </div>
                
                <div>
                    <span class="fw-medium text-dark">Criado em:</span>
                    <span class="ms-2 text-secondary">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                @if($event->updated_at != $event->created_at)
                    <div>
                        <span class="fw-medium text-dark">Atualizado em:</span>
                        <span class="ms-2 text-secondary">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
                
                @if($event->max_participants)
                    <div>
                        <span class="fw-medium text-dark">Máx. Participantes:</span>
                        <span class="ms-2 text-secondary">{{ $event->max_participants }}</span>
                    </div>
                @else
                    <div>
                        <span class="fw-medium text-dark">Participantes:</span>
                        <span class="ms-2 text-secondary">Sem limite</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Navigation -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="fw-semibold text-dark mb-4">Navegação</h3>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('admin.administrativo.events.index') }}" 
                   class="d-block text-primary hover-text-primary-dark small">
                    ← Todos os Eventos
                </a>
                <a href="{{ route('admin.administrativo.events.create') }}" 
                   class="d-block text-success hover-text-success-dark small">
                    + Novo Evento
                </a>
                <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" 
                   class="d-block text-secondary hover-text-dark small">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
