@extends('admin.layout')

@section('title', 'Gerenciar Notícias')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Header Section --}}
        <section class="sp-admin-header">
            <div class="sp-header-content">
                <div class="sp-header-main">
                    <h1 class="sp-admin-title"> Gerenciar Notícias</h1>
                    <p class="sp-admin-subtitle">
                        Gerencie as notícias e comunicados da paróquia
                    </p>
                </div>
                <div class="sp-header-actions">
                    <a href="{{ route('admin.administrativo.news.create') }}" class="sp-btn sp-btn-primary sp-btn-lg">
                         Nova Notícia
                    </a>
                </div>
            </div>
        </section>

        {{-- Filters Section --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                <div class="sp-card">
                    <div class="sp-card-header">
                        <h3 class="sp-card-title"> Filtros</h3>
                    </div>
                    <div class="sp-card-content">
                        <form method="GET" class="sp-filter-form">
                            <div class="sp-filter-grid">
                                <div class="sp-form-group">
                                    <label for="status" class="sp-label"> Status</label>
                                    <select name="status" id="status" class="sp-select">
                                        <option value="">Todos os status</option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>
                                             Publicados
                                        </option>
                                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                             Rascunhos
                                        </option>
                                    </select>
                                </div>

                                <div class="sp-form-group">
                                    <label for="featured" class="sp-label">Destaque</label>
                                    <select name="featured" id="featured" class="sp-select">
                                        <option value="">Todos</option>
                                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>
                                            Em destaque
                                        </option>
                                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>
                                             Não destacados
                                        </option>
                                    </select>
                                </div>

                                <div class="sp-form-group">
                                    <label for="search" class="sp-label"> Buscar</label>
                                    <input type="text" 
                                           name="search" 
                                           id="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Título, conteúdo ou autor..." 
                                           class="sp-input">
                                </div>

                                <div class="sp-form-actions">
                                    <button type="submit" class="sp-btn sp-btn-secondary">
                                         Filtrar
                                    </button>
                                    @if(request()->hasAny(['status', 'featured', 'search']))
                                        <a href="{{ route('admin.administrativo.news.index') }}" class="sp-btn sp-btn-outline">
                                             Limpar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        {{-- News List --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                @if($news->count() > 0)
                    <div class="sp-card">
                        <div class="sp-card-header">
                            <h3 class="sp-card-title"> Lista de Notícias</h3>
                            <div class="sp-card-meta">
                                {{ $news->total() }} {{ Str::plural('notícia', $news->total()) }} encontrada{{ $news->total() !== 1 ? 's' : '' }}
                            </div>
                        </div>
                        <div class="sp-card-content sp-p-0">
                            <div class="sp-table-container">
                                <table class="sp-table">
                                    <thead class="sp-table-header">
                                        <tr>
                                            <th class="sp-table-cell sp-table-cell-header"> Notícia</th>
                                            <th class="sp-table-cell sp-table-cell-header"> Autor</th>
                                            <th class="sp-table-cell sp-table-cell-header"> Status</th>
                                            <th class="sp-table-cell sp-table-cell-header">Destaque</th>
                                            <th class="sp-table-cell sp-table-cell-header"> Data</th>
                                            <th class="sp-table-cell sp-table-cell-header"> Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="sp-table-body">
                                        @foreach($news as $item)
                                            <tr class="sp-table-row">
                                                <td class="sp-table-cell">
                                                    <div class="sp-news-preview">
                                                        <h4 class="sp-news-title-small">{{ $item->title }}</h4>
                                                        <p class="sp-news-excerpt">{{ Str::limit($item->content, 80) }}</p>
                                                        @if($item->featured_image)
                                                            <span class="sp-badge sp-badge-info sp-badge-sm"> Com imagem</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="sp-table-cell">
                                                    <div class="sp-author-info">
                                                        <span class="sp-author-name">{{ $item->user->name }}</span>
                                                        <span class="sp-author-role">{{ ucfirst($item->user->role->value ?? 'user') }}</span>
                                                    </div>
                                                </td>
                                                <td class="sp-table-cell">
                                                    <span class="sp-badge sp-badge-{{ $item->status === 'published' ? 'success' : 'warning' }}">
                                                        @if($item->status === 'published')
                                                             Publicado
                                                        @else
                                                             Rascunho
                                                        @endif
                                                    </span>
                                                </td>
                                                <td class="sp-table-cell">
                                                    @if($item->featured)
                                                        <span class="sp-badge sp-badge-gold">Destaque</span>
                                                    @else
                                                        <span class="sp-text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="sp-table-cell">
                                                    <div class="sp-date-info">
                                                        <span class="sp-date">{{ $item->created_at->format('d/m/Y') }}</span>
                                                        <span class="sp-time">{{ $item->created_at->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td class="sp-table-cell">
                                                    <div class="sp-action-buttons">
                                                        <a href="{{ route('admin.administrativo.news.show', $item) }}" 
                                                           class="sp-btn sp-btn-outline sp-btn-xs"
                                                           title="Visualizar">
                                                             Ver
                                                        </a>
                                                        <a href="{{ route('admin.administrativo.news.edit', $item) }}" 
                                                           class="sp-btn sp-btn-secondary sp-btn-xs"
                                                           title="Editar">
                                                             Editar
                                                        </a>
                                                        <form method="POST" 
                                                              action="{{ route('admin.administrativo.news.destroy', $item) }}" 
                                                              class="sp-inline"
                                                              onsubmit="return confirm(' Tem certeza que deseja excluir esta notícia?\n\nEsta ação não pode ser desfeita.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="sp-btn sp-btn-error sp-btn-xs"
                                                                    title="Excluir">
                                                                 Excluir
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
                            <div class="sp-card-footer">
                                <div class="sp-pagination-wrapper">
                                    {{ $news->withQueryString()->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="sp-card">
                        <div class="sp-card-content">
                            <div class="sp-empty-state sp-text-center">
                                <div class="sp-empty-icon"></div>
                                <h3 class="sp-empty-title">Nenhuma notícia encontrada</h3>
                                @if(request()->hasAny(['status', 'featured', 'search']))
                                    <p class="sp-empty-description">
                                        Não encontramos notícias com os filtros aplicados. 
                                        Tente ajustar os critérios de busca.
                                    </p>
                                    <div class="sp-empty-actions">
                                        <a href="{{ route('admin.administrativo.news.index') }}" class="sp-btn sp-btn-outline sp-btn-lg">
                                             Limpar Filtros
                                        </a>
                                        <a href="{{ route('admin.administrativo.news.create') }}" class="sp-btn sp-btn-primary sp-btn-lg">
                                             Nova Notícia
                                        </a>
                                    </div>
                                @else
                                    <p class="sp-empty-description">
                                        Comece criando sua primeira notícia para manter a comunidade informada sobre os acontecimentos da paróquia.
                                    </p>
                                    <div class="sp-empty-actions">
                                        <a href="{{ route('admin.administrativo.news.create') }}" class="sp-btn sp-btn-primary sp-btn-lg">
                                             Criar Primeira Notícia
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Custom Styles for News Admin --}}
    <style>
        /* Admin Header */
        .sp-admin-header {
            margin-bottom: var(--space-6);
        }

        .sp-header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: var(--space-6);
        }

        .sp-admin-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-2);
        }

        .sp-admin-subtitle {
            color: var(--sp-gray);
            font-size: 1.125rem;
        }

        /* Filter Form */
        .sp-filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: var(--space-4);
            align-items: end;
        }

        .sp-form-actions {
            display: flex;
            gap: var(--space-2);
        }

        /* Table Styles */
        .sp-table-container {
            overflow-x: auto;
        }

        .sp-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sp-table-header {
            background: var(--sp-gray-50);
        }

        .sp-table-cell {
            padding: var(--space-4);
            border-bottom: 1px solid var(--sp-gray-200);
            vertical-align: top;
        }

        .sp-table-cell-header {
            font-weight: 600;
            color: var(--sp-red-dark);
            font-size: 0.875rem;
            border-bottom: 2px solid var(--sp-gray-300);
        }

        .sp-table-row:hover {
            background: var(--sp-gray-50);
        }

        /* News Preview */
        .sp-news-preview {
            max-width: 300px;
        }

        .sp-news-title-small {
            font-weight: 600;
            color: var(--sp-red-dark);
            margin-bottom: var(--space-1);
            line-height: 1.3;
        }

        .sp-news-excerpt {
            color: var(--sp-gray);
            font-size: 0.875rem;
            line-height: 1.4;
            margin-bottom: var(--space-2);
        }

        /* Author Info */
        .sp-author-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .sp-author-name {
            font-weight: 500;
            color: var(--sp-red-dark);
        }

        .sp-author-role {
            font-size: 0.75rem;
            color: var(--sp-gray);
            text-transform: capitalize;
        }

        /* Date Info */
        .sp-date-info {
            display: flex;
            flex-direction: column;
            gap: var(--space-1);
        }

        .sp-date {
            font-weight: 500;
            color: var(--sp-gray-dark);
        }

        .sp-time {
            font-size: 0.75rem;
            color: var(--sp-gray);
        }

        /* Action Buttons */
        .sp-action-buttons {
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
            min-width: 120px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sp-header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .sp-filter-grid {
                grid-template-columns: 1fr;
            }

            .sp-form-actions {
                grid-column: 1 / -1;
                justify-content: center;
            }

            .sp-table-container {
                border-radius: var(--border-radius);
                overflow: hidden;
            }

            .sp-table {
                min-width: 700px;
            }

            .sp-action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
                min-width: auto;
            }

            .sp-admin-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .sp-table {
                font-size: 0.875rem;
            }

            .sp-table-cell {
                padding: var(--space-3);
            }

            .sp-news-preview {
                max-width: 200px;
            }
        }
    </style>
@endsection
