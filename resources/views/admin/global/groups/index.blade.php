@extends('admin.layout')

@section('title', 'Gerenciar Grupos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold text-dark">Gerenciar Grupos</h2>
    <a href="{{ route('admin.global.groups.create') }}" class="btn btn-primary px-4 py-2">
        Novo Grupo
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
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nome ou descrição..." 
                           class="form-control">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Groups Grid -->
        @if($groups->count() > 0)
            <div class="row g-4">
                @foreach($groups as $group)
                <div class="card shadow-sm h-100">
                    @if($group->image)
                        <img src="{{ Storage::url($group->image) }}" 
                             alt="{{ $group->name }}" 
                             class="card-img-top" style="height: 12rem; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-secondary-subtle d-flex align-items-center justify-content-center" style="height: 12rem;">
                            <span class="text-muted display-4"></span>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h3 class="fw-semibold text-dark mb-0">{{ $group->name }}</h3>
                            <span class="badge {{ $group->is_active ? .bg-success-subtle text-success-emphasis. : .bg-danger-subtle text-danger-emphasis. }}">
                                {{ $group->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        
                        <p class="text-secondary small mb-3">{{ Str::limit($group->description, 80) }}</p>
                        
                        <div class="d-flex align-items-center justify-content-between small text-secondary mb-3">
                            <span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $group->category_name }}</span>
                            @if($group->coordinator_name)
                                <span>Coord: {{ $group->coordinator_name }}</span>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.global.groups.show', $group) }}" 
                                   class="text-primary hover-text-primary-dark small">Ver</a>
                                <a href="{{ route('admin.global.groups.edit', $group) }}" 
                                   class="text-success hover-text-success-dark small">Editar</a>
                            </div>
                            
                            <form method="POST" action="{{ route('admin.global.groups.destroy', $group) }}" 
                                  class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger hover-text-danger-dark p-0 small">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $groups->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"></div>
                <h3 class="h4 fw-medium mb-2">Nenhum grupo encontrado</h3>
                <p class="text-muted mb-3">Comece criando seu primeiro grupo.</p>
                <a href="{{ route('admin.global.groups.create') }}" 
                   class="btn btn-primary px-4 py-2">
                    Criar Primeiro Grupo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
