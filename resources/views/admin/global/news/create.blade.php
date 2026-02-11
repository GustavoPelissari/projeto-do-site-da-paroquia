@extends('admin.layout')

@section('title', 'Nova Notícia')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold text-dark">Nova Notícia</h2>
    <a href="{{ route('admin.global.news.index') }}" class="text-primary hover-text-primary-dark">
        ← Voltar para Notícias
    </a>
</div>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('admin.global.news.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="card shadow">
        <div class="card-body">
            <div class="row g-4">
                <!-- Main Content -->
                <div class="col-12 col-lg-8 d-flex flex-column gap-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="form-label fw-medium">
                            Título *
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" 
                               class="form-control focus-ring-2"
                               required>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="form-label fw-medium">
                            Conteúdo *
                        </label>
                        <textarea name="content" id="content" rows="15" 
                                  class="form-control focus-ring-2"
                                  required>{{ old('content') }}</textarea>
                        <p class="form-text">Use quebras de linha para separar parágrafos.</p>
                    </div>

                    <!-- Summary -->
                    <div>
                        <label for="summary" class="form-label fw-medium">
                            Resumo
                        </label>
                        <textarea name="summary" id="summary" rows="3" 
                                  class="form-control focus-ring-2"
                                  placeholder="Breve resumo da notícia (opcional)">{{ old('summary') }}</textarea>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                    <!-- Publishing Options -->
                    <div class="bg-secondary-subtle rounded p-3">
                        <h3 class="fw-semibold text-dark mb-3">Opções de Publicação</h3>
                        
                        <div class="d-flex flex-column gap-3">
                            <!-- Status -->
                            <div>
                                <label for="status" class="form-label fw-medium">
                                    Status
                                </label>
                                <select name="status" id="status" class="form-select">
                                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicar</option>
                                </select>
                            </div>

                            <!-- Featured -->
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" name="featured" value="1" 
                                           {{ old('featured') ? 'checked' : '' }}
                                           class="form-check-input" id="featured">
                                    <label class="form-check-label" for="featured">Destacar na página inicial</label>
                                </div>
                            </div>

                            <!-- Publish Date -->
                            <div>
                                <label for="published_at" class="form-label fw-medium">
                                    Data de Publicação
                                </label>
                                <input type="datetime-local" name="published_at" id="published_at" 
                                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                       class="form-control">
                                <p class="form-text">Deixe vazio para publicar agora</p>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="bg-secondary-subtle rounded p-3">
                        <h3 class="fw-semibold text-dark mb-3">Imagem de Destaque</h3>
                        
                        <div>
                            <label for="featured_image" class="form-label fw-medium">
                                Escolher Imagem
                            </label>
                            <input type="file" name="featured_image" id="featured_image" 
                                   accept="image/*"
                                   class="form-control">
                            <p class="form-text">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                        </div>

                        <!-- Image Preview -->
                        <div id="image-preview" class="mt-3 d-none">
                            <img id="preview-img" src="" alt="Preview" class="w-100 rounded">
                        </div>
                    </div>

                    <!-- SEO -->
                    <div class="bg-secondary-subtle rounded p-3">
                        <h3 class="fw-semibold text-dark mb-3">SEO</h3>
                        
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <label for="meta_description" class="form-label fw-medium">
                                    Meta Descrição
                                </label>
                                <textarea name="meta_description" id="meta_description" rows="3" 
                                          class="form-control"
                                          placeholder="Descrição para motores de busca">{{ old('meta_description') }}</textarea>
                            </div>

                            <div>
                                <label for="slug" class="form-label fw-medium">
                                    URL Amigável
                                </label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                       class="form-control"
                                       placeholder="url-da-noticia">
                                <p class="form-text">Será gerada automaticamente se vazio</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('admin.global.news.index') }}" 
                   class="text-secondary hover-text-dark fw-medium">
                    Cancelar
                </a>
                
                <div class="d-flex gap-3">
                    <button type="submit" name="action" value="draft" 
                            class="btn btn-secondary px-4 py-2">
                        Salvar Rascunho
                    </button>
                    <button type="submit" name="action" value="publish" 
                            class="btn btn-primary px-4 py-2">
                        Publicar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

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
