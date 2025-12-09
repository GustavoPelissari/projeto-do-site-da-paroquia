@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold mb-0">Gerenciar Eventos</h2>
        <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Novo Evento
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="status" class="form-label small fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_filter" class="form-label small fw-semibold">Período</label>
                        <select name="date_filter" id="date_filter" class="form-select">
                            <option value="">Todos</option>
                            <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                            <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Passados</option>
                            <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>Este Mês</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label small fw-semibold">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Título ou descrição..." 
                               class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Events Table -->
            @if($events->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Evento</th>
                                <th class="fw-semibold">Data/Hora</th>
                                <th class="fw-semibold">Local</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold">Participantes</th>
                                <th class="fw-semibold text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>
                                    <div>
                                        <h6 class="fw-medium mb-1">{{ $event->title }}</h6>
                                        <p class="text-muted small mb-0">{{ Str::limit($event->description, 60) }}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div class="fw-medium">{{ $event->start_date->format('d/m/Y') }}</div>
                                        <div class="text-muted">{{ $event->start_date->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>{{ $event->location ?: '-' }}</td>
                                <td>
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
                                <td>
                                    @if($event->max_participants)
                                        <span class="small">Máx: {{ $event->max_participants }}</span>
                                    @else
                                        <span class="text-muted">Sem limite</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.administrativo.events.show', $event) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
                                           class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                                              class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash me-1"></i>Excluir
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
                @if($events->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $events->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3" style="font-size: 4rem; opacity: 0.3;">📅</div>
                    <h4 class="fw-bold mb-2">Nenhum evento encontrado</h4>
                    <p class="text-muted mb-4">Comece criando seu primeiro evento.</p>
                    <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Criar Primeiro Evento
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
