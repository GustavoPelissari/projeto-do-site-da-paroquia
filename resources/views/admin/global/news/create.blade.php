@extends('admin.layout')

@section('title', 'Nova Notícia')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Nova Notícia</h2>
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

<form method="POST" action="{{ route('admin.global.news.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
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
                              required>{{ old('content') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Use quebras de linha para separar parágrafos.</p>
                </div>

                <!-- Summary -->
                <div>
                    <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                        Resumo
                    </label>
                    <textarea name="summary" id="summary" rows="3" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Breve resumo da notícia (opcional)">{{ old('summary') }}</textarea>
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
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicar</option>
                            </select>
                        </div>

                        <!-- Featured -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" 
                                       {{ old('featured') ? 'checked' : '' }}
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
                                   value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Deixe vazio para publicar agora</p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Imagem de Destaque</h3>
                    
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Escolher Imagem
                        </label>
                        <input type="file" name="featured_image" id="featured_image" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 hidden">
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
                                      placeholder="Descrição para motores de busca">{{ old('meta_description') }}</textarea>
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                                URL Amigável
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2"
                                   placeholder="url-da-noticia">
                            <p class="text-xs text-gray-500 mt-1">Será gerada automaticamente se vazio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center mt-8 pt-6 border-t">
            <a href="{{ route('admin.global.news.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                Cancelar
            </a>
            
            <div class="flex space-x-3">
                <button type="submit" name="action" value="draft" 
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    Salvar Rascunho
                </button>
                <button type="submit" name="action" value="publish" 
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Publicar
                </button>
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
