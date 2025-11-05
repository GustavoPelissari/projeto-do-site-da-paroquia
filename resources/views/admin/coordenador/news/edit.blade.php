@extends('admin.layout')

@section('title', 'Editar Notícia - Coordenador')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 15px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h2 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-pencil-square"></i> Editar Notícia
                    </h1>
                    <p class="mb-0" style="color: #FFD66B;">{{ $news->title }}</p>
                </div>
                <a href="{{ route('admin.coordenador.news.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="bi bi-exclamation-triangle"></i> Erro ao salvar</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.coordenador.news.update', $news) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
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
                                   value="{{ old('title', $news->title) }}" 
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
                                      required>{{ old('content', $news->content) }}</textarea>
                            <small class="text-muted">Use quebras de linha para separar parágrafos.</small>
                        </div>

                        <div class="mb-0">
                            <label for="excerpt" class="form-label fw-semibold">
                                <i class="bi bi-bookmark"></i> Resumo (Opcional)
                            </label>
                            <textarea name="excerpt" 
                                      id="excerpt" 
                                      rows="3" 
                                      class="form-control" 
                                      placeholder="Breve resumo que aparecerá na listagem de notícias">{{ old('excerpt', $news->excerpt) }}</textarea>
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
                        <div class="mb-0">
                            <label for="status" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on"></i> Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>
                                    📝 Rascunho (não visível)
                                </option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>
                                    ✅ Publicar (visível no site)
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Imagem de Destaque -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-white py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-image"></i> Imagem de Destaque</h6>
                    </div>
                    <div class="card-body">
                        @if($news->featured_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                     alt="Imagem atual" 
                                     class="img-fluid rounded mb-2"
                                     style="max-height: 200px; object-fit: cover;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                                    <label class="form-check-label text-danger" for="remove_image">
                                        <i class="bi bi-trash"></i> Remover imagem atual
                                    </label>
                                </div>
                            </div>
                        @endif
                        
                        <input type="file" 
                               name="featured_image" 
                               id="featured_image" 
                               accept="image/*" 
                               class="form-control">
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Formatos: JPG, PNG, WebP (máx. 2MB)
                        </small>
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <!-- Info sobre TAG -->
                <div class="alert alert-info" role="alert">
                    <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informação</h6>
                    <p class="mb-0 small">
                        <strong>Criado por:</strong> {{ $news->user->name ?? 'Desconhecido' }}<br>
                        <strong>Data:</strong> {{ $news->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
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
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle"></i> Salvar Alterações
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Preview da imagem
document.getElementById('featured_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection
