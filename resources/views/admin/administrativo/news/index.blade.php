@extends('admin.layout')

@section('title', 'Gerenciar Notícias')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h1 class="h2 fw-bold text-dark mb-2">📰 Gerenciar Notícias</h1>
                <p class="text-muted">
                    Gerencie as notícias e comunicados da paróquia
                </p>
            </div>
            <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-primary btn-lg">
                ➕ Nova Notícia
            </a>
        </div>

        {{-- Filters Section --}}
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">🔍 Filtros</h5>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">📊 Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Todos os status</option>
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                    ✅ Publicados
                                </option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                    📝 Rascunhos
                                </option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="featured" class="form-label">⭐ Destaque</label>
                            <select name="featured" id="featured" class="form-select">
                                <option value="">Todos</option>
                                <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>
                                    ⭐ Em destaque
                                </option>
                                <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>
                                    📄 Não destacados
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="search" class="form-label">🔎 Buscar</label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Título, conteúdo ou autor..." 
                                   class="form-control">
                        </div>

                        <div class="col-md-2 d-flex align-items-end gap-2">
                            <button type="submit" class="btn btn-secondary flex-grow-1">
                                🔍 Filtrar
                            </button>
                            @if(request()->hasAny(['status', 'featured', 'search']))
                                <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-secondary">
                                    🔄
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- News List --}}
        @if($news->count() > 0)
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">📋 Lista de Notícias</h5>
                    <span class="badge bg-secondary">
                        {{ $news->total() }} {{ Str::plural('notícia', $news->total()) }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold">📰 Notícia</th>
                                    <th class="fw-semibold">👤 Autor</th>
                                    <th class="fw-semibold">📊 Status</th>
                                    <th class="fw-semibold">⭐ Destaque</th>
                                    <th class="fw-semibold">📅 Data</th>
                                    <th class="fw-semibold">⚙️ Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news as $item)
                                    <tr>
                                        <td style="max-width: 300px;">
                                            <h6 class="fw-semibold mb-1">{{ $item->title }}</h6>
                                            <p class="text-muted small mb-1">{{ Str::limit($item->content, 80) }}</p>
                                            @if($item->featured_image)
                                                <span class="badge bg-info text-white">📷 Com imagem</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $item->user->name }}</span>
                                                <small class="text-muted text-capitalize">{{ $item->user->role->value ?? 'user' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $item->status === 'published' ? 'success' : 'warning' }}">
                                                @if($item->status === 'published')
                                                    ✅ Publicado
                                                @else
                                                    📝 Rascunho
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            @if($item->featured)
                                                <span class="badge bg-warning text-dark">⭐ Destaque</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ $item->created_at->format('d/m/Y') }}</span>
                                                <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <a href="{{ route('admin.administrativo.news.show', $item) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Visualizar">
                                                    👁️ Ver
                                                </a>
                                                <a href="{{ route('admin.administrativo.news.edit', $item) }}" 
                                                   class="btn btn-sm btn-outline-secondary"
                                                   title="Editar">
                                                    ✏️ Editar
                                                </a>
                                                <form method="POST" 
                                                      action="{{ route('admin.administrativo.news.destroy', $item) }}" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('⚠️ Tem certeza que deseja excluir esta notícia?\n\nEsta ação não pode ser desfeita.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger w-100"
                                                            title="Excluir">
                                                        🗑️ Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Pagination --}}
                @if($news->hasPages())
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-center">
                            {{ $news->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @else
            {{-- Empty State --}}
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="display-1 mb-3">📰</div>
                    <h3 class="mb-3">Nenhuma notícia encontrada</h3>
                    @if(request()->hasAny(['status', 'featured', 'search']))
                        <p class="text-muted mb-4">
                            Não encontramos notícias com os filtros aplicados. 
                            Tente ajustar os critérios de busca.
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-secondary btn-lg">
                                🔄 Limpar Filtros
                            </a>
                            <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-primary btn-lg">
                                ➕ Nova Notícia
                            </a>
                        </div>
                    @else
                        <p class="text-muted mb-4">
                            Comece criando sua primeira notícia para manter a comunidade informada sobre os acontecimentos da paróquia.
                        </p>
                        <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-primary btn-lg">
                            🚀 Criar Primeira Notícia
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
