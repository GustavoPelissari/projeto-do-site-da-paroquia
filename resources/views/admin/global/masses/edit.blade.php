@extends('admin.layout')

@section('title', 'Editar Horário de Missa')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Editar Horário</h1>
        <a href="{{ route('admin.global.masses.index') }}" class="btn btn-link">← Voltar</a>
    </div>

    @if ($errors->any())
        <x-alert type="danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form method="POST" action="{{ route('admin.global.masses.update', $mass) }}">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="day_of_week" class="form-label">Dia da Semana *</label>
                                <select name="day_of_week" id="day_of_week" class="form-select" required>
                                    @php $dow = old('day_of_week', $mass->day_of_week); @endphp
                                    <option value="sunday" {{ $dow==='sunday'?'selected':'' }}>Domingo</option>
                                    <option value="monday" {{ $dow==='monday'?'selected':'' }}>Segunda-feira</option>
                                    <option value="tuesday" {{ $dow==='tuesday'?'selected':'' }}>Terça-feira</option>
                                    <option value="wednesday" {{ $dow==='wednesday'?'selected':'' }}>Quarta-feira</option>
                                    <option value="thursday" {{ $dow==='thursday'?'selected':'' }}>Quinta-feira</option>
                                    <option value="friday" {{ $dow==='friday'?'selected':'' }}>Sexta-feira</option>
                                    <option value="saturday" {{ $dow==='saturday'?'selected':'' }}>Sábado</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="time" class="form-label">Hora *</label>
                                <input type="time" name="time" id="time" value="{{ old('time', $mass->time ? $mass->time->format('H:i') : '') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="location" class="form-label">Local *</r
                            ><input type="text" name="location" id="location" value="{{ old('location', $mass->location) }}" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $mass->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Opções</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', $mass->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Ativo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.global.masses.index') }}" class="btn btn-link">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>
@endsection
