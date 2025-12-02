@extends('admin.layout')

@section('title', $event->title)

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="h3 fw-bold mb-2">{{ $event->title }}</h2>
            <div class="d-flex align-items-center gap-3 flex-wrap small text-muted">
                <span>Por {{ $event->user->name }}</span>
                <span>•</span>
                <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
                <span>•</span>
                <span class="badge 
                    @switch($event->status)
                        @case('confirmed') bg-success @break
                        @case('scheduled') bg-primary @break
                        @case('cancelled') bg-danger @break
                        @case('completed') bg-secondary @break
                        @default bg-warning
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
        
        <div class="d-flex gap-2">
            <a href="{{ route('admin.administrativo.events.edit', $event) }}" class="btn btn-success">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('admin.administrativo.events.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <!-- Event Image -->
                @if($event->image)
                    <img src="{{ Storage::url($event->image) }}" 
                         alt="{{ $event->title }}" 
                         class="card-img-top" style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <!-- Event Description -->
                    <div class="mb-4">
                        <h5 class="fw-semibold mb-3">Descrição</h5>
                        <div>{!! nl2br(e($event->description)) !!}</div>
                    </div>

                    <!-- Event Details -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-semibold mb-2">📅 Data e Horário</h6>
                            <div>
                                <p class="mb-1"><strong>Início:</strong> {{ $event->start_date->format('d/m/Y H:i') }}</p>
                                @if($event->end_date)
                                    <p class="mb-0"><strong>Término:</strong> {{ $event->end_date->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>

                        @if($event->location)
                            <div class="col-md-6">
                                <h6 class="fw-semibold mb-2">📍 Local</h6>
                                <p class="mb-0">{{ $event->location }}</p>
                            </div>
                        @endif
                    </div>

                    @if($event->requirements)
                        <div class="mb-0">
                            <h6 class="fw-semibold mb-2">📋 Requisitos</h6>
                            <div>{!! nl2br(e($event->requirements)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Ações Rápidas</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.administrativo.events.edit', $event) }}" class="btn btn-success">
                            <i class="bi bi-pencil me-1"></i> Editar Evento
                        </a>
                        
                        @if($event->status !== 'confirmed')
                            <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <input type="hidden" name="title" value="{{ $event->title }}">
                                <input type="hidden" name="description" value="{{ $event->description }}">
                                <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-check-circle me-1"></i> Confirmar Evento
                                </button>
                            </form>
                        @endif

                        @if($event->status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="title" value="{{ $event->title }}">
                                <input type="hidden" name="description" value="{{ $event->description }}">
                                <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Tem certeza que deseja cancelar este evento?')">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar Evento
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                              onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="bi bi-trash me-1"></i> Excluir Evento
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Event Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Informações do Evento</h5>
                    <div class="small">
                        <div class="mb-3">
                            <span class="fw-semibold">Status:</span>
                            <span class="badge ms-2
                                @switch($event->status)
                                    @case('confirmed') bg-success @break
                                    @case('scheduled') bg-primary @break
                                    @case('cancelled') bg-danger @break
                                    @case('completed') bg-secondary @break
                                    @default bg-warning
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
                            <div class="mb-3">
                                <span class="fw-semibold">Categoria:</span>
                                <span class="ms-2 text-muted">
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
                        
                        <div class="mb-3">
                            <span class="fw-semibold">Criado por:</span>
                            <span class="ms-2 text-muted">{{ $event->user->name }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="fw-semibold">Criado em:</span>
                            <span class="ms-2 text-muted">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        @if($event->updated_at != $event->created_at)
                            <div class="mb-3">
                                <span class="fw-semibold">Atualizado em:</span>
                                <span class="ms-2 text-muted">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        
                        @if($event->max_participants)
                            <div class="mb-0">
                                <span class="fw-semibold">Máx. Participantes:</span>
                                <span class="ms-2 text-muted">{{ $event->max_participants }}</span>
                            </div>
                        @else
                            <div class="mb-0">
                                <span class="fw-semibold">Participantes:</span>
                                <span class="ms-2 text-muted">Sem limite</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Navegação</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.administrativo.events.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Todos os Eventos
                        </a>
                        <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Novo Evento
                        </a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-house me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
