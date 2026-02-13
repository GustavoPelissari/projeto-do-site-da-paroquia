@extends('admin.layout')

@section('title', 'Detalhes da missa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="admin-overline mb-1">Área administrativa</p>
        <h2 class="h3 mb-0">Detalhes da missa</h2>
    </div>
    <a href="{{ route('admin.administrativo.masses.index') }}" class="btn btn-outline-primary">Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Nome</dt>
            <dd class="col-sm-9">{{ $mass->name }}</dd>

            <dt class="col-sm-3">Dia</dt>
            <dd class="col-sm-9">{{ $mass->day_name }}</dd>

            <dt class="col-sm-3">Horário</dt>
            <dd class="col-sm-9">{{ $mass->time ? \Carbon\Carbon::parse($mass->time)->format('H:i') : '—' }}</dd>

            <dt class="col-sm-3">Local</dt>
            <dd class="col-sm-9">{{ $mass->location }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">
                <span class="badge {{ $mass->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">
                    {{ $mass->is_active ? 'Ativo' : 'Inativo' }}
                </span>
            </dd>

            <dt class="col-sm-3">Descrição</dt>
            <dd class="col-sm-9">{{ $mass->description ?: 'Sem descrição.' }}</dd>
        </dl>
    </div>
</div>
@endsection
