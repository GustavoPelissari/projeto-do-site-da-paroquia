@extends('admin.layout')

@section('title', 'Gerenciar Horários de Missa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-6">
    <h2 class="h2 fw-bold text-dark">Horários de Missa</h2>
    <a href="{{ route('admin.administrativo.masses.create') }}" class="btn btn-primary px-4 py-2">
        Novo Horário
    </a>
</div>

@if(session('success'))
    <div class="bg-success-subtle border border-success text-success-emphasis px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded shadow">
    <div class="p-6">
        <!-- Filters -->
        <form method="GET" class="mb-6">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="day_of_week" class="d-block small fw-medium text-dark mb-1">Dia da Semana</label>
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
                    <label for="status" class="d-block small fw-medium text-dark mb-1">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="d-block small fw-medium text-dark mb-1">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nome, local ou descrição..." 
                           class="form-control">
                </div>
                <div class="col-md-3 d-flex align-items-end">
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
                        <tr class="border-bottom bg-secondary-subtle">
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Nome</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Dia da Semana</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Horário</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Local</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Status</th>
                            <th class="text-start py-3 px-4 fw-semibold text-dark">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masses as $mass)
                        <tr class="border-bottom">
                            <td class="py-3 px-4">
                                <div>
                                    <h4 class="fw-medium text-dark">{{ $mass->name }}</h4>
                                    @if($mass->description)
                                        <p class="small text-secondary">{{ Str::limit($mass->description, 50) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-dark">{{ $mass->day_name }}</td>
                            <td class="py-3 px-4 text-dark">{{ $mass->time->format('H:i') }}</td>
                            <td class="py-3 px-4 text-dark">{{ $mass->location }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 small rounded {{ $mass->is_active ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }}">
                                    {{ $mass->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.administrativo.masses.show', $mass) }}" 
                                       class="text-primary hover-text-primary-dark small">Ver</a>
                                    <a href="{{ route('admin.administrativo.masses.edit', $mass) }}" 
                                       class="text-success hover-text-success-dark small">Editar</a>
                                    <form method="POST" action="{{ route('admin.administrativo.masses.destroy', $mass) }}" 
                                          class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger hover-text-danger-dark small p-0">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $masses->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-secondary" style="font-size: 4rem;">⛪</div>
                <h3 class="h5 fw-medium text-dark mb-2">Nenhum horário encontrado</h3>
                <p class="text-secondary mb-4">Comece criando o primeiro horário de missa.</p>
                <a href="{{ route('admin.administrativo.masses.create') }}" 
                   class="btn btn-primary px-4 py-2">
                    Criar Primeiro Horário
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Weekly Schedule Overview -->
@if($masses->count() > 0)
<div class="mt-8 bg-white rounded shadow">
    <div class="p-6">
        <h3 class="h5 fw-semibold text-dark mb-4">Cronograma Semanal</h3>
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
                <div class="col-md-3 col-lg-auto">
                    <div class="border rounded p-3">
                        <h4 class="fw-medium text-dark mb-2">{{ $dayName }}</h4>
                        @if(isset($massesByDay[$dayKey]))
                            @foreach($massesByDay[$dayKey] as $mass)
                                <div class="small text-secondary mb-1">
                                    <div class="fw-medium">{{ $mass->time->format('H:i') }}</div>
                                    <div class="small">{{ $mass->name }}</div>
                                </div>
                            @endforeach
                        @else
                            <p class="small text-secondary">Nenhuma missa</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
