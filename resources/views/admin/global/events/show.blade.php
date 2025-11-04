@extends('admin.layout')

@section('title', $event->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-1">{{ $event->title }}</h1>
            <div class="text-muted small d-flex align-items-center gap-2 flex-wrap">
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
                        @default bg-warning text-dark
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
            <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-success">Editar</a>
            <a href="{{ route('admin.global.events.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                @if($event->image)
                    <img src="{{ Storage::url($event->image) }}" alt="{{ $event->title }}" class="card-img-top object-fit-cover" style="max-height: 340px;">
                @endif
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="mb-2">Descrição</h6>
                        <div class="mb-0">{!! nl2br(e($event->description)) !!}</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <h6 class="mb-2">📅 Data e Horário</h6>
                            <div class="small text-muted">
                                <div><span class="fw-semibold">Início:</span> {{ $event->start_date->format('d/m/Y H:i') }}</div>
                                @if($event->end_date)
                                    <div><span class="fw-semibold">Término:</span> {{ $event->end_date->format('d/m/Y H:i') }}</div>
                                @endif
                            </div>
                        </div>
                        @if($event->location)
                        <div class="col-md-6">
                            <h6 class="mb-2">📍 Local</h6>
                            <div class="text-muted">{{ $event->location }}</div>
                        </div>
                        @endif
                    </div>
                    @if($event->requirements)
                        <div>
                            <h6 class="mb-2">📋 Requisitos</h6>
                            <div class="text-muted">{!! nl2br(e($event->requirements)) !!}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Ações Rápidas</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-success">✏️ Editar Evento</a>
                        @if($event->status !== 'confirmed')
                            <form method="POST" action="{{ route('admin.global.events.update', $event) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <input type="hidden" name="title" value="{{ $event->title }}">
                                <input type="hidden" name="description" value="{{ $event->description }}">
                                <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                                <button type="submit" class="btn btn-primary">✅ Confirmar Evento</button>
                            </form>
                        @endif
                        @if($event->status !== 'cancelled')
                            <form method="POST" action="{{ route('admin.global.events.update', $event) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <input type="hidden" name="title" value="{{ $event->title }}">
                                <input type="hidden" name="description" value="{{ $event->description }}">
                                <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja cancelar este evento?')">❌ Cancelar Evento</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.global.events.destroy', $event) }}" onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary">🗑️ Excluir Evento</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Informações do Evento</h6>
                    <div class="small text-muted">
                        <div class="mb-2"><span class="fw-semibold">Status:</span> <span class="badge 
                            @switch($event->status)
                                @case('confirmed') bg-success @break
                                @case('scheduled') bg-primary @break
                                @case('cancelled') bg-danger @break
                                @case('completed') bg-secondary @break
                                @default bg-warning text-dark
                            @endswitch">@switch($event->status)
                                @case('confirmed') Confirmado @break
                                @case('scheduled') Agendado @break
                                @case('cancelled') Cancelado @break
                                @case('completed') Concluído @break
                                @default {{ ucfirst($event->status) }}
                            @endswitch</span></div>
                        @if($event->category)
                            <div class="mb-2"><span class="fw-semibold">Categoria:</span> 
                                @switch($event->category)
                                    @case('liturgy') Liturgia @break
                                    @case('formation') Formação @break
                                    @case('social') Social @break
                                    @case('youth') Juventude @break
                                    @case('family') Família @break
                                    @default {{ ucfirst($event->category) }}
                                @endswitch
                            </div>
                        @endif
                        <div class="mb-2"><span class="fw-semibold">Criado por:</span> {{ $event->user->name }}</div>
                        <div class="mb-2"><span class="fw-semibold">Criado em:</span> {{ $event->created_at->format('d/m/Y H:i') }}</div>
                        @if($event->updated_at != $event->created_at)
                            <div class="mb-2"><span class="fw-semibold">Atualizado em:</span> {{ $event->updated_at->format('d/m/Y H:i') }}</div>
                        @endif
                        @if($event->max_participants)
                            <div class="mb-0"><span class="fw-semibold">Máx. Participantes:</span> {{ $event->max_participants }}</div>
                        @else
                            <div class="mb-0"><span class="fw-semibold">Participantes:</span> Sem limite</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Navegação</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.events.index') }}" class="btn btn-link text-start">← Todos os Eventos</a>
                        <a href="{{ route('admin.global.events.create') }}" class="btn btn-link text-start">+ Novo Evento</a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-link text-start">🏠 Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
