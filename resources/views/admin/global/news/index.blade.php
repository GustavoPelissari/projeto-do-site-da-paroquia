@extends('admin.layout')

@section('title', 'Gerenciar Notícias')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
        <div>
            <h1 class="h3 text-brand-vinho mb-1">Gerenciar Notícias</h1>
            <p class="text-muted mb-0">Administre as notícias e comunicados da paróquia</p>
        </div>
        <a href="{{ route('admin.global.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nova Notícia
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
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicados</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Rascunhos</option>
                    </select>
                </div>
                <div class="col-sm-4 col-md-3">
                    <label for="featured" class="form-label">Destaque</label>
                    <select name="featured" id="featured" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Em destaque</option>
                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Não destacados</option>
                    </select>
                </div>
                <div class="col-sm-8 col-md-4">
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Título, conteúdo ou autor...">
                </div>
                <div class="col-sm-4 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-secondary w-100"><i class="bi bi-search"></i> Filtrar</button>
                    @if(request()->hasAny(['status','featured','search']))
                        <a href="{{ route('admin.global.news.index') }}" class="btn btn-light w-100">Limpar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($news->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <strong>Lista de Notícias</strong>
                <small class="text-muted">{{ $news->total() }} registro(s)</small>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Status</th>
                            <th>Destaque</th>
                            <th>Data</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $item->title }}</div>
                                <div class="text-muted small">{{ Str::limit($item->summary ?: strip_tags($item->content), 80) }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $item->user->name }}</div>
                            </td>
                            <td>
                                @if($item->status === 'published')
                                    <span class="badge bg-success">Publicado</span>
                                @else
                                    <span class="badge bg-warning text-dark">Rascunho</span>
                                @endif
                            </td>
                            <td>
                                @if($item->featured)
                                    <span class="badge bg-warning text-dark">Destaque</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="small">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.global.news.show', $item) }}" class="btn btn-outline-secondary btn-sm" title="Ver"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('admin.global.news.edit', $item) }}" class="btn btn-secondary btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                    <form method="POST" action="{{ route('admin.global.news.destroy', $item) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.');">
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
            @if($news->hasPages())
                <div class="card-footer bg-white d-flex justify-content-center">
                    {{ $news->withQueryString()->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <div class="display-6 mb-3">📰</div>
                <h5 class="mb-2">Nenhuma notícia encontrada</h5>
                @if(request()->hasAny(['status','featured','search']))
                    <p class="text-muted">Não encontramos notícias com os filtros aplicados.</p>
                    <a href="{{ route('admin.global.news.index') }}" class="btn btn-light">Limpar Filtros</a>
                @else
                    <p class="text-muted">Comece criando sua primeira notícia para informar a comunidade.</p>
                    <a href="{{ route('admin.global.news.create') }}" class="btn btn-primary">Criar Notícia</a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
