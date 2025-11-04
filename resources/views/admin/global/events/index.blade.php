@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Gerenciar Eventos</h1>
        <a href="{{ route('admin.global.events.create') }}" class="btn btn-success">Novo Evento</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_filter" class="form-label">Período</label>
                        <select name="date_filter" id="date_filter" class="form-select">
                            <option value="">Todos</option>
                            <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                            <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Passados</option>
                            <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>Este Mês</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Título ou descrição..." class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                    </div>
                </div>
            </form>

            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Evento</th>
                                <th>Data/Hora</th>
                                <th>Local</th>
                                <th>Status</th>
                                <th>Participantes</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    <div class="text-muted small">{{ Str::limit($event->description, 60) }}</div>
                                </td>
                                <td>
                                    <div class="small">{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-muted small">{{ $event->start_date->format('H:i') }}</div>
                                </td>
                                <td>{{ $event->location ?: '-' }}</td>
                                <td>
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
                                </td>
                                <td>
                                    @if($event->max_participants)
                                        <span class="small">Máx: {{ $event->max_participants }}</span>
                                    @else
                                        <span class="text-muted small">Sem limite</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.global.events.show', $event) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                        <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-sm btn-outline-success">Editar</a>
                                        <form method="POST" action="{{ route('admin.global.events.destroy', $event) }}" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $events->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="display-6 text-muted mb-2">📅</div>
                    <h2 class="h6">Nenhum evento encontrado</h2>
                    <p class="text-muted">Comece criando seu primeiro evento.</p>
                    <a href="{{ route('admin.global.events.create') }}" class="btn btn-success">Criar Primeiro Evento</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
