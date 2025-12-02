@extends('admin.layout')

@section('title', 'Nova Notícia')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold">Nova Notícia</h2>
        <a href="{{ route('admin.administrativo.news.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Notícias
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.administrativo.news.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Título *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                   class="form-control form-control-lg" required>
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Conteúdo *</label>
                            <textarea name="content" id="content" rows="15" 
                                      class="form-control" required>{{ old('content') }}</textarea>
                            <small class="form-text text-muted">Use quebras de linha para separar parágrafos.</small>
                        </div>

                        <!-- Summary -->
                        <div class="mb-4">
                            <label for="summary" class="form-label fw-semibold">Resumo</label>
                            <textarea name="summary" id="summary" rows="3" 
                                      class="form-control"
                                      placeholder="Breve resumo da notícia (opcional)">{{ old('summary') }}</textarea>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Publishing Options -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Opções de Publicação</h5>
                                
                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicar</option>
                                    </select>
                                </div>

                                <!-- Featured -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="featured" value="1" 
                                               {{ old('featured') ? 'checked' : '' }}
                                               class="form-check-input" id="featured">
                                        <label class="form-check-label" for="featured">
                                            Destacar na página inicial
                                        </label>
                                    </div>
                                </div>

                                <!-- Publish Date -->
                                <div class="mb-0">
                                    <label for="published_at" class="form-label">Data de Publicação</label>
                                    <input type="datetime-local" name="published_at" id="published_at" 
                                           value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                           class="form-control">
                                    <small class="form-text text-muted">Deixe vazio para publicar agora</small>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Imagem de Destaque</h5>
                                
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">Escolher Imagem</label>
                                    <input type="file" name="featured_image" id="featured_image" 
                                           accept="image/*"
                                           class="form-control">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF (máx. 2MB)</small>
                                </div>

                                <!-- Image Preview -->
                                <div id="image-preview" class="d-none">
                                    <img id="preview-img" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">SEO</h5>
                                
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Descrição</label>
                                    <textarea name="meta_description" id="meta_description" rows="3" 
                                              class="form-control"
                                              placeholder="Descrição para motores de busca">{{ old('meta_description') }}</textarea>
                                </div>

                                <div class="mb-0">
                                    <label for="slug" class="form-label">URL Amigável</label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                           class="form-control"
                                           placeholder="url-da-noticia">
                                    <small class="form-text text-muted">Será gerada automaticamente se vazio</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.administrativo.news.index') }}" 
                   class="btn btn-outline-secondary">
                    Cancelar
                </a>
                
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="draft" 
                            class="btn btn-secondary">
                        <i class="bi bi-file-earmark me-1"></i> Salvar Rascunho
                    </button>
                    <button type="submit" name="action" value="publish" 
                            class="btn btn-primary">
                        <i class="bi bi-send-check me-1"></i> Publicar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '') // Remove accents
        .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
        .replace(/\s+/g, '-') // Replace spaces with hyphens
        .replace(/-+/g, '-') // Replace multiple hyphens
        .trim('-'); // Remove leading/trailing hyphens
    
    document.getElementById('slug').value = slug;
});

// Image preview
document.getElementById('featured_image').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('d-none');
    }
});

// Handle form submission buttons
document.querySelectorAll('button[name="action"]').forEach(button => {
    button.addEventListener('click', function() {
        const status = this.value === 'publish' ? 'published' : 'draft';
        document.getElementById('status').value = status;
    });
});
</script>
@endsection
