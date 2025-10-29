@extends('admin.layout')

@section('title', 'Minhas Notícias - Coordenador')

@push('styles')
<style>
    .news-header {
        background: linear-gradient(135deg, var(--sp-teal-dark) 0%, var(--sp-teal) 100%);
        color: var(--sp-white);
        padding: var(--space-xl);
        border-radius: var(--radius-xl);
        margin: var(--space-6);
        text-align: center;
    }
    
    .news-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: var(--space-6);
        gap: var(--space-4);
    }
    
    .btn {
        padding: var(--space-3) var(--space-4);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: var(--text-sm);
        font-weight: var(--font-medium);
        border: none;
        cursor: pointer;
        transition: all var(--duration-200) ease;
    }
    
    .btn-primary {
        background: var(--sp-teal);
        color: var(--sp-white);
    }
    
    .btn-primary:hover {
        background: var(--sp-teal-dark);
        text-decoration: none;
        color: var(--sp-white);
    }
    
    .news-grid {
        margin: var(--space-6);
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
    }
    
    .news-card {
        background: var(--sp-white);
        border: 1px solid var(--sp-gray-200);
        border-radius: var(--radius-lg);
        padding: var(--space-5);
        box-shadow: var(--shadow-md);
        transition: all var(--duration-300) ease;
    }
    
    .news-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .news-header-card {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: var(--space-3);
    }
    
    .news-title {
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--sp-teal-dark);
        margin: 0;
    }
    
    .news-status {
        padding: var(--space-1) var(--space-2);
        border-radius: var(--radius-sm);
        font-size: var(--text-xs);
        font-weight: var(--font-medium);
    }
    
    .status-published {
        background: var(--sp-green-50);
        color: var(--sp-green-dark);
        border: 1px solid var(--sp-green);
    }
    
    .status-draft {
        background: var(--sp-gold-50);
        color: var(--sp-gold-dark);
        border: 1px solid var(--sp-gold);
    }
    
    .news-meta {
        display: flex;
        gap: var(--space-4);
        margin-bottom: var(--space-3);
        font-size: var(--text-sm);
        color: var(--sp-gray-600);
    }
    
    .news-excerpt {
        color: var(--sp-gray-700);
        line-height: var(--leading-relaxed);
        margin-bottom: var(--space-4);
    }
    
    .news-actions-card {
        display: flex;
        gap: var(--space-2);
    }
    
    .btn-secondary {
        background: var(--sp-gray-100);
        color: var(--sp-gray-700);
    }
    
    .btn-secondary:hover {
        background: var(--sp-gray-200);
        text-decoration: none;
        color: var(--sp-gray-700);
    }
    
    .empty-state {
        text-align: center;
        padding: var(--space-8);
        background: var(--sp-white);
        border-radius: var(--radius-xl);
        margin: var(--space-6);
        box-shadow: var(--shadow-md);
    }
    
    .empty-icon {
        font-size: var(--text-6xl);
        margin-bottom: var(--space-4);
    }
    
    .pagination-wrapper {
        margin: var(--space-6);
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="news-header">
    <h1>📰 Minhas Notícias</h1>
    <p>Gerencie as notícias que você criou</p>
</div>

<div class="news-actions">
    <h2 style="margin: 0; color: var(--sp-teal-dark);">Lista de Notícias</h2>
    <a href="{{ route('admin.coordinator.news.create') }}" class="btn btn-primary">
        ➕ Nova Notícia
    </a>
</div>

<div class="news-grid">
    @forelse($news as $item)
        <div class="news-card">
            <div class="news-header-card">
                <h3 class="news-title">{{ $item->title }}</h3>
                <span class="news-status {{ $item->status === 'published' ? 'status-published' : 'status-draft' }}">
                    {{ $item->status === 'published' ? '✅ Publicada' : '📝 Rascunho' }}
                </span>
            </div>
            
            <div class="news-meta">
                <span>📅 {{ $item->created_at->format('d/m/Y H:i') }}</span>
                @if($item->published_at)
                    <span>🌐 Publicada em {{ $item->published_at->format('d/m/Y') }}</span>
                @endif
            </div>
            
            <div class="news-excerpt">
                {{ $item->excerpt ?: Str::limit($item->content, 200) }}
            </div>
            
            <div class="news-actions-card">
                <a href="{{ route('admin.coordinator.news.edit', $item) }}" class="btn btn-secondary">
                    ✏️ Editar
                </a>
                @if($item->status === 'published')
                    <span class="btn btn-secondary" style="opacity: 0.6; cursor: not-allowed;">
                        👁️ Publicada
                    </span>
                @else
                    <span class="btn btn-secondary" style="opacity: 0.6; cursor: not-allowed;">
                        📝 Rascunho
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">
            <div class="empty-icon">📰</div>
            <h3>Nenhuma notícia encontrada</h3>
            <p>Você ainda não criou nenhuma notícia. Clique no botão acima para criar sua primeira notícia!</p>
            <a href="{{ route('admin.coordinator.news.create') }}" class="btn btn-primary" style="margin-top: var(--space-4);">
                ➕ Criar Primeira Notícia
            </a>
        </div>
    @endforelse
</div>

@if($news->hasPages())
    <div class="pagination-wrapper">
        {{ $news->links() }}
    </div>
@endif
@endsection