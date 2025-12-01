@extends('admin.layout')

@section('title', 'Gerenciar Grupos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Gerenciar Grupos</h1>
        <a href="{{ route('admin.global.groups.create') }}" class="btn btn-primary">Novo Grupo</a>
    </div>

    @if(session('success'))
        <x-alert type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nome ou descrição..." class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                    </div>
                </div>
            </form>

            @if($groups->count() > 0)
                <div class="row g-3">
                    @foreach($groups as $group)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            @if($group->image)
                                <img src="{{ Storage::url($group->image) }}" alt="{{ $group->name }}" class="card-img-top object-fit-cover" style="height: 200px;">
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                    <div class="display-6 text-muted">👥</div>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0">{{ $group->name }}</h6>
                                    <span class="badge {{ $group->is_active ? 'bg-success' : 'bg-danger' }}">{{ $group->is_active ? 'Ativo' : 'Inativo' }}</span>
                                </div>
                                <div class="text-muted small mb-2">{{ Str::limit($group->description, 80) }}</div>
                                <div class="d-flex justify-content-between align-items-center text-muted small mb-3">
                                    <span class="badge bg-light text-dark">{{ $group->category_name }}</span>
                                    @if($group->coordinator_name)
                                        <span>Coord: {{ $group->coordinator_name }}</span>
                                    @endif
                                </div>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.global.groups.show', $group) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                        <a href="{{ route('admin.global.groups.edit', $group) }}" class="btn btn-sm btn-outline-success">Editar</a>
                                    </div>
                                    <form method="POST" action="{{ route('admin.global.groups.destroy', $group) }}" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    {{ $groups->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="display-6 text-muted mb-2">👥</div>
                    <h2 class="h6">Nenhum grupo encontrado</h2>
                    <p class="text-muted">Comece criando seu primeiro grupo.</p>
                    <a href="{{ route('admin.global.groups.create') }}" class="btn btn-primary">Criar Primeiro Grupo</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
