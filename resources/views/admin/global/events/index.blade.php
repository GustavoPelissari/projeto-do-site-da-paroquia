@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold text-dark">Gerenciar Eventos</h2>
    <a href="{{ route('admin.global.events.create') }}" class="btn btn-success px-4 py-2">
        Novo Evento
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow">
    <div class="card-body">
        <!-- Filters -->
        <form method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-12 col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label for="date_filter" class="form-label">Período</label>
                    <select name="date_filter" id="date_filter" class="form-select">
                        <option value="">Todos</option>
                        <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                        <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Passados</option>
                        <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>Este Mês</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Título ou descrição..." 
                           class="form-control">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Events Table -->
        @if($events->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start">Evento</th>
                            <th class="text-start">Data/Hora</th>
                            <th class="text-start">Local</th>
                            <th class="text-start">Status</th>
                            <th class="text-start">Participantes</th>
                            <th class="text-start">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="hover-bg-gray-50">
                            <td class="py-3">
                                <div>
                                    <h4 class="fw-medium mb-1">{{ $event->title }}</h4>
                                    <p class="text-muted small mb-0">{{ Str::limit($event->description, 60) }}</p>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="small">
                                    <div>{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-muted">{{ $event->start_date->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="py-3">{{ $event->location ?: '-' }}</td>
                            <td class="py-3">
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
                            </td>
                            <td class="py-3">
                                @if($event->max_participants)
                                    <span class="small">Máx: {{ $event->max_participants }}</span>
                                @else
                                    <span class="text-muted">Sem limite</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.global.events.show', $event) }}" 
                                       class="text-primary hover-text-primary-dark small">Ver</a>
                                    <a href="{{ route('admin.global.events.edit', $event) }}" 
                                       class="text-success hover-text-success-dark small">Editar</a>
                                    <form method="POST" action="{{ route('admin.global.events.destroy', $event) }}" 
                                          class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger hover-text-danger-dark p-0 small">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $events->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"></div>
                <h3 class="h4 fw-medium mb-2">Nenhum evento encontrado</h3>
                <p class="text-muted mb-3">Comece criando seu primeiro evento.</p>
                <a href="{{ route('admin.global.events.create') }}" 
                   class="btn btn-success">
                    Criar Primeiro Evento
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.hover-bg-gray-50:hover {
    background-color: #f8f9fa;
}
.hover-text-primary-dark:hover {
    color: #0056b3 !important;
}
.hover-text-success-dark:hover {
    color: #198754 !important;
}
.hover-text-danger-dark:hover {
    color: #bb2d3b !important;
}
</style>
@endsection
