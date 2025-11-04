@extends('admin.layout')

@section('title', 'Editar: ' . $news->title)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Editar Notícia</h1>
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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.global.news.update', $news) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Conteúdo *</label>
                            <textarea name="content" id="content" rows="12" class="form-control" required>{{ old('content', $news->content) }}</textarea>
                            <div class="form-text">Use quebras de linha para separar parágrafos.</div>
                        </div>
                        <div class="mb-3">
                            <label for="summary" class="form-label">Resumo</label>
                            <textarea name="summary" id="summary" rows="3" class="form-control" placeholder="Breve resumo (opcional)">{{ old('summary', $news->summary) }}</textarea>
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
                                <option value="draft" {{ old('status', $news->status) === 'draft' ? 'selected' : '' }}>Rascunho</option>
                                <option value="published" {{ old('status', $news->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                            </select>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" {{ old('featured', $news->featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">Destacar na página inicial</label>
                        </div>
                        <div class="mb-0">
                            <label for="published_at" class="form-label">Data de Publicação</label>
                            <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}" class="form-control">
                            <div class="form-text">Deixe vazio para usar a data atual</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Imagem de Destaque</h6>
                        @if($news->featured_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($news->featured_image) }}" alt="Imagem atual" class="img-fluid rounded">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                                    <label class="form-check-label text-danger" for="remove_image">Remover imagem atual</label>
                                </div>
                            </div>
                        @endif
                        <input type="file" name="featured_image" id="featured_image" accept="image/*" class="form-control">
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">SEO</h6>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Descrição</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-control" placeholder="Descrição para motores de busca">{{ old('meta_description', $news->meta_description) }}</textarea>
                        </div>
                        <div class="mb-0">
                            <label for="slug" class="form-label">URL Amigável</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $news->slug) }}" class="form-control" placeholder="url-da-noticia">
                            <div class="form-text">Será gerada automaticamente se permanecer vazio</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.global.news.index') }}" class="btn btn-link">Cancelar</a>
                <a href="{{ route('admin.global.news.show', $news) }}" class="btn btn-outline-secondary">Visualizar</a>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" name="action" value="draft" class="btn btn-secondary">Salvar como Rascunho</button>
                <button type="submit" name="action" value="publish" class="btn btn-primary">Atualizar e Publicar</button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('title').addEventListener('input', function() {
    const slugField = document.getElementById('slug');
    if (slugField.value === '') {
        const title = this.value;
        const slug = title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim('-');
        slugField.value = slug;
    }
});
</script>
@endsection
