@extends('admin.layout')

@section('title', 'Gerenciar Horários de Missa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h2 fw-bold text-dark">Horários de Missa</h2>
    <a href="{{ route('admin.global.masses.create') }}" class="btn btn-primary px-4 py-2">
        Novo Horário
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow">
    <div class="card-body">
        <!-- Filters -->
        <form method="GET" class="mb-4">
            <div class="row g-3">
                <div>
                    <label for="day_of_week" class="form-label">Dia da Semana</label>
                    <select name="day_of_week" id="day_of_week" class="form-control">
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
                <div>
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="form-label">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nome, local ou descrição..." 
                           class="form-control">
                </div>
                <div class="col-12 col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Masses Table -->
        @if($masses->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-light">
                            <th class="text-start">Nome</th>
                            <th class="text-start">Dia da Semana</th>
                            <th class="text-start">Horário</th>
                            <th class="text-start">Local</th>
                            <th class="text-start">Status</th>
                            <th class="text-start">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masses as $mass)
                        <tr class="">
                            <td class="py-3">
                                <div>
                                    <h4 class="fw-medium text-dark">{{ $mass->name }}</h4>
                                    @if($mass->description)
                                        <p class="text-muted small">{{ Str::limit($mass->description, 50) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 text-body">{{ $mass->day_name }}</td>
                            <td class="py-3 text-body">{{ $mass->time->format('H:i') }}</td>
                            <td class="py-3 text-body">{{ $mass->location }}</td>
                            <td class="py-3">
                                <span class="badge {{ $mass->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}">
                                    {{ $mass->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="admin-table-actions">
                                    <a href="{{ route('admin.global.masses.show', $mass) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                    <a href="{{ route('admin.global.masses.edit', $mass) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form method="POST" action="{{ route('admin.global.masses.destroy', $mass) }}" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
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

            <!-- Pagination -->
            <div class="mt-4">
                {{ $masses->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-3"></div>
                <h3 class="h4 fw-medium mb-2">Nenhum horário encontrado</h3>
                <p class="text-muted mb-3">Comece criando o primeiro horário de missa.</p>
                <a href="{{ route('admin.global.masses.create') }}" 
                   class="btn btn-primary px-4 py-2">
                    Criar Primeiro Horário
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Weekly Schedule Overview -->
@if($masses->count() > 0)
<div class="mt-5 card shadow">
    <div class="card-body">
        <h3 class="h5 fw-semibold text-dark mb-3">Cronograma Semanal</h3>
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
                <div class="col border rounded p-3">
                    <h4 class="fw-medium text-dark mb-2">{{ $dayName }}</h4>
                    @if(isset($massesByDay[$dayKey]))
                        @foreach($massesByDay[$dayKey] as $mass)
                            <div class="small text-secondary mb-1">
                                <div class="fw-medium">{{ $mass->time->format('H:i') }}</div>
                                <div class="small">{{ $mass->name }}</div>
                            </div>
                        @endforeach
                    @else
                        <p class="small text-muted">Nenhuma missa</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
