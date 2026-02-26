<x-app-layout>
    <x-slot name="header">
        <h2 class="h5 mb-0">
            {{ __('Nova Escala') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container-lg">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.schedules.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Seleção do Grupo -->
                        <div class="mb-4">
                            <label for="group_id" class="form-label">
                                Grupo/Pastoral *
                            </label>
                            <select name="group_id" id="group_id" required 
                                    class="form-select">
                                <option value="">Selecione um grupo...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group_id', $selectedGroupId) == $group->id ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('group_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Título -->
                        <div class="mb-4">
                            <label for="title" class="form-label">
                                Título da Escala *
                            </label>
                            <input type="text" name="title" id="title" required 
                                   value="{{ old('title') }}"
                                   placeholder="Ex: Escala de Coroinhas - Novembro 2025"
                                   class="form-control">
                            @error('title')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Período -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">
                                    Data de Início *
                                </label>
                                <input type="date" name="start_date" id="start_date" required 
                                       value="{{ old('start_date') }}"
                                       class="form-control">
                                @error('start_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="end_date" class="form-label">
                                    Data de Fim *
                                </label>
                                <input type="date" name="end_date" id="end_date" required 
                                       value="{{ old('end_date') }}"
                                       class="form-control">
                                @error('end_date')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                Descrição (opcional)
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      placeholder="Informações adicionais sobre a escala..."
                                      class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload do PDF -->
                        <div class="mb-4">
                            <label for="pdf_file" class="form-label">
                                Arquivo PDF da Escala *
                            </label>
                            <div class="border rounded p-4" style="border-style: dashed;">
                                <div class="text-center">
                                    <i class="bi bi-cloud-arrow-up text-muted fs-1" aria-hidden="true"></i>
                                    <div class="d-flex justify-content-center align-items-center gap-2 mt-2">
                                        <label for="pdf_file" class="btn btn-outline-primary btn-sm">
                                            Escolher arquivo PDF
                                            <input id="pdf_file" name="pdf_file" type="file" accept=".pdf" required class="visually-hidden" data-file-input>
                                        </label>
                                        <span class="text-muted small">ou arraste e solte</span>
                                    </div>
                                    <p class="text-muted small mt-2 mb-0">PDF até 10MB</p>
                                    <p id="file-name" class="small text-success mt-2 mb-0 d-none"></p>
                                </div>
                            </div>
                            @error('pdf_file')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Informações importantes -->
                        <div class="alert alert-info mb-4">
                            <h4 class="h6 fw-semibold mb-2">ℹ️ Informações Importantes</h4>
                            <ul class="small mb-0">
                                <li>O arquivo PDF será o documento oficial da escala</li>
                                <li>Todos os membros do grupo serão notificados automaticamente</li>
                                <li>Apenas os 5 PDFs mais recentes são mantidos (os antigos são removidos automaticamente)</li>
                                <li>O arquivo deve estar em formato PDF e ter no máximo 10MB</li>
                            </ul>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.schedules.index') }}" 
                               class="btn btn-outline-secondary">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="btn btn-primary">
                                Criar Escala
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>