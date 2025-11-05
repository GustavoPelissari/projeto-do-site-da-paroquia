@extends('admin.layout')

@section('title', 'Nova Notícia')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Nova Notícia</h1>
        <a href="{{ route('admin.global.news.index') }}" class="btn btn-link">← Voltar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.global.news.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Conteúdo *</label>
                            <textarea name="content" id="content" rows="12" class="form-control" required>{{ old('content') }}</textarea>
                            <div class="form-text">Use quebras de linha para separar parágrafos.</div>
                        </div>
                        <div class="mb-3">
                            <label for="summary" class="form-label">Resumo</label>
                            <textarea name="summary" id="summary" rows="3" class="form-control" placeholder="Breve resumo (opcional)">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Opções de Publicação</h6>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicar</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Destacar na página inicial</label>
                        </div>
                        <div class="mb-0">
                            <label for="published_at" class="form-label">Data de Publicação</label>
                            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" class="form-control">
                            <div class="form-text">Deixe vazio para publicar agora</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Imagem de Destaque</h6>
                        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="form-control mb-2">
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">SEO</h6>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Descrição</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Descrição para motores de busca">{{ old('meta_description') }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label for="slug" class="form-label">URL Amigável</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control" placeholder="url-da-noticia">
                            <div class="form-text">Será gerada automaticamente se permanecer vazio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.global.news.index') }}" class="btn btn-link">Cancelar</a>
            <div class="d-flex gap-2">
                <button type="submit" name="action" value="draft" class="btn btn-secondary">Salvar Rascunho</button>
                <button type="submit" name="action" value="publish" class="btn btn-primary">Publicar</button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim('-');
    document.getElementById('slug').value = slug;
});

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
        console.log('Imagem selecionada:', file.name, 'Tamanho:', file.size, 'bytes');
    }
});
</script>
@endsection
