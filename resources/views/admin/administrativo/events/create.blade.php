@extends('admin.layout')

@section('title', 'Novo Evento')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <h2 class="h2 fw-bold text-dark">Novo Evento</h2>
    <a href="{{ route('admin.administrativo.events.index') }}" class="text-primary hover-text-primary-dark">
        ← Voltar para Eventos
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

<form method="POST" action="{{ route('admin.administrativo.events.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="bg-white rounded shadow p-6">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-lg-8 d-flex flex-column gap-4">
                <!-- Title -->
                <div>
                    <label for="title" class="d-block small fw-medium text-dark mb-2">
                        Título do Evento *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="form-control"
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="d-block small fw-medium text-dark mb-2">
                        Descrição *
                    </label>
                    <textarea name="description" id="description" rows="8" 
                              class="form-control"
                              required>{{ old('description') }}</textarea>
                    <p class="small text-secondary mt-1">Descreva o evento, programação e informações importantes.</p>
                </div>

                <!-- Date and Time -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="start_date" class="d-block small fw-medium text-dark mb-2">
                            Data e Hora de Início *
                        </label>
                        <input type="datetime-local" name="start_date" id="start_date" 
                               value="{{ old('start_date') }}"
                               class="form-control"
                               required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="end_date" class="d-block small fw-medium text-dark mb-2">
                            Data e Hora de Término
                        </label>
                        <input type="datetime-local" name="end_date" id="end_date" 
                               value="{{ old('end_date') }}"
                               class="form-control">
                        <p class="small text-secondary mt-1">Opcional - deixe vazio se não tiver hora específica</p>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="d-block small fw-medium text-dark mb-2">
                        Local do Evento
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           class="form-control"
                           placeholder="Ex: Igreja Principal, Salão Paroquial, etc.">
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="d-block small fw-medium text-dark mb-2">
                        Requisitos ou Observações
                    </label>
                    <textarea name="requirements" id="requirements" rows="3" 
                              class="form-control"
                              placeholder="Ex: Trazer documento, idade mínima, etc.">{{ old('requirements') }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 d-flex flex-column gap-4">
                <!-- Event Options -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">Opções do Evento</h3>
                    
                    <div class="d-flex flex-column gap-3">
                        <!-- Status -->
                        <div>
                            <label for="status" class="d-block small fw-medium text-dark mb-2">
                                Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                                <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <!-- Max Participants -->
                        <div>
                            <label for="max_participants" class="d-block small fw-medium text-dark mb-2">
                                Máximo de Participantes
                            </label>
                            <input type="number" name="max_participants" id="max_participants" 
                                   value="{{ old('max_participants') }}" 
                                   min="1"
                                   class="form-control">
                            <p class="small text-secondary mt-1">Deixe vazio para eventos sem limite</p>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">Imagem do Evento</h3>
                    
                    <div>
                        <label for="image" class="d-block small fw-medium text-dark mb-2">
                            Escolher Imagem
                        </label>
                        <input type="file" name="image" id="image" 
                               accept="image/*"
                               class="form-control">
                        <p class="small text-secondary mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 d-none">
                        <img id="preview-img" src="" alt="Preview" class="w-100 rounded">
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-secondary-subtle rounded p-4">
                    <h3 class="fw-semibold text-dark mb-4">Categoria</h3>
                    
                    <div class="d-flex flex-column gap-2">
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="liturgy" 
                                   {{ old('category', 'liturgy') === 'liturgy' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Liturgia</span>
                        </label>
                        
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="formation" 
                                   {{ old('category') === 'formation' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Formação</span>
                        </label>
                        
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="social" 
                                   {{ old('category') === 'social' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Social</span>
                        </label>
                        
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="youth" 
                                   {{ old('category') === 'youth' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Juventude</span>
                        </label>
                        
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="family" 
                                   {{ old('category') === 'family' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Família</span>
                        </label>
                        
                        <label class="d-flex align-items-center">
                            <input type="radio" name="category" value="other" 
                                   {{ old('category') === 'other' ? 'checked' : '' }}
                                   class="form-check-input">
                            <span class="ms-2 small text-dark">Outros</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="d-flex justify-content-between align-items-center mt-8 pt-6 border-top">
            <a href="{{ route('admin.administrativo.events.index') }}" 
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
