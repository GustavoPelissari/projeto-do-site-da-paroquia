@extends('admin.layout')

@section('title', 'Editar Grupo')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Editar Grupo</h1>
        <a href="{{ route('admin.global.groups.show', $group) }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Verifique os erros abaixo:</div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.global.groups.update', $group) }}" enctype="multipart/form-data" class="card shadow-sm">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row g-3">
                <!-- Imagem/Logo -->
                <div class="col-12">
                    <label class="form-label">Logo do Grupo</label>
                    @if($group->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $group->image) }}" alt="Logo atual" class="img-thumbnail" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    Remover imagem atual
                                </label>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nome do Grupo <span class="text-danger">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $group->name) }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Categoria <span class="text-danger">*</span></label>
                    <select name="category" class="form-select" required>
                        <option value="liturgy" {{ old('category', $group->category)==='liturgy' ? 'selected' : '' }}>Liturgia</option>
                        <option value="pastoral" {{ old('category', $group->category)==='pastoral' ? 'selected' : '' }}>Pastoral</option>
                        <option value="service" {{ old('category', $group->category)==='service' ? 'selected' : '' }}>Serviço</option>
                        <option value="formation" {{ old('category', $group->category)==='formation' ? 'selected' : '' }}>Formação</option>
                        <option value="youth" {{ old('category', $group->category)==='youth' ? 'selected' : '' }}>Juventude</option>
                        <option value="family" {{ old('category', $group->category)==='family' ? 'selected' : '' }}>Família</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Descrição <span class="text-danger">*</span></label>
                    <textarea name="description" rows="5" class="form-control" required>{{ old('description', $group->description) }}</textarea>
                </div>

                <!-- Informações do Coordenador -->
                <div class="col-12">
                    <h6 class="border-bottom pb-2 mb-3">Informações do Coordenador</h6>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Nome do Coordenador</label>
                    <input type="text" name="coordinator_name" value="{{ old('coordinator_name', $group->coordinator_name) }}" class="form-control">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Telefone do Coordenador</label>
                    <input type="text" name="coordinator_phone" value="{{ old('coordinator_phone', $group->coordinator_phone) }}" class="form-control" placeholder="(00) 00000-0000">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">E-mail do Coordenador</label>
                    <input type="email" name="coordinator_email" value="{{ old('coordinator_email', $group->coordinator_email) }}" class="form-control">
                </div>

                <!-- Informações de Reunião -->
                <div class="col-12">
                    <label class="form-label">Informações de Reunião</label>
                    <textarea name="meeting_info" rows="2" class="form-control" placeholder="Ex: Todos os sábados às 14h na sala de reuniões">{{ old('meeting_info', $group->meeting_info) }}</textarea>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $group->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Ativo</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">Salvar alterações</button>
            <a href="{{ route('admin.global.groups.show', $group) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
