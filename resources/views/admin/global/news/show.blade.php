@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h4 mb-1">{{ $news->title }}</h1>
            <div class="text-muted small d-flex align-items-center gap-2 flex-wrap">
                <span>Por {{ $news->user->name }}</span>
                <span>•</span>
                <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
                <span>•</span>
                <span class="badge {{ $news->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                </span>
                @if($news->featured)
                    <span class="text-warning">⭐ Destaque</span>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.global.news.edit', $news) }}" class="btn btn-primary">Editar</a>
            <a href="{{ route('admin.global.news.index') }}" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                @if($news->featured_image)
                    <img src="{{ Storage::url($news->featured_image) }}" alt="{{ $news->title }}" class="card-img-top object-fit-cover" style="max-height: 340px;">
                @endif
                <div class="card-body">
                    @if($news->summary)
                        <div class="alert alert-primary" role="alert">
                            {{ $news->summary }}
                        </div>
                    @endif

                    <div class="mb-0">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    @if($news->meta_description)
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="mb-2">Meta Descrição (SEO)</h6>
                            <p class="mb-0 text-muted">{{ $news->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($news->status === 'draft')
                <div class="alert alert-warning mt-3" role="alert">
                    Esta notícia está em rascunho e não será exibida no site público até ser publicada.
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Ações Rápidas</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.news.edit', $news) }}" class="btn btn-primary">✏️ Editar Notícia</a>
                        @if($news->status === 'published')
                            <form method="POST" action="{{ route('admin.global.news.update', $news) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="draft">
                                <button type="submit" class="btn btn-warning text-dark">📝 Tornar Rascunho</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.global.news.update', $news) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="published">
                                <button type="submit" class="btn btn-success">🚀 Publicar Agora</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.global.news.destroy', $news) }}" onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">🗑️ Excluir Notícia</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">Informações de Publicação</h6>
                    <div class="small text-muted">
                        <div class="mb-2"><span class="fw-semibold">Status:</span> <span class="badge {{ $news->status === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}</span></div>
                        <div class="mb-2"><span class="fw-semibold">Autor:</span> {{ $news->user->name }}</div>
                        <div class="mb-2"><span class="fw-semibold">Criado em:</span> {{ $news->created_at->format('d/m/Y H:i') }}</div>
                        @if($news->updated_at != $news->created_at)
                            <div class="mb-2"><span class="fw-semibold">Atualizado em:</span> {{ $news->updated_at->format('d/m/Y H:i') }}</div>
                        @endif
                        @if($news->published_at)
                            <div class="mb-2"><span class="fw-semibold">Publicado em:</span> {{ $news->published_at->format('d/m/Y H:i') }}</div>
                        @endif
                        <div class="mb-2"><span class="fw-semibold">Destaque:</span> {{ $news->featured ? 'Sim' : 'Não' }}</div>
                        @if($news->slug)
                            <div class="mb-0"><span class="fw-semibold">URL:</span> <span class="text-break">{{ $news->slug }}</span></div>
                        @endif
                    </div>
                </div>
            </div>

            @if($news->meta_description || $news->slug)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">SEO</h6>
                        @if($news->slug)
                            <div class="mb-2">
                                <span class="fw-semibold">URL Amigável:</span>
                                <div class="mt-1 p-2 bg-light rounded small font-monospace">/noticias/{{ $news->slug }}</div>
                            </div>
                        @endif
                        @if($news->meta_description)
                            <div class="mb-0">
                                <span class="fw-semibold">Meta Descrição:</span>
                                <div class="mt-1 text-muted">{{ $news->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">Navegação</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.global.news.index') }}" class="btn btn-link text-start">← Todas as Notícias</a>
                        <a href="{{ route('admin.global.news.create') }}" class="btn btn-link text-start">+ Nova Notícia</a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-link text-start">🏠 Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
