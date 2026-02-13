@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h2 fw-bold text-dark">{{ $news->title }}</h2>
        <div class="d-flex align-items-center gap-3 mt-2 small text-secondary">
            <span>Por {{ $news->user->name }}</span>
            <span>•</span>
            <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
            <span>•</span>
            <span class="badge {{ $news->status === 'published' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
            </span>
            @if($news->featured)
                <span class="text-warning">⭐ Destaque</span>
            @endif
        </div>
    </div>
    
    <div class="d-flex gap-3">
        <a href="{{ route('admin.global.news.edit', $news) }}" 
           class="btn btn-primary">
            Editar
        </a>
        <a href="{{ route('admin.global.news.index') }}" 
           class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">
    <!-- Main Content -->
    <div class="col-12 col-lg-8">
        <div class="card shadow">
            <!-- Featured Image -->
            @if($news->featured_image)
                <div class="mb-4">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-100 rounded-top" style="height: 16rem; object-fit: cover;">
                </div>
            @endif
            
            <div class="card-body">
                <!-- Summary -->
                @if($news->summary)
                    <div class="bg-info-subtle border-start border-info border-4 p-3 mb-4">
                        <p class="text-info-emphasis fw-medium mb-0">{{ $news->summary }}</p>
                    </div>
                @endif

                <!-- Content -->
                <div class="prose max-w-none">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- Meta Information -->
                @if($news->meta_description)
                    <div class="mt-5 pt-4 border-top">
                        <h3 class="fw-semibold text-dark mb-2">Meta Descrição (SEO)</h3>
                        <p class="text-secondary">{{ $news->meta_description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Preview Notice -->
        @if($news->status === 'draft')
            <div class="mt-4 bg-warning-subtle border border-warning rounded p-3">
                <div class="d-flex align-items-center">
                    <div class="text-warning me-3 fs-4">⚠️</div>
                    <div>
                        <h3 class="fw-medium text-warning-emphasis mb-1">Esta notícia está em rascunho</h3>
                        <p class="text-warning-emphasis small mb-0">
                            Ela não será exibida no site público até ser publicada.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4 d-flex flex-column gap-4">
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="fw-semibold text-dark mb-3">Ações Rápidas</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.global.news.edit', $news) }}" 
                       class="btn btn-primary w-100">
                        ✏️ Editar Notícia
                    </a>
                    
                    @if($news->status === 'published')
                        <form method="POST" action="{{ route('admin.global.news.update', $news) }}" class="d-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="draft">
                            <button type="submit" 
                                    class="btn btn-warning w-100">
                                📝 Tornar Rascunho
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.global.news.update', $news) }}" class="d-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" 
                                    class="btn btn-success w-100">
                                🚀 Publicar Agora
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.global.news.destroy', $news) }}" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger w-100">
                            🗑️ Excluir Notícia
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Publishing Information -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="fw-semibold text-dark mb-3">Informações de Publicação</h3>
                <div class="d-flex flex-column gap-2 small">
                    <div>
                        <span class="fw-medium text-body">Status:</span>
                        <span class="ms-2 badge {{ $news->status === 'published' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                            {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="fw-medium text-body">Autor:</span>
                        <span class="ms-2 text-secondary">{{ $news->user->name }}</span>
                    </div>
                    
                    <div>
                        <span class="fw-medium text-body">Criado em:</span>
                        <span class="ms-2 text-secondary">{{ $news->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($news->updated_at != $news->created_at)
                        <div>
                            <span class="fw-medium text-body">Atualizado em:</span>
                            <span class="ms-2 text-secondary">{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    
                    @if($news->published_at)
                        <div>
                            <span class="fw-medium text-body">Publicado em:</span>
                            <span class="ms-2 text-secondary">{{ $news->published_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    
                    <div>
                        <span class="fw-medium text-body">Destaque:</span>
                        <span class="ms-2 text-secondary">{{ $news->featured ? 'Sim' : 'Não' }}</span>
                    </div>
                    
                    @if($news->slug)
                        <div>
                            <span class="fw-medium text-body">URL:</span>
                            <span class="ms-2 text-secondary small text-break">{{ $news->slug }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SEO Information -->
        @if($news->meta_description || $news->slug)
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="fw-semibold text-dark mb-3">SEO</h3>
                    <div class="d-flex flex-column gap-2 small">
                        @if($news->slug)
                            <div>
                                <span class="fw-medium text-body">URL Amigável:</span>
                                <div class="mt-1 p-2 bg-secondary-subtle rounded small font-monospace">
                                    /noticias/{{ $news->slug }}
                                </div>
                            </div>
                        @endif
                        
                        @if($news->meta_description)
                            <div>
                                <span class="fw-medium text-body">Meta Descrição:</span>
                                <div class="mt-1 text-secondary">{{ $news->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="fw-semibold text-dark mb-3">Navegação</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.global.news.index') }}" 
                       class="text-primary hover-text-primary-dark small">
                        ← Todas as Notícias
                    </a>
                    <a href="{{ route('admin.global.news.create') }}" 
                       class="text-success hover-text-success-dark small">
                        + Nova Notícia
                    </a>
                    <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" 
                       class="text-secondary hover-text-dark small">
                        🏠 Painel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
