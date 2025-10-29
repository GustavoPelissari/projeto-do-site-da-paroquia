@extends('admin.layout')

@section('title', 'Editar: ' . $news->title)

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Editar Notícia</h2>
    <a href="{{ route('admin.global.news.index') }}" class="text-blue-600 hover:text-blue-800">
        ← Voltar para Notícias
    </a>
</div>

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

<form method="POST" action="{{ route('admin.global.news.update', $news) }}" enctype="multipart/form-data">
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
                <a href="{{ route('admin.global.news.index') }}" 
                   class="text-gray-600 hover:text-gray-800 font-medium">
                    Cancelar
                </a>
                
                <a href="{{ route('admin.global.news.show', $news) }}" 
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
