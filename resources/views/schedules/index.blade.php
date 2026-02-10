<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">
                {{ __('Gerenciar Escalas') }}
            </h2>
            <a href="{{ route('admin.schedules.create') }}" 
               class="btn btn-primary btn-sm">
                Nova Escala
            </a>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container-xl">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Filtros -->
                    <div class="mb-4">
                        <form method="GET" class="d-flex flex-wrap gap-2">
                            @if(auth()->user()->isAdminGlobal() && $groups->count() > 0)
                                <select name="group_id" class="form-select" onchange="this.form.submit()" style="min-width: 200px;">
                                    <option value="">Todos os grupos</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                            <select name="status" class="form-select" onchange="this.form.submit()" style="min-width: 180px;">
                                <option value="">Todos os status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativas</option>
                                <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Futuras</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expiradas</option>
                            </select>
                        </form>
                    </div>

                    <!-- Lista de Escalas -->
                    @if($schedules->count() > 0)
                        <div class="d-grid gap-3">
                            @foreach($schedules as $schedule)
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex flex-column flex-lg-row gap-3">
                                            <div class="flex-grow-1">
                                                <h3 class="h6 fw-semibold mb-2">
                                                {{ $schedule->title }}
                                                </h3>
                                                
                                                <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                                                    <span class="d-inline-flex align-items-center gap-1">
                                                        <i class="bi bi-people" aria-hidden="true"></i>
                                                        {{ $schedule->group->name }}
                                                    </span>
                                                    <span class="d-inline-flex align-items-center gap-1">
                                                        <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                                        {{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }}
                                                    </span>
                                                    <span class="d-inline-flex align-items-center gap-1">
                                                        <i class="bi bi-person" aria-hidden="true"></i>
                                                        {{ $schedule->user->name }}
                                                    </span>
                                                </div>

                                                @if($schedule->description)
                                                    <p class="text-muted mb-3">{{ $schedule->description }}</p>
                                                @endif

                                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                                    @php
                                                        $status = $schedule->getStatusBadge();
                                                        $statusClass = [
                                                            'gray' => 'secondary',
                                                            'blue' => 'primary',
                                                            'red' => 'danger',
                                                            'green' => 'success',
                                                        ][$status['color']] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $statusClass }}">
                                                        {{ $status['text'] }}
                                                    </span>
                                                    
                                                    <span class="text-muted small">
                                                        Arquivo: {{ $schedule->pdf_filename }} ({{ $schedule->getPdfSize() }})
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Ações -->
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('admin.schedules.show', $schedule) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    Ver
                                                </a>
                                                
                                                <a href="{{ route('admin.schedules.download', $schedule) }}" 
                                                   class="btn btn-outline-success btn-sm">
                                                    PDF
                                                </a>
                                                
                                                @if(auth()->user()->canManageSchedules())
                                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                                       class="btn btn-outline-warning btn-sm">
                                                        Editar
                                                    </a>
                                                    
                                                    <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" 
                                                          class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta escala?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm">
                                                            Excluir
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $schedules->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="text-muted fs-1 mb-3">📋</div>
                            <h3 class="h6 fw-semibold mb-2">Nenhuma escala encontrada</h3>
                            <p class="text-muted mb-4">
                                @if(request()->hasAny(['group_id', 'status']))
                                    Tente ajustar os filtros para ver mais resultados.
                                @else
                                    Não há escalas cadastradas no momento.
                                @endif
                            </p>
                            
                            <a href="{{ route('admin.schedules.create') }}" 
                               class="btn btn-primary">
                                Criar Primeira Escala
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>