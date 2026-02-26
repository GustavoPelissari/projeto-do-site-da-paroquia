@extends('admin.layout')

@section('title', 'Editar: ' . $news->title)

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold">Editar Notícia</h2>
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

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Título *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
                                   class="form-control form-control-lg" required>
                        </div>

                        <!-- Content -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-semibold">Conteúdo *</label>
                            <textarea name="content" id="content" rows="15" 
                                      class="form-control" required>{{ old('content', $news->content) }}</textarea>
                            <small class="form-text text-muted">Use quebras de linha para separar parágrafos.</small>
                        </div>

                        <!-- Summary -->
                        <div class="mb-4">
                            <label for="summary" class="form-label fw-semibold">Resumo</label>
                            <textarea name="summary" id="summary" rows="3" 
                                      class="form-control"
                                      placeholder="Breve resumo da notícia (opcional)">{{ old('summary', $news->summary) }}</textarea>
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
                                        <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                        <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                                    </select>
                                </div>

                                <!-- Featured -->
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="featured" value="1" 
                                               {{ old('featured', $news->featured) ? 'checked' : '' }}
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
                                           value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                                           class="form-control">
                                    <small class="form-text text-muted">Deixe vazio para usar data atual</small>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">Imagem de Destaque</h5>
                                
                                <!-- Current Image -->
                                @if($news->featured_image)
                                    <div class="mb-3">
                                        <p class="small mb-2">Imagem atual:</p>
                                        <img src="{{ Storage::url($news->featured_image) }}" 
                                             alt="Imagem atual" 
                                             class="img-fluid rounded">
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="remove_image" value="1" 
                                                   class="form-check-input" id="remove_image">
                                            <label class="form-check-label text-danger" for="remove_image">
                                                Remover imagem atual
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label for="featured_image" class="form-label">
                                        {{ $news->featured_image ? 'Substituir Imagem' : 'Escolher Imagem' }}
                                    </label>
                                    <input type="file" name="featured_image" id="featured_image" 
                                           accept="image/*"
                                           class="form-control">
                                    <small class="form-text text-muted">Formatos: JPG, PNG, GIF (máx. 2MB)</small>
                                </div>

                                <!-- Image Preview -->
                                <div id="image-preview" class="d-none">
                                    <p class="small mb-2">Nova imagem:</p>
                                    <img id="preview-img" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h5 class="card-title fw-bold mb-3">SEO</h5>
                                
                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Descrição</label>
                                    <textarea name="meta_description" id="meta_description" rows="3" 
                                              class="form-control"
                                              placeholder="Descrição para motores de busca">{{ old('meta_description', $news->meta_description) }}</textarea>
                                </div>

                                <div class="mb-0">
                                    <label for="slug" class="form-label">URL Amigável</label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" 
                                           class="form-control"
                                           placeholder="url-da-noticia">
                                    <small class="form-text text-muted">Será gerada automaticamente se vazio</small>
                                </div>
                            </div>
                        </div>

                        <!-- Publishing Info -->
                        <div class="card border-info border-start border-3 bg-light mb-4">
                            <div class="card-body">
                                <h6 class="card-title fw-bold mb-2">Informações</h6>
                                <div class="small">
                                    <p class="mb-1"><strong>Autor:</strong> {{ $news->user->name }}</p>
                                    <p class="mb-1"><strong>Criado:</strong> {{ $news->created_at->format('d/m/Y H:i') }}</p>
                                    @if($news->updated_at != $news->created_at)
                                        <p class="mb-1"><strong>Atualizado:</strong> {{ $news->updated_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                    @if($news->published_at)
                                        <p class="mb-0"><strong>Publicado:</strong> {{ $news->published_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.administrativo.news.index') }}" 
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>
                    
                    <a href="{{ route('admin.administrativo.news.show', $news) }}" 
                       class="btn btn-outline-primary">
                        Visualizar
                    </a>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="draft" 
                            class="btn btn-secondary">
                        <i class="bi bi-file-earmark me-1"></i> Salvar como Rascunho
                    </button>
                    <button type="submit" name="action" value="publish" 
                            class="btn btn-primary">
                        <i class="bi bi-send-check me-1"></i> Atualizar e Publicar
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

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

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.administrativo.news.update', $news) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Conteúdo *
                    </label>
                    <textarea name="content" id="content" rows="15" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              required>{{ old('content', $news->content) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Use quebras de linha para separar parágrafos.</p>
                </div>

                <!-- Summary -->
                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                        Resumo
                    </label>
                    <textarea name="summary" id="summary" rows="3" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Breve resumo da notícia (opcional)">{{ old('summary', $news->summary) }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publishing Options -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Opções de Publicação</h3>
                    
                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                            </select>
                        </div>

                        <!-- Featured -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" 
                                       {{ old('featured', $news->featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Destacar na página inicial</span>
                            </label>
                        </div>

                        <!-- Publish Date -->
                        <div>
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Data de Publicação
                            </label>
                            <input type="datetime-local" name="published_at" id="published_at" 
                                   value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Deixe vazio para usar data atual</p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Imagem de Destaque</h3>
                    
                    <!-- Current Image -->
                    @if($news->featured_image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700 mb-2">Imagem atual:</p>
                            <img src="{{ Storage::url($news->featured_image) }}" 
                                 alt="Imagem atual" 
                                 class="w-full rounded-md">
                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="remove_image" value="1" 
                                       class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                <span class="ml-2 text-sm text-red-600">Remover imagem atual</span>
                            </label>
                        </div>
                    @endif
                    
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $news->featured_image ? 'Substituir Imagem' : 'Escolher Imagem' }}
                        </label>
                        <input type="file" name="featured_image" id="featured_image" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 hidden">
                        <p class="text-sm text-gray-700 mb-2">Nova imagem:</p>
                        <img id="preview-img" src="" alt="Preview" class="w-full rounded-md">
                    </div>
                </div>

                <!-- SEO -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">SEO</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Descrição
                            </label>
                            <textarea name="meta_description" id="meta_description" rows="3" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2"
                                      placeholder="Descrição para motores de busca">{{ old('meta_description', $news->meta_description) }}</textarea>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                URL Amigável
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2"
                                   placeholder="url-da-noticia">
                            <p class="text-xs text-gray-500 mt-1">Será gerada automaticamente se vazio</p>
                        </div>
                    </div>
                </div>

                <!-- Publishing Info -->
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">Informações</h3>
                    <div class="text-sm text-gray-600 space-y-1">
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
        <div class="flex justify-between items-center mt-8 pt-6 border-t">
            <div class="flex space-x-3">
                <a href="{{ route('admin.administrativo.news.index') }}" 
                   class="text-gray-600 hover:text-gray-800 font-medium">
                    Cancelar
                </a>
                
                <a href="{{ route('admin.administrativo.news.show', $news) }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    Visualizar
                </a>
            </div>
            
            <div class="flex space-x-3">
                <button type="submit" name="action" value="draft" 
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    Salvar como Rascunho
                </button>
                <button type="submit" name="action" value="publish" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
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
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
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
