@extends('admin.layout')

@section('title', 'Gerenciar notícias')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Área administrativa</p>
        <h2 class="h3 mb-0">Notícias</h2>
    </div>
    <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Nova notícia
    </a>
</div>

<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">Todos</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Arquivado</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label" for="scope">Escopo</label>
            <select id="scope" name="scope" class="form-select">
                <option value="">Todos</option>
                <option value="parish" {{ request('scope') === 'parish' ? 'selected' : '' }}>Paróquia</option>
                <option value="group" {{ request('scope') === 'group' ? 'selected' : '' }}>Grupo</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label" for="search">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Título ou conteúdo">
        </div>
        <div class="col-12 col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-primary">Filtrar</button>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Lista de notícias</h3>
        <small class="text-secondary">{{ $news->total() }} registro(s)</small>
    </div>
    <div class="card-body p-0">
        @if($news->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Notícia</th>
                        <th>Escopo</th>
                        <th>Status</th>
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
                        <td>{{ $item->scope === 'group' ? 'Grupo' : 'Paróquia' }}</td>
                        <td><span class="badge {{ $item->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                        <td>{{ $item->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.administrativo.news.show', $item) }}" class="btn btn-outline-secondary">Ver</a>
                                <a href="{{ route('admin.administrativo.news.edit', $item) }}" class="btn btn-outline-primary">Editar</a>
                                <form method="POST" action="{{ route('admin.administrativo.news.destroy', $item) }}" onsubmit="return confirm('Deseja excluir esta notícia?')">
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
            <div class="p-4 text-center text-secondary">Nenhuma notícia encontrada.</div>
        @endif
    </div>
</div>

@if($news->hasPages())
    <div class="mt-4">{{ $news->withQueryString()->links() }}</div>
@endif
@endsection
