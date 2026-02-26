@extends('admin.layout')

@section('title', 'Minhas Notícias - Coordenador')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 15px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h2 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-newspaper"></i> Minhas Notícias
                    </h1>
                    <p class="mb-0" style="color: #FFD66B;">Gerencie as notícias que você criou</p>
                </div>
                <a href="{{ route('admin.coordenador.news.create') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle"></i> Nova Notícia
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-search"></i> Buscar
                    </label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Título ou conteúdo..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-funnel"></i> Status
                    </label>
                    <select name="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Rascunho</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publicado</option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar"></i> Período
                    </label>
                    <select name="period" class="form-select">
                        <option value="">Todos</option>
                        <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Hoje</option>
                        <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>Esta Semana</option>
                        <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>Este Mês</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Notícias -->
    @forelse($news as $item)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Imagem -->
                    <div class="col-md-2">
                        @if($item->featured_image)
                            <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                 class="img-fluid rounded" 
                                 alt="{{ $item->title }}"
                                 style="max-height: 100px; object-fit: cover; width: 100%;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                 style="height: 100px;">
                                <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Conteúdo -->
                    <div class="col-md-7">
                        <h5 class="fw-bold mb-2">{{ $item->title }}</h5>
                        <p class="text-muted mb-2">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>
                        <div class="d-flex gap-3 align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i>
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-eye"></i>
                                {{ $item->views ?? 0 }} visualizações
                            </small>
                            @if($item->parish_group_id)
                                <span class="badge" style="background-color: #8B1538;">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ $item->parishGroup->name ?? 'Grupo' }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status e Ações -->
                    <div class="col-md-3 text-end">
                        @if($item->status === 'published')
                            <span class="badge bg-success mb-2 d-block">
                                <i class="bi bi-check-circle"></i> Publicado
                            </span>
                        @else
                            <span class="badge bg-warning mb-2 d-block">
                                <i class="bi bi-pencil"></i> Rascunho
                            </span>
                        @endif
                        
                        <div class="d-flex gap-2 align-items-center">
                            <a href="{{ route('admin.coordenador.news.edit', $item) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="Editar">
                                <i class="bi bi-pencil-square me-1"></i>Editar
                            </a>
                            <form action="{{ route('admin.coordenador.news.destroy', $item) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Tem certeza que deseja excluir esta notícia?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                    <i class="bi bi-trash me-1"></i>Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-newspaper" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h3 class="fw-bold text-muted mb-3">Nenhuma notícia encontrada</h3>
                <p class="text-muted mb-4">Você ainda não criou nenhuma notícia. Clique no botão abaixo para criar sua primeira notícia!</p>
                <a href="{{ route('admin.coordenador.news.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Criar Primeira Notícia
                </a>
            </div>
        </div>
    @endforelse

    <!-- Paginação -->
    @if($news->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $news->links() }}
        </div>
    @endif
</div>
@endsection