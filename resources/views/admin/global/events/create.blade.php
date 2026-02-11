@extends('admin.layout')

@section('title', 'Novo Evento')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold text-dark">Novo Evento</h2>
    <a href="{{ route('admin.global.events.index') }}" class="text-primary hover-text-primary-dark">
        ← Voltar para Eventos
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

<form method="POST" action="{{ route('admin.global.events.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="card shadow"><div class="card-body">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-12 col-lg-8 d-flex flex-column gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="form-label fw-medium">
                        Título do Evento *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="form-control focus-ring-2"
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="form-label fw-medium">
                        Descrição *
                    </label>
                    <textarea name="description" id="description" rows="8" 
                              class="form-control focus-ring-2"
                              required>{{ old('description') }}</textarea>
                    <p class="form-text">Descreva o evento, programação e informações importantes.</p>
                </div>

                <!-- Date and Time -->
                <div class="row g-3">
                    <div>
                        <label for="start_date" class="form-label fw-medium">
                            Data e Hora de Início *
                        </label>
                        <input type="datetime-local" name="start_date" id="start_date" 
                               value="{{ old('start_date') }}"
                               class="form-control focus-ring-2"
                               required>
                    </div>
                    
                    <div>
                        <label for="end_date" class="form-label fw-medium">
                            Data e Hora de Término
                        </label>
                        <input type="datetime-local" name="end_date" id="end_date" 
                               value="{{ old('end_date') }}"
                               class="form-control focus-ring-2">
                        <p class="form-text">Opcional - deixe vazio se não tiver hora específica</p>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="form-label fw-medium">
                        Local do Evento
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           class="form-control focus-ring-2"
                           placeholder="Ex: Igreja Principal, Salão Paroquial, etc.">
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="form-label fw-medium">
                        Requisitos ou Observações
                    </label>
                    <textarea name="requirements" id="requirements" rows="3" 
                              class="form-control focus-ring-2"
                              placeholder="Ex: Trazer documento, idade mínima, etc.">{{ old('requirements') }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                <!-- Event Options -->
                <div class="bg-secondary-subtle rounded p-3">
                    <h3 class="fw-semibold text-dark mb-3">Opções do Evento</h3>
                    
                    <div class="d-flex flex-column gap-3">
                        <!-- Status -->
                        <div>
                            <label for="status" class="form-label fw-medium">
                                Status
                            </label>
                            <select name="status" id="status" class="form-control">
                                <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                                <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <!-- Max Participants -->
                        <div>
                            <label for="max_participants" class="form-label fw-medium">
                                Máximo de Participantes
                            </label>
                            <input type="number" name="max_participants" id="max_participants" 
                                   value="{{ old('max_participants') }}" 
                                   min="1"
                                   class="form-control">
                            <p class="form-text">Deixe vazio para eventos sem limite</p>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="bg-secondary-subtle rounded p-3">
                    <h3 class="fw-semibold text-dark mb-3">Imagem do Evento</h3>
                    
                    <div>
                        <label for="image" class="form-label fw-medium">
                            Escolher Imagem
                        </label>
                        <input type="file" name="image" id="image" 
                               accept="image/*"
                               class="form-control">
                        <p class="form-text">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-3 d-none">
                        <img id="preview-img" src="" alt="Preview" class="w-100 rounded">
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-secondary-subtle rounded p-3">
                    <h3 class="fw-semibold text-dark mb-3">Categoria</h3>
                    
                    <div class="d-flex flex-column gap-2">
                        <label class="form-check">
                            <input type="radio" name="category" value="liturgy" 
                                   {{ old('category', 'liturgy') === 'liturgy' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Liturgia</span>
                        </label>
                        
                        <label class="form-check">
                            <input type="radio" name="category" value="formation" 
                                   {{ old('category') === 'formation' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Formação</span>
                        </label>
                        
                        <label class="form-check">
                            <input type="radio" name="category" value="social" 
                                   {{ old('category') === 'social' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Social</span>
                        </label>
                        
                        <label class="form-check">
                            <input type="radio" name="category" value="youth" 
                                   {{ old('category') === 'youth' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Juventude</span>
                        </label>
                        
                        <label class="form-check">
                            <input type="radio" name="category" value="family" 
                                   {{ old('category') === 'family' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Família</span>
                        </label>
                        
                        <label class="form-check">
                            <input type="radio" name="category" value="other" 
                                   {{ old('category') === 'other' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="form-check-label">Outros</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
            <a href="{{ route('admin.global.events.index') }}" 
               class="text-secondary hover-text-dark fw-medium">
                Cancelar
            </a>
            
            <div class="d-flex gap-3">
                <button type="submit" name="action" value="draft" 
                        class="btn btn-secondary px-4 py-2">
                    Salvar como Rascunho
                </button>
                <button type="submit" name="action" value="publish" 
                        class="btn btn-success px-4 py-2">
                    Criar Evento
                </button>
            </div>
        </div>
        </div>
    </div>
</form>

<script>
// Image preview
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

// Auto-set end date
document.getElementById('start_date').addEventListener('change', function() {
    const startDate = new Date(this.value);
    const endDateField = document.getElementById('end_date');
    
    if (!endDateField.value && this.value) {
        // Add 2 hours to start date as default end date
        startDate.setHours(startDate.getHours() + 2);
        const endDateString = startDate.toISOString().slice(0, 16);
        endDateField.value = endDateString;
    }
});
</script>
@endsection
