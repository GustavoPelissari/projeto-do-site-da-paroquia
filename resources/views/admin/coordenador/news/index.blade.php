@extends('admin.layout')

@section('title', 'Notícias do Grupo')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Coordenação pastoral</p>
        <h2 class="h3 mb-0">Notícias do grupo</h2>
    </div>
    <span class="badge text-bg-light border">Criação disponível em breve</span>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Lista de notícias</h3>
        <small class="text-secondary">{{ $news->total() }} registro{{ $news->total() === 1 ? '' : 's' }}</small>
    </div>
    <div class="card-body p-0">
        @if($news->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Status</th>
                            <th>Publicação</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <small class="text-secondary">{{ Str::limit($item->excerpt ?: strip_tags($item->content), 100) }}</small>
                                </td>
                                <td><span class="badge {{ $item->status === 'published' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $item->status === 'published' ? 'Publicado' : 'Rascunho' }}</span></td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.coordenador.news.destroy', $item) }}" onsubmit="return confirm('Deseja excluir esta notícia?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhuma notícia cadastrada para seu grupo.</div>
        @endif
    </div>
</div>

@if($news->hasPages())
    <div class="mt-4">{{ $news->links() }}</div>
@endif
@endsection
