@extends('admin.layout')

@section('title', 'Gerenciar Horários de Missa')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Horários de Missa</h2>
    <a href="{{ route('admin.administrativo.masses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        Novo Horário
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
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-1">Dia da Semana</label>
                    <select name="day_of_week" id="day_of_week" class="w-full border border-gray-300 rounded-md px-3 py-2">
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
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Todos</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nome, local ou descrição..." 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Masses Table -->
        @if($masses->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Nome</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Dia da Semana</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Horário</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Local</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($masses as $mass)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $mass->name }}</h4>
                                    @if($mass->description)
                                        <p class="text-sm text-gray-500">{{ Str::limit($mass->description, 50) }}</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3 px-4 text-gray-700">{{ $mass->day_name }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $mass->time->format('H:i') }}</td>
                            <td class="py-3 px-4 text-gray-700">{{ $mass->location }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs rounded {{ $mass->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $mass->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.administrativo.masses.show', $mass) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">Ver</a>
                                    <a href="{{ route('admin.administrativo.masses.edit', $mass) }}" 
                                       class="text-green-600 hover:text-green-800 text-sm">Editar</a>
                                    <form method="POST" action="{{ route('admin.administrativo.masses.destroy', $mass) }}" 
                                          class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este horário?')">
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
                {{ $masses->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 text-6xl mb-4">⛪</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum horário encontrado</h3>
                <p class="text-gray-500 mb-4">Comece criando o primeiro horário de missa.</p>
                <a href="{{ route('admin.administrativo.masses.create') }}" 
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Criar Primeiro Horário
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Weekly Schedule Overview -->
@if($masses->count() > 0)
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cronograma Semanal</h3>
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
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
                <div class="border rounded-lg p-3">
                    <h4 class="font-medium text-gray-900 mb-2">{{ $dayName }}</h4>
                    @if(isset($massesByDay[$dayKey]))
                        @foreach($massesByDay[$dayKey] as $mass)
                            <div class="text-sm text-gray-600 mb-1">
                                <div class="font-medium">{{ $mass->time->format('H:i') }}</div>
                                <div class="text-xs">{{ $mass->name }}</div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-xs text-gray-400">Nenhuma missa</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection
