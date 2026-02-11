@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <div>
        <h2 class="h2 fw-bold text-dark">{{ $news->title }}</h2>
        <div class="d-flex align-items-center gap-4 mt-2 small text-secondary">
            <span>Por {{ $news->user->name }}</span>
            <span>•</span>
            <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
            <span>•</span>
            <span class="px-2 py-1 rounded small
                {{ $news->status === 'published' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
            </span>
            @if($news->featured)
                <span class="text-warning">⭐ Destaque</span>
            @endif
        </div>
    </div>
    
    <div class="d-flex gap-3">
        <a href="{{ route('admin.administrativo.news.edit', $news) }}" 
           class="btn btn-primary px-4 py-2 rounded hover-bg-primary-dark">
            Editar
        </a>
        <a href="{{ route('admin.administrativo.news.index') }}" 
           class="btn btn-outline-secondary px-4 py-2 rounded">
            Voltar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success border border-success px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="row g-6">
    <!-- Main Content -->
    <div class="col-12 col-lg-8">
        <div class="bg-white rounded shadow">
            <!-- Featured Image -->
            @if($news->featured_image)
                <div class="mb-6">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-100 object-cover rounded-top" style="height: 16rem;">
                </div>
            @endif
            
            <div class="p-6">
                <!-- Summary -->
                @if($news->summary)
                    <div class="alert alert-info border-start border-4 border-primary p-4 mb-6">
                        <p class="text-primary fw-medium mb-0">{{ $news->summary }}</p>
                    </div>
                @endif

                <!-- Content -->
                <div class="prose">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- Meta Information -->
                @if($news->meta_description)
                    <div class="mt-8 pt-6 border-top">
                        <h3 class="fw-semibold text-dark mb-2">Meta Descrição (SEO)</h3>
                        <p class="text-secondary">{{ $news->meta_description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Preview Notice -->
        @if($news->status === 'draft')
            <div class="mt-6 alert alert-warning border border-warning rounded p-4">
                <div class="d-flex align-items-center">
                    <div class="text-warning me-3">⚠️</div>
                    <div>
                        <h3 class="fw-medium text-warning-emphasis">Esta notícia está em rascunho</h3>
                        <p class="text-warning-emphasis small mb-0">
                            Ela não será exibida no site público até ser publicada.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="d-flex flex-column gap-4">
            <!-- Quick Actions -->
            <div class="bg-white rounded shadow p-4">
                <h3 class="fw-semibold text-dark mb-4">Ações Rápidas</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.administrativo.news.edit', $news) }}" 
                       class="btn btn-primary w-100 text-center">
                        ✏️ Editar Notícia
                    </a>
                    
                    @if($news->status === 'published')
                        <form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="draft">
                            <button type="submit" class="btn btn-warning w-100">
                                📝 Tornar Rascunho
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" class="btn btn-success w-100">
                                🚀 Publicar Agora
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.administrativo.news.destroy', $news) }}" 
                          onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            🗑️ Excluir Notícia
                        </button>
                    </form>
                </div>
            </div>

            <!-- Publishing Information -->
            <div class="bg-white rounded shadow p-4">
                <h3 class="fw-semibold text-dark mb-4">Informações de Publicação</h3>
                <div class="d-flex flex-column gap-3 small">
                    <div>
                        <span class="fw-medium text-dark">Status:</span>
                        <span class="ms-2 px-2 py-1 rounded small
                            {{ $news->status === 'published' ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis' }}">
                            {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                        </span>
                    </div>
                    
                    <div>
                        <span class="fw-medium text-dark">Autor:</span>
                        <span class="ms-2 text-secondary">{{ $news->user->name }}</span>
                    </div>
                    
                    <div>
                        <span class="fw-medium text-dark">Criado em:</span>
                        <span class="ms-2 text-secondary">{{ $news->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    
                    @if($news->updated_at != $news->created_at)
                        <div>
                            <span class="fw-medium text-dark">Atualizado em:</span>
                            <span class="ms-2 text-secondary">{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    
                    @if($news->published_at)
                        <div>
                            <span class="fw-medium text-dark">Publicado em:</span>
                            <span class="ms-2 text-secondary">{{ $news->published_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                    
                    <div>
                        <span class="fw-medium text-dark">Destaque:</span>
                        <span class="ms-2 text-secondary">{{ $news->featured ? 'Sim' : 'Não' }}</span>
                    </div>
                    
                    @if($news->slug)
                        <div>
                            <span class="fw-medium text-dark">URL:</span>
                            <span class="ms-2 text-secondary small text-break">{{ $news->slug }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- SEO Information -->
            @if($news->meta_description || $news->slug)
                <div class="bg-white rounded shadow p-4">
                    <h3 class="fw-semibold text-dark mb-4">SEO</h3>
                    <div class="d-flex flex-column gap-3 small">
                        @if($news->slug)
                            <div>
                                <span class="fw-medium text-dark">URL Amigável:</span>
                                <div class="mt-1 p-2 bg-secondary-subtle rounded small font-monospace">
                                    /noticias/{{ $news->slug }}
                                </div>
                            </div>
                        @endif
                        
                        @if($news->meta_description)
                            <div>
                                <span class="fw-medium text-dark">Meta Descrição:</span>
                                <div class="mt-1 text-secondary">{{ $news->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Navigation -->
            <div class="bg-white rounded shadow p-4">
                <h3 class="fw-semibold text-dark mb-4">Navegação</h3>
                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.administrativo.news.index') }}" 
                       class="text-primary text-decoration-none small hover-text-primary-dark">
                        ← Todas as Notícias
                    </a>
                    <a href="{{ route('admin.administrativo.news.create') }}" 
                       class="text-success text-decoration-none small hover-text-success-dark">
                        + Nova Notícia
                    </a>
                    <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" 
                       class="text-secondary text-decoration-none small hover-text-secondary-dark">
                        🏠 Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
