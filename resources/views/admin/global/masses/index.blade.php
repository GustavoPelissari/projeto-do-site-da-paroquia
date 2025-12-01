@extends('admin.layout')

@section('title', 'Gerenciar Horários de Missa')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Horários de Missa</h1>
        <a href="{{ route('admin.global.masses.create') }}" class="btn btn-primary">Novo Horário</a>
    </div>

    @if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="day_of_week" class="form-label">Dia da Semana</label>
                        <select name="day_of_week" id="day_of_week" class="form-select">
                            <option value="">Todos</option>
                            <option value="sunday" {{ request('day_of_week') === 'sunday' ? 'selected' : '' }}>Domingo</option>
                            <option value="monday" {{ request('day_of_week') === 'monday' ? 'selected' : '' }}>Segunda-feira</option>
                            <option value="tuesday" {{ request('day_of_week') === 'tuesday' ? 'selected' : '' }}>Terça-feira</option>
                            <option value="wednesday" {{ request('day_of_week') === 'wednesday' ? 'selected' : '' }}>Quarta-feira</option>
                            <option value="thursday" {{ request('day_of_week') === 'thursday' ? 'selected' : '' }}>Quinta-feira</option>
                            <option value="friday" {{ request('day_of_week') === 'friday' ? 'selected' : '' }}>Sexta-feira</option>
                            <option value="saturday" {{ request('day_of_week') === 'saturday' ? 'selected' : '' }}>Sábado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nome, local ou descrição..." class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">Filtrar</button>
                    </div>
                </div>
            </form>

            @if($masses->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Dia da Semana</th>
                                <th>Horário</th>
                                <th>Local</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masses as $mass)
                            <tr>
                                <td class="fw-semibold">{{ $mass->day_name }}</td>
                                <td>{{ $mass->time->format('H:i') }}</td>
                                <td>{{ $mass->location }}</td>
                                <td>
                                    @if($mass->description)
                                        <div class="text-muted small">{{ Str::limit($mass->description, 50) }}</div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $mass->is_active ? 'bg-success' : 'bg-danger' }}">{{ $mass->is_active ? 'Ativo' : 'Inativo' }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.global.masses.show', $mass) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                        <a href="{{ route('admin.global.masses.edit', $mass) }}" class="btn btn-sm btn-outline-success">Editar</a>
                                        <form method="POST" action="{{ route('admin.global.masses.destroy', $mass) }}" onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $masses->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="display-6 text-muted mb-2">⛪</div>
                    <h2 class="h6">Nenhum horário encontrado</h2>
                    <p class="text-muted">Comece criando o primeiro horário de missa.</p>
                    <a href="{{ route('admin.global.masses.create') }}" class="btn btn-primary">Criar Primeiro Horário</a>
                </div>
            @endif
        </div>
    </div>

    @if($masses->count() > 0)
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h6 mb-3">Cronograma Semanal</h2>
            <div class="row g-3">
                @php
                    $days = [
                        'sunday' => 'Domingo',
                        'monday' => 'Segunda',
                        'tuesday' => 'Terça',
                        'wednesday' => 'Quarta',
                        'thursday' => 'Quinta',
                        'friday' => 'Sexta',
                        'saturday' => 'Sábado'
                    ];
                    $massesByDay = $masses->groupBy('day_of_week');
                @endphp
                @foreach($days as $dayKey => $dayName)
                    <div class="col-12 col-md-6 col-lg-3 col-xxl-2">
                        <div class="border rounded p-3 h-100">
                            <div class="fw-semibold mb-2">{{ $dayName }}</div>
                            @if(isset($massesByDay[$dayKey]))
                                @foreach($massesByDay[$dayKey] as $mass)
                                    <div class="text-muted small mb-1">
                                        <div class="fw-semibold">{{ $mass->time->format('H:i') }}</div>
                                        <div class="text-muted">{{ $mass->name }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-muted small">Nenhuma missa</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
