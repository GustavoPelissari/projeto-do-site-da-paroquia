@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <h2 class="h2 fw-bold text-dark">Gerenciar Eventos</h2>
    <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-success px-4 py-2">
        Novo Evento
    </a>
</div>

@if(session('success'))
    <div class="bg-success-subtle border border-success text-success-emphasis px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow">
    <div class="p-6">
        <!-- Filters -->
        <form method="GET" class="mb-6">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="d-block small fw-medium text-dark mb-1">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="date_filter" class="d-block small fw-medium text-dark mb-1">Período</label>
                    <select name="date_filter" id="date_filter" class="form-select">
                        <option value="">Todos</option>
                        <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                        <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Passados</option>
                        <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>Este Mês</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="d-block small fw-medium text-dark mb-1">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Título ou descrição..." 
                           class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
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
                    <thead>
                        <tr class="border-bottom bg-secondary-subtle">
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Evento</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Data/Hora</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Local</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Status</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Participantes</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="border-bottom">
                            <td class="py-3 px-4">
                                <div>
                                    <h4 class="fw-medium text-dark">{{ $event->title }}</h4>
                                    <p class="small text-secondary">{{ Str::limit($event->description, 60) }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-dark">
                                <div class="small">
                                    <div>{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-secondary">{{ $event->start_date->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-dark">{{ $event->location ?: '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 small rounded 
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
                            </td>
                            <td class="py-3 px-4 text-dark">
                                @if($event->max_participants)
                                    <span class="small">Máx: {{ $event->max_participants }}</span>
                                @else
                                    <span class="text-secondary">Sem limite</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.administrativo.events.show', $event) }}" 
                                       class="text-primary hover-text-primary-dark small">Ver</a>
                                    <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
                                       class="text-success hover-text-success-dark small">Editar</a>
                                    <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                                          class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger hover-text-danger-dark small p-0">
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
            <div class="mt-6">
                {{ $events->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-secondary" style="font-size: 4rem;"></div>
                <h3 class="h5 fw-medium text-dark mb-2">Nenhum evento encontrado</h3>
                <p class="text-secondary mb-4">Comece criando seu primeiro evento.</p>
                <a href="{{ route('admin.administrativo.events.create') }}" 
                   class="btn btn-success px-4 py-2">
                    Criar Primeiro Evento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
