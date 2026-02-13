@extends('admin.layout')

@section('title', 'Gerenciar eventos')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Área administrativa</p>
        <h2 class="h3 mb-0">Eventos</h2>
    </div>
    <a href="{{ route('admin.administrativo.events.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo evento
    </a>
</div>

<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">Todos</option>
                <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Em andamento</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label" for="category">Categoria</label>
            <select id="category" name="category" class="form-select">
                <option value="">Todas</option>
                <option value="parish" {{ request('category') === 'parish' ? 'selected' : '' }}>Paróquia</option>
                <option value="liturgy" {{ request('category') === 'liturgy' ? 'selected' : '' }}>Liturgia</option>
                <option value="group" {{ request('category') === 'group' ? 'selected' : '' }}>Grupo</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label" for="search">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Título, descrição ou local">
        </div>
        <div class="col-12 col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-primary">Filtrar</button>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Lista de eventos</h3>
        <small class="text-secondary">{{ $events->total() }} registro(s)</small>
    </div>
    <div class="card-body p-0">
        @if($events->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $event->title }}</div>
                            <small class="text-secondary">{{ $event->location ?: 'Local não informado' }}</small>
                        </td>
                        <td>{{ ucfirst($event->category ?? '—') }}</td>
                        <td>{{ $event->start_date?->format('d/m/Y H:i') }}</td>
                        <td><span class="badge text-bg-secondary">{{ ucfirst($event->status ?? 'scheduled') }}</span></td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.administrativo.events.show', $event) }}" class="btn btn-outline-secondary">Ver</a>
                                <a href="{{ route('admin.administrativo.events.edit', $event) }}" class="btn btn-outline-primary">Editar</a>
                                <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" onsubmit="return confirm('Deseja excluir este evento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhum evento encontrado.</div>
        @endif
    </div>
</div>

@if($events->hasPages())
    <div class="mt-4">{{ $events->withQueryString()->links() }}</div>
@endif
@endsection
