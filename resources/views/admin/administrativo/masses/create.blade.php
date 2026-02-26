@extends('admin.layout')

@section('title', 'Novo Horário de Missa')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Novo Horário de Missa</h1>
        <a href="{{ route('admin.administrativo.masses.index') }}" class="btn btn-link">← Voltar</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Verifique os erros abaixo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.administrativo.masses.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="day_of_week" class="form-label">Dia da Semana *</label>
                                <select name="day_of_week" id="day_of_week" class="form-select" required>
                                    <option value="">Selecione</option>
                                    <option value="sunday" {{ old('day_of_week')==='sunday'?'selected':'' }}>Domingo</option>
                                    <option value="monday" {{ old('day_of_week')==='monday'?'selected':'' }}>Segunda-feira</option>
                                    <option value="tuesday" {{ old('day_of_week')==='tuesday'?'selected':'' }}>Terça-feira</option>
                                    <option value="wednesday" {{ old('day_of_week')==='wednesday'?'selected':'' }}>Quarta-feira</option>
                                    <option value="thursday" {{ old('day_of_week')==='thursday'?'selected':'' }}>Quinta-feira</option>
                                    <option value="friday" {{ old('day_of_week')==='friday'?'selected':'' }}>Sexta-feira</option>
                                    <option value="saturday" {{ old('day_of_week')==='saturday'?'selected':'' }}>Sábado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Hora *</label>
                                <input type="time" name="time" id="time" value="{{ old('time') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="location" class="form-label">Local *</label>
                            <select name="location" id="location" class="form-select" required>
                                <option value="">Selecione o local</option>
                                <option value="Paróquia São Paulo Apóstolo" {{ old('location') === 'Paróquia São Paulo Apóstolo' ? 'selected' : '' }}>Paróquia São Paulo Apóstolo</option>
                                <option value="Capela Santo Antônio" {{ old('location') === 'Capela Santo Antônio' ? 'selected' : '' }}>Capela Santo Antônio</option>
                                <option value="Capela Nossa Senhora de Fátima" {{ old('location') === 'Capela Nossa Senhora de Fátima' ? 'selected' : '' }}>Capela Nossa Senhora de Fátima</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Opcional">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Opções</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Ativo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.administrativo.masses.index') }}" class="btn btn-link">Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i>Criar Horário</button>
        </div>
    </form>
</div>
@endsection
