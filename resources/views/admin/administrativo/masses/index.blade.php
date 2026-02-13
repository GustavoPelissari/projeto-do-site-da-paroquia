@extends('admin.layout')

@section('title', 'Horários de missa')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Área administrativa</p>
        <h2 class="h3 mb-0">Horários de missa</h2>
    </div>
</div>

<div class="card mb-4"><div class="card-body">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-3">
            <label class="form-label" for="day">Dia</label>
            <select id="day" name="day" class="form-select">
                <option value="">Todos</option>
                <option value="sunday" {{ request('day') === 'sunday' ? 'selected' : '' }}>Domingo</option>
                <option value="monday" {{ request('day') === 'monday' ? 'selected' : '' }}>Segunda</option>
                <option value="tuesday" {{ request('day') === 'tuesday' ? 'selected' : '' }}>Terça</option>
                <option value="wednesday" {{ request('day') === 'wednesday' ? 'selected' : '' }}>Quarta</option>
                <option value="thursday" {{ request('day') === 'thursday' ? 'selected' : '' }}>Quinta</option>
                <option value="friday" {{ request('day') === 'friday' ? 'selected' : '' }}>Sexta</option>
                <option value="saturday" {{ request('day') === 'saturday' ? 'selected' : '' }}>Sábado</option>
            </select>
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-select">
                <option value="">Todos</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativo</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
        <div class="col-12 col-md-4">
            <label class="form-label" for="search">Buscar</label>
            <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nome ou local">
        </div>
        <div class="col-12 col-md-2 d-grid">
            <button type="submit" class="btn btn-outline-primary">Filtrar</button>
        </div>
    </form>
</div></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Lista de horários</h3>
        <small class="text-secondary">{{ $masses->total() }} registro(s)</small>
    </div>
    <div class="card-body p-0">
        @if($masses->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Dia</th>
                            <th>Horário</th>
                            <th>Local</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masses as $mass)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $mass->name }}</div>
                                    <small class="text-secondary">{{ Str::limit($mass->description ?: 'Sem descrição', 80) }}</small>
                                </td>
                                <td>{{ $mass->day_name }}</td>
                                <td>{{ $mass->time ? \Carbon\Carbon::parse($mass->time)->format('H:i') : '—' }}</td>
                                <td>{{ $mass->location }}</td>
                                <td><span class="badge {{ $mass->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $mass->is_active ? 'Ativo' : 'Inativo' }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('admin.administrativo.masses.show', $mass) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhum horário de missa encontrado.</div>
        @endif
    </div>
</div>

@if($masses->hasPages())
    <div class="mt-4">{{ $masses->withQueryString()->links() }}</div>
@endif
@endsection
