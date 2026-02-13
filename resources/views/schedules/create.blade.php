<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Escala') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm-px-6 lg-px-8">
            <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                <div class="p-6 bg-white border-bottom border-gray-200">
                    <form method="POST" action="{{ route('admin.schedules.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Seleção do Grupo -->
                        <div class="mb-6">
                            <label for="group_id" class="d-block text-sm font-medium text-gray-700 mb-2">
                                Grupo/Pastoral *
                            </label>
                            <select name="group_id" id="group_id" required 
                                    class="d-block w-full rounded-md border-gray-300 shadow-sm form-select focus-border-indigo-500 focus-ring-indigo-500">
                                <option value="">Selecione um grupo...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id', $selectedGroupId) == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Título -->
                        <div class="mb-6">
                            <label for="title" class="d-block text-sm font-medium text-gray-700 mb-2">
                                Título da Escala *
                            </label>
                            <input type="text" name="title" id="title" required 
                                   value="{{ old('title') }}"
                                   placeholder="Ex: Escala de Coroinhas - Novembro 2025"
                                   class="d-block w-full rounded-md border-gray-300 shadow-sm form-control focus-border-indigo-500 focus-ring-indigo-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Período -->
                        <div class="row g-3 mb-6">
                            <div class="col-md-6">
                                <label for="start_date" class="d-block text-sm font-medium text-gray-700 mb-2">
                                    Data de Início *
                                </label>
                                <input type="date" name="start_date" id="start_date" required 
                                       value="{{ old('start_date') }}"
                                       class="d-block w-full rounded-md border-gray-300 shadow-sm form-control focus-border-indigo-500 focus-ring-indigo-500">
                                @error('start_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="d-block text-sm font-medium text-gray-700 mb-2">
                                    Data de Fim *
                                </label>
                                <input type="date" name="end_date" id="end_date" required 
                                       value="{{ old('end_date') }}"
                                       class="d-block w-full rounded-md border-gray-300 shadow-sm form-control focus-border-indigo-500 focus-ring-indigo-500">
                                @error('end_date')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-6">
                            <label for="description" class="d-block text-sm font-medium text-gray-700 mb-2">
                                Descrição (opcional)
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      placeholder="Informações adicionais sobre a escala..."
                                      class="d-block w-full rounded-md border-gray-300 shadow-sm form-control focus-border-indigo-500 focus-ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload do PDF -->
                        <div class="mb-6">
                            <label for="pdf_file" class="d-block text-sm font-medium text-gray-700 mb-2">
                                Arquivo PDF da Escala *
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="d-flex justify-content-center text-sm text-gray-600">
                                        <label for="pdf_file" class="position-relative bg-white rounded-md font-medium text-indigo-600 hover-text-indigo-500" style="cursor: pointer;">
                                            <span>Escolher arquivo PDF</span>
                                            <input id="pdf_file" name="pdf_file" type="file" accept=".pdf" required class="sr-only" onchange="updateFileName(this)">
                                        </label>
                                        <p class="ps-1">ou arraste e solte</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">PDF até 10MB</p>
                                    <p id="file-name" class="text-sm text-green-600 mt-2 hidden"></p>
                                </div>
                            </div>
                            @error('pdf_file')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informações importantes -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-900 mb-2"> Informações Importantes</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• O arquivo PDF será o documento oficial da escala</li>
                                <li>• Todos os membros do grupo serão notificados automaticamente</li>
                                <li>• Apenas os 5 PDFs mais recentes são mantidos (os antigos são removidos automaticamente)</li>
                                <li>• O arquivo deve estar em formato PDF e ter no máximo 10MB</li>
                            </ul>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-end gap-3">
                            <a href="{{ route('admin.schedules.index') }}" 
                               class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover-bg-gray-400">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded hover-bg-blue-700">
                                Criar Escala
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = `Arquivo selecionado: ${input.files[0].name}`;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        }

        // Auto-preencher datas
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDate = document.getElementById('end_date');
            
            if (!endDate.value) {
                // Sugerir fim do mês
                const endOfMonth = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
                endDate.value = endOfMonth.toISOString().split('T')[0];
            }
        });
    </script>
</x-app-layout>