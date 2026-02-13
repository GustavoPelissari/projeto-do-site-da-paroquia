@extends('admin.layout')

@section('title', 'Gerenciar Notícias')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Conteúdo pastoral</p>
        <h2 class="h3 mb-0">Gerenciar notícias</h2>
    </div>
    <a href="{{ route('admin.global.news.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova notícia
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Todos</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                </select>
            </div>
            <div class="col-12 col-md-3">
                <label for="featured" class="form-label">Destaque</label>
                <select name="featured" id="featured" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Em destaque</option>
                    <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Sem destaque</option>
                </select>
            </div>
            <div class="col-12 col-md-4">
                <label for="search" class="form-label">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Título, conteúdo ou autor">
            </div>
            <div class="col-12 col-md-2 d-grid">
                <button type="submit" class="btn btn-outline-primary">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Lista de notícias</h3>
        <small class="text-secondary">{{ $news->total() }} registro{{ $news->total() === 1 ? '' : 's' }}</small>
    </div>
    <div class="card-body p-0">
        @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Notícia</th>
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
                                    <small class="text-secondary">{{ Str::limit(strip_tags($item->content), 90) }}</small>
                                </td>
                                <td>{{ $item->user->name ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $item->status === 'published' ? 'Publicado' : 'Rascunho' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $item->featured ? 'text-bg-warning' : 'text-bg-light border' }}">
                                        {{ $item->featured ? 'Destaque' : 'Normal' }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <div class="admin-table-actions justify-content-end">
                                        <a href="{{ route('admin.global.news.show', $item) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                        <a href="{{ route('admin.global.news.edit', $item) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <form method="POST" action="{{ route('admin.global.news.destroy', $item) }}" class="d-inline" onsubmit="return confirm('Deseja excluir esta notícia?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center">
                <h4 class="h6">Nenhuma notícia encontrada</h4>
                <p class="text-secondary mb-3">Crie a primeira notícia para começar.</p>
                <a href="{{ route('admin.global.news.create') }}" class="btn btn-primary">Nova notícia</a>
            </div>
        @endif
    </div>
</div>

@if($news->hasPages())
    <div class="mt-4">{{ $news->withQueryString()->links() }}</div>
@endif
@endsection
