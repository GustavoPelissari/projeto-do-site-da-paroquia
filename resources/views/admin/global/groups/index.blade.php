@extends('admin.layout')

@section('title', 'Gerenciar Grupos')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Gestão pastoral</p>
        <h2 class="h3 mb-0">Gerenciar grupos e pastorais</h2>
    </div>
    <a href="{{ route('admin.global.groups.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Novo grupo
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
                <label for="category" class="form-label">Categoria</label>
                <select name="category" id="category" class="form-select">
                    <option value="">Todas</option>
                    <option value="liturgy" {{ request('category') === 'liturgy' ? 'selected' : '' }}>Liturgia</option>
                    <option value="pastoral" {{ request('category') === 'pastoral' ? 'selected' : '' }}>Pastoral</option>
                    <option value="service" {{ request('category') === 'service' ? 'selected' : '' }}>Serviço</option>
                    <option value="formation" {{ request('category') === 'formation' ? 'selected' : '' }}>Formação</option>
                    <option value="youth" {{ request('category') === 'youth' ? 'selected' : '' }}>Juventude</option>
                    <option value="family" {{ request('category') === 'family' ? 'selected' : '' }}>Família</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nome ou descrição..." class="form-control">
            </div>
            <div class="col-12 col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-primary">Filtrar</button>
            </div>
        </form>
    </div>
</div>

@if($groups->count() > 0)
    <div class="row g-4">
        @foreach($groups as $group)
            <div class="col-12 col-md-6 col-xl-4">
                <article class="card h-100">
                    @if($group->image)
                        <img src="{{ Storage::url($group->image) }}" alt="{{ $group->name }}" class="card-img-top" style="height: 11rem; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h3 class="h5 mb-0">{{ $group->name }}</h3>
                            <span class="badge {{ $group->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                                {{ $group->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>

                        <p class="text-secondary mb-3">{{ Str::limit($group->description, 120) }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3 small text-secondary">
                            <span class="badge text-bg-light border">{{ $group->category_name }}</span>
                            <span>{{ $group->users_count }} membro{{ $group->users_count === 1 ? '' : 's' }}</span>
                        </div>

                        @if($group->coordinator_name)
                            <p class="small mb-3"><strong>Coordenador:</strong> {{ $group->coordinator_name }}</p>
                        @endif

                        <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações do grupo">
                                <a href="{{ route('admin.global.groups.show', $group) }}" class="btn btn-outline-secondary">Ver</a>
                                <a href="{{ route('admin.global.groups.edit', $group) }}" class="btn btn-outline-primary">Editar</a>
                            </div>
                            <form method="POST" action="{{ route('admin.global.groups.destroy', $group) }}" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </div>
                    </div>
                </article>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $groups->withQueryString()->links() }}
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <h3 class="h5">Nenhum grupo encontrado</h3>
            <p class="text-secondary mb-3">Ajuste os filtros ou crie um novo grupo para começar.</p>
            <a href="{{ route('admin.global.groups.create') }}" class="btn btn-primary">Criar primeiro grupo</a>
        </div>
    </div>
@endif
@endsection
