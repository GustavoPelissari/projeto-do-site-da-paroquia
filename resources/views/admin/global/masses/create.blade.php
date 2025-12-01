@extends('admin.layout')

@section('title', 'Novo Horário de Missa')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Novo Horário de Missa</h1>
        <a href="{{ route('admin.global.masses.index') }}" class="btn btn-link">← Voltar</a>
    </div>

    @if ($errors->any())
        <x-alert type="error"> <strong>Verifique os erros abaixo:</strong>
            <ul class="mb-0 list-disc list-inside text-sm"> @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form method="POST" action="{{ route('admin.global.masses.store') }}">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
                        </div>
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
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control" required>
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
            <a href="{{ route('admin.global.masses.index') }}" class="btn btn-link">Cancelar</a>
            <button type="submit" class="btn btn-primary">Criar Horário</button>
        </div>
    </form>
</div>
@endsection