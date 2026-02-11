<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gerenciar Escalas') }}
            </h2>
            <a href="{{ route('admin.schedules.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover-bg-blue-700">
                Nova Escala
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm-px-6 lg-px-8">
            <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                <div class="p-6 bg-white border-bottom border-gray-200">
                    <!-- Filtros -->
                    <div class="mb-6 d-flex flex-column sm-flex-row gap-4">
                        <form method="GET" class="d-flex gap-2 flex-wrap">
                            @if(auth()->user()->isAdminGlobal() && $groups->count() > 0)
                                <select name="group_id" class="rounded-md border-gray-300 form-select" onchange="this.form.submit()">
                                    <option value="">Todos os grupos</option>
                                    @foreach($groups as $group)
                                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif

                            <select name="status" class="rounded-md border-gray-300 form-select" onchange="this.form.submit()">
                                <option value="">Todos os status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Ativas</option>
                                <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>Futuras</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expiradas</option>
                            </select>
                        </form>
                    </div>

                    <!-- Lista de Escalas -->
                    @if($schedules->count() > 0)
                        <div class="d-grid gap-6">
                            @foreach($schedules as $schedule)
                                <div class="border border-gray-200 rounded-lg p-6 hover-shadow-md transition">
                                    <div class="d-flex align-items-start justify-content-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                                {{ $schedule->title }}
                                            </h3>
                                            
                                            <div class="d-flex align-items-center gap-4 text-sm text-gray-600 mb-3">
                                                <span class="d-flex align-items-center">
                                                    <span class="me-1">👥</span>
                                                    {{ $schedule->group->name }}
                                                </span>
                                                <span class="d-flex align-items-center">
                                                    <span class="me-1">📅</span>
                                                    {{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }}
                                                </span>
                                                <span class="d-flex align-items-center">
                                                    <span class="me-1">👤</span>
                                                    {{ $schedule->user->name }}
                                                </span>
                                            </div>

                                            @if($schedule->description)
                                                <p class="text-gray-700 mb-3">{{ $schedule->description }}</p>
                                            @endif

                                            <div class="d-flex align-items-center gap-4">
                                                @php $status = $schedule->getStatusBadge() @endphp
                                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                                    {{ $status['text'] }}
                                                </span>
                                                
                                                <span class="text-xs text-gray-500">
                                                    Arquivo: {{ $schedule->pdf_filename }} ({{ $schedule->getPdfSize() }})
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Ações -->
                                        <div class="d-flex gap-2 ms-4">
                                            <a href="{{ route('admin.schedules.show', $schedule) }}" 
                                               class="bg-blue-100 text-blue-600 px-3 py-1 rounded text-sm hover-bg-blue-200">
                                                Ver
                                            </a>
                                            
                                            <a href="{{ route('admin.schedules.download', $schedule) }}" 
                                               class="bg-green-100 text-green-600 px-3 py-1 rounded text-sm hover-bg-green-200">
                                                PDF
                                            </a>
                                            
                                            @if(auth()->user()->canManageSchedules())
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" 
                                                   class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded text-sm hover-bg-yellow-200">
                                                    Editar
                                                </a>
                                                
                                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" 
                                                      class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta escala?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="bg-red-100 text-red-600 px-3 py-1 rounded text-sm hover-bg-red-200">
                                                        Excluir
                                                    </button>
                                                </form>
                                            @endif
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
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">📋</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma escala encontrada</h3>
                            <p class="text-gray-600 mb-6">
                                @if(request()->hasAny(['group_id', 'status']))
                                    Tente ajustar os filtros para ver mais resultados.
                                @else
                                    Não há escalas cadastradas no momento.
                                @endif
                            </p>
                            
                            <a href="{{ route('admin.schedules.create') }}" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover-bg-blue-700">
                                Criar Primeira Escala
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>