@extends('admin.layout')

@section('title', 'Gerenciar Eventos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Gerenciar Eventos</h2>
    <a href="{{ route('admin.administrativo.events.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
        Novo Evento
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow">
    <div class="p-6">
        <!-- Filters -->
        <form method="GET" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Todos</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                    </select>
                </div>
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                    <select name="date_filter" id="date_filter" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Todos</option>
                        <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                        <option value="past" {{ request('date_filter') === 'past' ? 'selected' : '' }}>Passados</option>
                        <option value="this_month" {{ request('date_filter') === 'this_month' ? 'selected' : '' }}>Este Mês</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Título ou descrição..." 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Events Table -->
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Evento</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Data/Hora</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Local</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Participantes</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ Str::limit($event->description, 60) }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-700">
                                <div class="text-sm">
                                    <div>{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-gray-500">{{ $event->start_date->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $event->location ?: '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded 
                                    @switch($event->status)
                                        @case('confirmed') bg-green-100 text-green-800 @break
                                        @case('scheduled') bg-blue-100 text-blue-800 @break
                                        @case('cancelled') bg-red-100 text-red-800 @break
                                        @case('completed') bg-gray-100 text-gray-800 @break
                                        @default bg-yellow-100 text-yellow-800
                                    @endswitch">
                                    @switch($event->status)
                                        @case('confirmed') Confirmado @break
                                        @case('scheduled') Agendado @break
                                        @case('cancelled') Cancelado @break
                                        @case('completed') Concluído @break
                                        @default {{ ucfirst($event->status) }}
                                    @endswitch
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-700">
                                @if($event->max_participants)
                                    <span class="text-sm">Máx: {{ $event->max_participants }}</span>
                                @else
                                    <span class="text-gray-400">Sem limite</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.administrativo.events.show', $event) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">Ver</a>
                                    <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
                                       class="text-green-600 hover:text-green-800 text-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                                          class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
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
                {{ $events->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 text-6xl mb-4">📅</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum evento encontrado</h3>
                <p class="text-gray-500 mb-4">Comece criando seu primeiro evento.</p>
                <a href="{{ route('admin.administrativo.events.create') }}" 
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Criar Primeiro Evento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
