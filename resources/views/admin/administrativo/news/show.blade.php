@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="h3 fw-bold mb-2">{{ $news->title }}</h2>
            <div class="d-flex align-items-center gap-3 flex-wrap small text-muted">
                <span>Por {{ $news->user->name }}</span>
                <span>•</span>
                <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
                <span>•</span>
                <span class="badge {{ $news->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                    {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                </span>
                @if($news->featured)
                    <span class="text-warning">⭐ Destaque</span>
                @endif
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('admin.administrativo.news.edit', $news) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Editar
            </a>
            <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <!-- Featured Image -->
                @if($news->featured_image)
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="card-img-top" style="height: 300px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <!-- Summary -->
                    @if($news->summary)
                        <div class="alert alert-info border-start border-4 border-info" role="alert">
                            <p class="mb-0 fw-semibold">{{ $news->summary }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="mb-4">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <!-- Meta Information -->
                    @if($news->meta_description)
                        <div class="mt-5 pt-4 border-top">
                            <h5 class="fw-semibold mb-2">Meta Descrição (SEO)</h5>
                            <p class="text-muted">{{ $news->meta_description }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Preview Notice -->
            @if($news->status === 'draft')
                <div class="alert alert-warning d-flex align-items-center mt-4" role="alert">
                    <div class="me-3" style="font-size: 1.5rem;">⚠️</div>
                    <div>
                        <h6 class="alert-heading fw-bold mb-1">Esta notícia está em rascunho</h6>
                        <p class="mb-0 small">
                            Ela não será exibida no site público até ser publicada.
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Ações Rápidas</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.administrativo.news.edit', $news) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i> Editar Notícia
                        </a>
                        
                        @if($news->status === 'published')
                            <form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="draft">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-file-earmark me-1"></i> Tornar Rascunho
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="published">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-send-check me-1"></i> Publicar Agora
                                </button>
                            </form>
                        @endif

                        <form method="POST" action="{{ route('admin.administrativo.news.destroy', $news) }}" 
                              onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-1"></i> Excluir Notícia
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Publishing Information -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Informações de Publicação</h5>
                    <div class="small">
                        <div class="mb-3">
                            <span class="fw-semibold">Status:</span>
                            <span class="badge ms-2 {{ $news->status === 'published' ? 'bg-success' : 'bg-warning' }}">
                                {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                            </span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="fw-semibold">Autor:</span>
                            <span class="ms-2 text-muted">{{ $news->user->name }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <span class="fw-semibold">Criado em:</span>
                            <span class="ms-2 text-muted">{{ $news->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        @if($news->updated_at != $news->created_at)
                            <div class="mb-3">
                                <span class="fw-semibold">Atualizado em:</span>
                                <span class="ms-2 text-muted">{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        
                        @if($news->published_at)
                            <div class="mb-3">
                                <span class="fw-semibold">Publicado em:</span>
                                <span class="ms-2 text-muted">{{ $news->published_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <span class="fw-semibold">Destaque:</span>
                            <span class="ms-2 text-muted">{{ $news->featured ? 'Sim' : 'Não' }}</span>
                        </div>
                        
                        @if($news->slug)
                            <div class="mb-0">
                                <span class="fw-semibold">URL:</span>
                                <span class="ms-2 text-muted text-break">{{ $news->slug }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($news->meta_description || $news->slug)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">SEO</h5>
                        <div class="small">
                            @if($news->slug)
                                <div class="mb-3">
                                    <span class="fw-semibold">URL Amigável:</span>
                                    <div class="mt-1 p-2 bg-light rounded font-monospace small">
                                        /noticias/{{ $news->slug }}
                                    </div>
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
                </div>
            @endif

            <!-- Navigation -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Navegação</h5>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Todas as Notícias
                        </a>
                        <a href="{{ route('admin.administrativo.news.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nova Notícia
                        </a>
                        <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-house me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
