@extends('admin.layout')

@section('title', 'Nova Notícia - Coordenador')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 15px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h2 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-plus-circle"></i> Nova Notícia
                    </h1>
                    <p class="mb-0" style="color: #FFD66B;">Crie uma nova notícia para {{ Auth::user()->parishGroup->name ?? 'seu grupo' }}</p>
                </div>
                <a href="{{ route('admin.coordenador.news.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <x-alert type="danger" class="alert-dismissible fade show">
            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Erro ao salvar</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </x-alert>
    @endif

    <form method="POST" action="{{ route('admin.coordenador.news.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="row g-4">
            <!-- Coluna Principal -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><i class="bi bi-file-text"></i> Conteúdo da Notícia</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                <i class="bi bi-card-heading"></i> Título *
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   value="{{ old('title') }}" 
                                   class="form-control form-control-lg" 
                                   placeholder="Digite um título atraente..."
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">
                                <i class="bi bi-text-paragraph"></i> Conteúdo *
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="15" 
                                      class="form-control" 
                                      placeholder="Escreva o conteúdo da notícia aqui..."
                                      required>{{ old('content') }}</textarea>
                            <small class="text-muted">Use quebras de linha para separar parágrafos.</small>
                        </div>

                        <div class="mb-0">
                            <label for="summary" class="form-label fw-semibold">
                                <i class="bi bi-bookmark"></i> Resumo (Opcional)
                            </label>
                            <textarea name="summary" 
                                      id="summary" 
                                      rows="3" 
                                      class="form-control" 
                                      placeholder="Breve resumo que aparecerá na listagem de notícias">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna Lateral -->
            <div class="col-lg-4">
                <!-- Opções de Publicação -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-gear"></i> Opções de Publicação</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on"></i> Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>
                                    📝 Rascunho (não visível)
                                </option>
                                <option value="published" {{ old('status', 'published') === 'published' ? 'selected' : '' }}>
                                    ✅ Publicar (visível no site)
                                </option>
                            </select>
                        </div>

                        <div class="form-check mb-3 p-3 bg-light rounded">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="featured" 
                                   value="1" 
                                   id="featured" 
                                   {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="featured">
                                <i class="bi bi-star-fill text-warning"></i> Destacar na página inicial
                            </label>
                        </div>

                        <div class="mb-0">
                            <label for="published_at" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event"></i> Data de Publicação
                            </label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   id="published_at" 
                                   value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" 
                                   class="form-control">
                            <small class="text-muted">Deixe vazio para publicar imediatamente</small>
                        </div>
                    </div>
                </div>

                <!-- Imagem de Destaque -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-image"></i> Imagem de Destaque</h6>
                    </div>
                    <div class="card-body">
                        <input type="file" 
                               name="featured_image" 
                               id="featured_image" 
                               accept="image/*" 
                               class="form-control">
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Formatos: JPG, PNG, WebP (máx. 2MB)
                        </small>
                    </div>
                </div>

                <!-- SEO -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-search"></i> SEO (Otimização)</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label fw-semibold">Meta Descrição</label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      rows="3" 
                                      class="form-control" 
                                      placeholder="Descrição para Google e redes sociais">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">Recomendado: 150-160 caracteres</small>
                        </div>

                        <div class="mb-0">
                            <label for="slug" class="form-label fw-semibold">URL Amigável</label>
                            <input type="text" 
                                   name="slug" 
                                   id="slug" 
                                   value="{{ old('slug') }}" 
                                   class="form-control" 
                                   placeholder="url-da-noticia">
                            <small class="text-muted">Será gerada automaticamente se vazio</small>
                        </div>
                    </div>
                </div>

                <!-- Info sobre TAG -->
                <div class="alert alert-info mt-3" role="alert">
                    <x-alert type="info" class="mt-3">
                        <h6 class="alert-heading"><i class="bi bi-tag-fill"></i> Identificação Automática</h6>
                        <p class="mb-0 small">Esta notícia será automaticamente marcada como pertencente a <strong>{{ Auth::user()->parishGroup->name ?? 'seu grupo' }}</strong>.</p>
                    </x-alert>
            </div>
        </div>

        <!-- Botões de Ação -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.coordenador.news.index') }}" class="btn btn-link text-decoration-none">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="draft" class="btn btn-secondary btn-lg">
                            <i class="bi bi-save"></i> Salvar Rascunho
                        </button>
                        <button type="submit" name="action" value="publish" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Publicar Notícia
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-gerar slug a partir do título
document.getElementById('title').addEventListener('input', function(e) {
    const slugInput = document.getElementById('slug');
    if (!slugInput.value || slugInput.dataset.autoGenerated !== 'false') {
        const slug = e.target.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '') // Remove acentos
            .replace(/[^\w\s-]/g, '') // Remove caracteres especiais
            .replace(/\s+/g, '-') // Substitui espaços por hífens
            .replace(/-+/g, '-') // Remove hífens duplicados
            .trim();
        slugInput.value = slug;
        slugInput.dataset.autoGenerated = 'true';
    }
});

document.getElementById('slug').addEventListener('input', function() {
    this.dataset.autoGenerated = 'false';
});
</script>
@endsection
