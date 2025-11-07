@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
        <div>
            <h1 class="h3 text-brand-vinho mb-1">Gerenciar Eventos</h1>
            <p class="text-muted mb-0">Administre os eventos e atividades da paróquia</p>
        </div>
        <a href="{{ route('admin.global.events.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Evento
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <strong>Filtros</strong>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-sm-4 col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-3">
                    <label for="category" class="form-label">Categoria</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Todas</option>
                        <option value="liturgy" {{ request('category') === 'liturgy' ? 'selected' : '' }}>Liturgia</option>
                        <option value="formation" {{ request('category') === 'formation' ? 'selected' : '' }}>Formação</option>
                        <option value="social" {{ request('category') === 'social' ? 'selected' : '' }}>Social</option>
                        <option value="youth" {{ request('category') === 'youth' ? 'selected' : '' }}>Juventude</option>
                        <option value="family" {{ request('category') === 'family' ? 'selected' : '' }}>Família</option>
                        <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>Outros</option>
                    </select>
                </div>
                <div class="col-sm-8 col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Título, descrição ou local...">
                </div>
                <div class="col-sm-4 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-search"></i> Filtrar</button>
                    @if(request()->hasAny(['status','category','search']))
                        <a href="{{ route('admin.global.events.index') }}" class="btn btn-light w-100">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($events->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Lista de Eventos</strong>
                <small class="text-muted">{{ $events->total() }} registro(s)</small>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Data/Hora</th>
                            <th>Local</th>
                            <th>Status</th>
                            <th>Categoria</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $event->title }}</div>
                                <div class="text-muted small">{{ Str::limit($event->description, 80) }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $event->start_date->format('d/m/Y') }}</div>
                                <div class="text-muted small">{{ $event->start_date->format('H:i') }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $event->location ?: '-' }}</div>
                            </td>
                            <td>
                                @if($event->status === 'confirmed')
                                    <span class="badge bg-success">Confirmado</span>
                                @elseif($event->status === 'scheduled')
                                    <span class="badge bg-info">Agendado</span>
                                @else
                                    <span class="badge bg-danger">Cancelado</span>
                                @endif
                            </td>
                            <td>
                                @if($event->category === 'liturgy')
                                    <span class="badge bg-secondary">Liturgia</span>
                                @elseif($event->category === 'formation')
                                    <span class="badge bg-secondary">Formação</span>
                                @elseif($event->category === 'social')
                                    <span class="badge bg-secondary">Social</span>
                                @elseif($event->category === 'youth')
                                    <span class="badge bg-secondary">Juventude</span>
                                @elseif($event->category === 'family')
                                    <span class="badge bg-secondary">Família</span>
                                @else
                                    <span class="badge bg-secondary">Outros</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.global.events.show', $event) }}" class="btn btn-outline-secondary btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.global.events.edit', $event) }}" class="btn btn-secondary btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.global.events.destroy', $event) }}" onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Excluir"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($events->hasPages())
                <div class="card-footer bg-white d-flex justify-content-center">
                    {{ $events->withQueryString()->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="display-6 mb-3">�</div>
                <h5 class="mb-2">Nenhum evento encontrado</h5>
                @if(request()->hasAny(['status','category','search']))
                    <p class="text-muted">Não encontramos eventos com os filtros aplicados.</p>
                    <a href="{{ route('admin.global.events.index') }}" class="btn btn-light">Limpar Filtros</a>
                @else
                    <p class="text-muted">Comece criando seu primeiro evento para a comunidade.</p>
                    <a href="{{ route('admin.global.events.create') }}" class="btn btn-primary">Criar Evento</a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
