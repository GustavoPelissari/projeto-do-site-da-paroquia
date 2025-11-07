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
                <span>{{ $event->created_at->format('d/m/Y H:i') }}</span>
                <span>•</span>
                @if($event->status === 'confirmed')
                    <span class="badge bg-success">Confirmado</span>
                @elseif($event->status === 'scheduled')
                    <span class="badge bg-info">Agendado</span>
                @else
                    <span class="badge bg-danger">Cancelado</span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-primary">Editar</a>
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
                    <div class="mb-0">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    @if($event->requirements)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-2">Requisitos/Observações</h6>
                            <p class="mb-0 text-muted">{{ $event->requirements }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Ações Rápidas</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-primary">✏️ Editar Evento</a>
                        <form method="POST" action="{{ route('admin.global.events.destroy', $event) }}" onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">🗑️ Excluir Evento</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Informações do Evento</h6>
                    <div class="small text-muted">
                        <div class="mb-2">
                            <span class="fw-semibold">Status:</span> 
                            @if($event->status === 'confirmed')
                                <span class="badge bg-success">Confirmado</span>
                            @elseif($event->status === 'scheduled')
                                <span class="badge bg-info">Agendado</span>
                            @else
                                <span class="badge bg-danger">Cancelado</span>
                            @endif
                        </div>
                        <div class="mb-2"><span class="fw-semibold">Responsável:</span> {{ $event->user->name }}</div>
                        <div class="mb-2"><span class="fw-semibold">Data/Hora Início:</span> {{ $event->start_date->format('d/m/Y H:i') }}</div>
                        @if($event->end_date)
                            <div class="mb-2"><span class="fw-semibold">Data/Hora Término:</span> {{ $event->end_date->format('d/m/Y H:i') }}</div>
                        @endif
                        @if($event->location)
                            <div class="mb-2"><span class="fw-semibold">Local:</span> {{ $event->location }}</div>
                        @endif
                        <div class="mb-2">
                            <span class="fw-semibold">Categoria:</span> 
                            @if($event->category === 'liturgy')
                                Liturgia
                            @elseif($event->category === 'formation')
                                Formação
                            @elseif($event->category === 'social')
                                Social
                            @elseif($event->category === 'youth')
                                Juventude
                            @elseif($event->category === 'family')
                                Família
                            @else
                                {{ ucfirst($event->category) }}
                            @endif
                        </div>
                        @if($event->max_participants)
                            <div class="mb-2"><span class="fw-semibold">Máx. Participantes:</span> {{ $event->max_participants }}</div>
                        @endif
                        <div class="mb-2"><span class="fw-semibold">Criado em:</span> {{ $event->created_at->format('d/m/Y H:i') }}</div>
                        @if($event->updated_at != $event->created_at)
                            <div class="mb-0"><span class="fw-semibold">Atualizado em:</span> {{ $event->updated_at->format('d/m/Y H:i') }}</div>
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
