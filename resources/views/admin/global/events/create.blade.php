@extends('admin.layout')

@section('title', 'Novo Evento')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Novo Evento</h1>
        <a href="{{ route('admin.global.events.index') }}" class="btn btn-link">← Voltar</a>
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

    <form method="POST" action="{{ route('admin.global.events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Título do Evento *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição *</label>
                            <textarea name="description" id="description" rows="8" class="form-control" required>{{ old('description') }}</textarea>
                            <div class="form-text">Descreva o evento, programação e informações importantes.</div>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Data e Hora de Início *</label>
                                <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Data e Hora de Término</label>
                                <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-control">
                                <div class="form-text">Opcional - deixe vazio se não tiver hora específica</div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="location" class="form-label">Local do Evento</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control" placeholder="Ex: Igreja Principal, Salão Paroquial, etc.">
                        </div>
                        <div class="mt-3">
                            <label for="requirements" class="form-label">Requisitos ou Observações</label>
                            <textarea name="requirements" id="requirements" rows="3" class="form-control" placeholder="Ex: Trazer documento, idade mínima, etc.">{{ old('requirements') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Opções do Evento</h6>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                                <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label for="max_participants" class="form-label">Máximo de Participantes</label>
                            <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants') }}" min="1" class="form-control">
                            <div class="form-text">Deixe vazio para eventos sem limite</div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Imagem do Evento</h6>
                        <input type="file" name="image" id="image" accept="image/*" class="form-control">
                        <div id="image-preview" class="mt-3 d-none">
                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded">
                        </div>
                        <div class="form-text">Formatos: JPG, PNG, GIF (máx. 2MB)</div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Categoria</h6>
                        <div class="vstack gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_liturgy" value="liturgy" {{ old('category', 'liturgy') === 'liturgy' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_liturgy">Liturgia</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_formation" value="formation" {{ old('category') === 'formation' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_formation">Formação</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_social" value="social" {{ old('category') === 'social' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_social">Social</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_youth" value="youth" {{ old('category') === 'youth' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_youth">Juventude</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_family" value="family" {{ old('category') === 'family' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_family">Família</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="cat_other" value="other" {{ old('category') === 'other' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat_other">Outros</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.global.events.index') }}" class="btn btn-link">Cancelar</a>
            <div class="d-flex gap-2">
                <button type="submit" name="action" value="draft" class="btn btn-secondary">Salvar como Rascunho</button>
                <button type="submit" name="action" value="publish" class="btn btn-success">Criar Evento</button>
            </div>
        </div>
    </form>

    <script>
    document.getElementById('image').addEventListener('change', function() {
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

    document.getElementById('start_date').addEventListener('change', function() {
        const startDate = new Date(this.value);
        const endDateField = document.getElementById('end_date');
        if (!endDateField.value && this.value) {
            startDate.setHours(startDate.getHours() + 2);
            const endDateString = startDate.toISOString().slice(0, 16);
            endDateField.value = endDateString;
        }
    });
    </script>
</div>
@endsection
