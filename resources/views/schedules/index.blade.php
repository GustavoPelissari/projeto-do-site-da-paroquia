<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h2 class="h4 mb-0 fw-semibold text-body">{{ __('Gerenciar Escalas') }}</h2>
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Nova Escala
            </a>
        </div>
    </x-slot>

    <div class="py-4 py-md-5">
        <div class="container">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <form method="GET" class="row g-2 align-items-center">
                            @if(auth()->user()->isAdminGlobal() && $groups->count() > 0)
                                <div class="col-12 col-md-4">
                                    <select name="group_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Todos os grupos</option>
                                        @foreach($groups as $group)
                                            <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                                {{ $group->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-12 col-md-4">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos os status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativas</option>
                                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Futuras</option>
                                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expiradas</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    @if($schedules->count() > 0)
                        <div class="d-grid gap-3">
                            @foreach($schedules as $schedule)
                                <article class="border rounded-4 p-3 p-md-4 bg-white shadow-sm">
                                    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3">
                                        <div>
                                            <h3 class="h5 fw-semibold mb-2">{{ $schedule->title }}</h3>

                                            <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                                                <span><i class="bi bi-people me-1"></i>{{ $schedule->group->name }}</span>
                                                <span><i class="bi bi-calendar-event me-1"></i>{{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }}</span>
                                                <span><i class="bi bi-person me-1"></i>{{ $schedule->user->name }}</span>
                                            </div>

                                            @if($schedule->description)
                                                <p class="mb-3 text-secondary">{{ $schedule->description }}</p>
                                            @endif

                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                @php $status = $schedule->getStatusBadge() @endphp
                                                <span class="badge rounded-pill {{ 'bg-'.$status['color'].'-subtle text-'.$status['color'].'-emphasis' }} border">
                                                    {{ $status['text'] }}
                                                </span>
                                                <span class="small text-muted">Arquivo: {{ $schedule->pdf_filename }} ({{ $schedule->getPdfSize() }})</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 align-self-start">
                                            <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                            <a href="{{ route('admin.schedules.download', $schedule) }}" class="btn btn-sm btn-outline-success">PDF</a>
                                            @if(auth()->user()->canManageSchedules())
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta escala?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $schedules->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="display-6 mb-3"></div>
                            <h3 class="h5 mb-2">Nenhuma escala encontrada</h3>
                            <p class="text-muted mb-4">
                                @if(request()->hasAny(['group_id', 'status']))
                                    Tente ajustar os filtros para ver mais resultados.
                                @else
                                    Não há escalas cadastradas no momento.
                                @endif
                            </p>

                            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">Criar Primeira Escala</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
