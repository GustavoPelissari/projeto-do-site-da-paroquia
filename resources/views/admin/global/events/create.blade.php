@extends('admin.layout')

@section('title', 'Novo Evento')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Novo Evento</h2>
    <a href="{{ route('admin.global.events.index') }}" class="text-blue-600 hover:text-blue-800">
        ← Voltar para Eventos
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

<form method="POST" action="{{ route('admin.global.events.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Título do Evento *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           required>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Descrição *
                    </label>
                    <textarea name="description" id="description" rows="8" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              required>{{ old('description') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Descreva o evento, programação e informações importantes.</p>
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Data e Hora de Início *
                        </label>
                        <input type="datetime-local" name="start_date" id="start_date" 
                               value="{{ old('start_date') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               required>
                    </div>
                    
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Data e Hora de Término
                        </label>
                        <input type="datetime-local" name="end_date" id="end_date" 
                               value="{{ old('end_date') }}"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <p class="text-xs text-gray-500 mt-1">Opcional - deixe vazio se não tiver hora específica</p>
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                        Local do Evento
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                           placeholder="Ex: Igreja Principal, Salão Paroquial, etc.">
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-2">
                        Requisitos ou Observações
                    </label>
                    <textarea name="requirements" id="requirements" rows="3" 
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Ex: Trazer documento, idade mínima, etc.">{{ old('requirements') }}</textarea>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Event Options -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Opções do Evento</h3>
                    
                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                                <option value="confirmed" {{ old('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <!-- Max Participants -->
                        <div>
                            <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">
                                Máximo de Participantes
                            </label>
                            <input type="number" name="max_participants" id="max_participants" 
                                   value="{{ old('max_participants') }}" 
                                   min="1"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <p class="text-xs text-gray-500 mt-1">Deixe vazio para eventos sem limite</p>
                        </div>
                    </div>
                </div>

                <!-- Event Image -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Imagem do Evento</h3>
                    
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Escolher Imagem
                        </label>
                        <input type="file" name="image" id="image" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <p class="text-xs text-gray-500 mt-1">Formatos: JPG, PNG, GIF (máx. 2MB)</p>
                    </div>

                    <!-- Image Preview -->
                    <div id="image-preview" class="mt-4 hidden">
                        <img id="preview-img" src="" alt="Preview" class="w-full rounded-md">
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-900 mb-4">Categoria</h3>
                    
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="category" value="liturgy" 
                                   {{ old('category', 'liturgy') === 'liturgy' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Liturgia</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="category" value="formation" 
                                   {{ old('category') === 'formation' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Formação</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="category" value="social" 
                                   {{ old('category') === 'social' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Social</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="category" value="youth" 
                                   {{ old('category') === 'youth' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Juventude</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="category" value="family" 
                                   {{ old('category') === 'family' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Família</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="radio" name="category" value="other" 
                                   {{ old('category') === 'other' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-700">Outros</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between items-center mt-8 pt-6 border-t">
            <a href="{{ route('admin.global.events.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                Cancelar
            </a>
            
            <div class="flex space-x-3">
                <button type="submit" name="action" value="draft" 
                        class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                    Salvar como Rascunho
                </button>
                <button type="submit" name="action" value="publish" 
                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
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
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
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
