@extends('admin.layout')

@section('title', 'Gerenciar Horários de Missa')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 fw-bold text-dark mb-0">Horários de Missa</h2>
        <a href="{{ route('admin.administrativo.masses.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Novo Horário
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="day_of_week" class="form-label small fw-semibold">Dia da Semana</label>
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
                        <label for="status" class="form-label small fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="search" class="form-label small fw-semibold">Buscar</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               placeholder="Nome, local ou descrição..." 
                               class="form-control">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="bi bi-funnel me-1"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>

            <!-- Masses Table -->
            @if($masses->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">Dia da Semana</th>
                                <th class="fw-semibold">Horário</th>
                                <th class="fw-semibold">Local</th>
                                <th class="fw-semibold">Descrição</th>
                                <th class="fw-semibold">Status</th>
                                <th class="fw-semibold text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masses as $mass)
                            <tr>
                                <td>
                                    <span class="fw-medium">{{ $mass->day_name }}</span>
                                </td>
                                <td>{{ $mass->time->format('H:i') }}</td>
                                <td>{{ $mass->location }}</td>
                                <td>
                                    @if($mass->description)
                                        <span class="text-muted small">{{ Str::limit($mass->description, 50) }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $mass->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $mass->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.administrativo.masses.show', $mass) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Ver">
                                            <i class="bi bi-eye me-1"></i>Ver
                                        </a>
                                        <a href="{{ route('admin.administrativo.masses.edit', $mass) }}" 
                                           class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil me-1"></i>Editar
                                        </a>
                                        <form method="POST" action="{{ route('admin.administrativo.masses.destroy', $mass) }}" 
                                              class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                                <i class="bi bi-trash me-1"></i>Excluir
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
                @if($masses->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $masses->withQueryString()->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3" style="font-size: 4rem; opacity: 0.3;">⛪</div>
                    <h4 class="fw-bold mb-2">Nenhum horário encontrado</h4>
                    <p class="text-muted mb-4">Comece criando o primeiro horário de missa.</p>
                    <a href="{{ route('admin.administrativo.masses.create') }}" 
                       class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Criar Primeiro Horário
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Weekly Schedule Overview -->
    @if($masses->count() > 0)
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Cronograma Semanal</h5>
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
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <h6 class="card-title fw-bold text-primary mb-3">{{ $dayName }}</h6>
                                @if(isset($massesByDay[$dayKey]))
                                    @foreach($massesByDay[$dayKey] as $mass)
                                        <div class="mb-2">
                                            <div class="fw-semibold">{{ $mass->time->format('H:i') }}</div>
                                            <small class="text-muted">{{ $mass->location }}</small>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted small mb-0">Nenhuma missa</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
