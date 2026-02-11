@extends('admin.layout')

@section('title', 'Editar: ' . $news->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <h2 class="h2 fw-bold text-dark">Editar Notícia</h2>
    <a href="{{ route('admin.administrativo.news.index') }}" class="text-primary hover-text-primary-dark">
        ← Voltar para Notícias
    </a>
</div>

@if ($errors->any())
    <div class="bg-danger-subtle border border-danger text-danger-emphasis px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-success-subtle border border-success text-success-emphasis px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded shadow p-6">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8 d-flex flex-column gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="d-block small fw-medium text-dark mb-2">
                        Título *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
                           class="form-control"
                           required>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="d-block small fw-medium text-dark mb-2">
                        Conteúdo *
                    </label>
                    <textarea name="content" id="content" rows="15" 
                              class="form-control"
                              required>{{ old('content', $news->content) }}</textarea>
                    <p class="small text-secondary mt-1">Use quebras de linha para separar parágrafos.</p>
                </div>

                <!-- Summary -->
                <div>
                    <label for="summary" class="d-block small fw-medium text-dark mb-2">
                        Resumo
                    </label>
                    <textarea name="summary" id="summary" rows="3" 
                              class="form-control"
                              placeholder="Breve resumo da notícia (opcional)">{{ old('summary', $news->summary) }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 d-flex flex-column gap-4">
                <!-- Publishing Options -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">Opções de Publicação</h3>
                    
                    <div class="d-flex flex-column gap-3">
                        <!-- Status -->
                        <div>
                            <label for="status" class="d-block small fw-medium text-dark mb-2">
                                Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                            </select>
                        </div>

                        <!-- Featured -->
                        <div>
                            <label class="d-flex align-items-center">
                                <input type="checkbox" name="featured" value="1" 
                                       {{ old('featured', $news->featured) ? 'checked' : '' }}
                                       class="form-check-input">
                                <span class="ms-2 small text-dark">Destacar na página inicial</span>
                            </label>
                        </div>

                        <!-- Publish Date -->
                        <div>
                            <label for="published_at" class="d-block small fw-medium text-dark mb-2">
                                Data de Publicação
                            </label>
                            <input type="datetime-local" name="published_at" id="published_at" 
                                   value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="form-control">
                            <p class="small text-secondary mt-1">Deixe vazio para usar data atual</p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">Imagem de Destaque</h3>
                    
                    <!-- Current Image -->
                    @if($news->featured_image)
                        <div class="mb-4">
                            <p class="small text-dark mb-2">Imagem atual:</p>
                            <img src="{{ Storage::url($news->featured_image) }}" 
                                 alt="Imagem atual" 
                                 class="w-100 rounded">
                            <label class="d-flex align-items-center mt-2">
                                <input type="checkbox" name="remove_image" value="1" 
                                       class="form-check-input">
                                <span class="ms-2 small text-danger">Remover imagem atual</span>
                            </label>
                        </div>
                    @endif
                    
                    <div>
                        <label for="featured_image" class="d-block small fw-medium text-dark mb-2">
                            {{ $news->featured_image ? 'Substituir Imagem' : 'Escolher Imagem' }}
                        </label>
                        <input type="file" name="featured_image" id="featured_image" 
                               accept="image/*"
                               class="form-control">
                        <p class="small text-secondary mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 d-none">
                        <p class="small text-dark mb-2">Nova imagem:</p>
                        <img id="preview-img" src="" alt="Preview" class="w-100 rounded">
                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">SEO</h3>
                    
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label for="meta_description" class="d-block small fw-medium text-dark mb-2">
                                Meta Descrição
                            </label>
                            <textarea name="meta_description" id="meta_description" rows="3" 
                                      class="form-control"
                                      placeholder="Descrição para motores de busca">{{ old('meta_description', $news->meta_description) }}</textarea>
                        </div>

                        <div>
                            <label for="slug" class="d-block small fw-medium text-dark mb-2">
                                URL Amigável
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" 
                                   class="form-control"
                                   placeholder="url-da-noticia">
                            <p class="small text-secondary mt-1">Será gerada automaticamente se vazio</p>
                        </div>
                    </div>
                </div>

                <!-- Publishing Info -->
                <div class="bg-info-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-2">Informações</h3>
                    <div class="small text-secondary d-flex flex-column gap-1">
                        <p><strong>Autor:</strong> {{ $news->user->name }}</p>
                        <p><strong>Criado:</strong> {{ $news->created_at->format('d/m/Y H:i') }}</p>
                        @if($news->updated_at != $news->created_at)
                            <p><strong>Atualizado:</strong> {{ $news->updated_at->format('d/m/Y H:i') }}</p>
                        @endif
                        @if($news->published_at)
                            <p><strong>Publicado:</strong> {{ $news->published_at->format('d/m/Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center mt-8 pt-6 border-top">
            <div class="d-flex gap-3">
                <a href="{{ route('admin.administrativo.news.index') }}" 
                   class="text-secondary hover-text-dark fw-medium">
                    Cancelar
                </a>
                
                <a href="{{ route('admin.administrativo.news.show', $news) }}" 
                   class="text-primary hover-text-primary-dark fw-medium">
                    Visualizar
                </a>
            </div>
            
            <div class="d-flex gap-3">
                <button type="submit" name="action" value="draft" 
                        class="btn btn-secondary px-4 py-2">
                    Salvar como Rascunho
                </button>
                <button type="submit" name="action" value="publish" 
                        class="btn btn-primary px-4 py-2">
                    Atualizar e Publicar
                </button>
            </div>
        </div>
    </div>
</form>

<script>
// Auto-generate slug from title (only if slug is empty)
document.getElementById('title').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (slugField.value === '') {
        const title = this.value;
        const slug = title
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '') // Remove accents
            .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens
            .trim('-'); // Remove leading/trailing hyphens
        
        slugField.value = slug;
    }
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
