@extends('admin.layout')

@section('title', $event->title)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $event->title }}</h2>
        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
            <span>Por {{ $event->user->name }}</span>
            <span>•</span>
            <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
            <span>•</span>
            <span class="px-2 py-1 rounded text-xs
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
        </div>
    </div>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Editar
        </a>
        <a href="{{ route('admin.administrativo.events.index') }}" 
           class="text-gray-600 hover:text-gray-800 px-4 py-2 border border-gray-300 rounded-lg">
            Voltar
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow">
            <!-- Event Image -->
            @if($event->image)
                <div class="mb-6">
                    <img src="{{ Storage::url($event->image) }}" 
                         alt="{{ $event->title }}" 
                         class="w-full h-64 object-cover rounded-t-lg">
                </div>
            @endif
            
            <div class="p-6">
                <!-- Event Description -->
                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Descrição</h3>
                    <div class="text-gray-700">{!! nl2br(e($event->description)) !!}</div>
                </div>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">📅 Data e Horário</h4>
                        <div class="text-gray-700">
                            <p><strong>Início:</strong> {{ $event->start_date->format('d/m/Y H:i') }}</p>
                            @if($event->end_date)
                                <p><strong>Término:</strong> {{ $event->end_date->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($event->location)
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">📍 Local</h4>
                            <p class="text-gray-700">{{ $event->location }}</p>
                        </div>
                    @endif
                </div>

                @if($event->requirements)
                    <div class="mb-6">
                        <h4 class="font-semibold text-gray-900 mb-2">📋 Requisitos</h4>
                        <div class="text-gray-700">{!! nl2br(e($event->requirements)) !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Ações Rápidas</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.administrativo.events.edit', $event) }}" 
                   class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition">
                    ✏️ Editar Evento
                </a>
                
                @if($event->status !== 'confirmed')
                    <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}" class="block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="confirmed">
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition">
                            ✅ Confirmar Evento
                        </button>
                    </form>
                @endif

                @if($event->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin.administrativo.events.update', $event) }}" class="block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="cancelled">
                        <input type="hidden" name="title" value="{{ $event->title }}">
                        <input type="hidden" name="description" value="{{ $event->description }}">
                        <input type="hidden" name="start_date" value="{{ $event->start_date }}">
                        <button type="submit" 
                                class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition"
                                onclick="return confirm('Tem certeza que deseja cancelar este evento?')">
                            ❌ Cancelar Evento
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.administrativo.events.destroy', $event) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir este evento? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 transition">
                        🗑️ Excluir Evento
                    </button>
                </form>
            </div>
        </div>

        <!-- Event Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Informações do Evento</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2 px-2 py-1 rounded text-xs
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
                </div>
                
                @if($event->category)
                    <div>
                        <span class="font-medium text-gray-700">Categoria:</span>
                        <span class="ml-2 text-gray-600">
                            @switch($event->category)
                                @case('liturgy') Liturgia @break
                                @case('formation') Formação @break
                                @case('social') Social @break
                                @case('youth') Juventude @break
                                @case('family') Família @break
                                @default {{ ucfirst($event->category) }}
                            @endswitch
                        </span>
                    </div>
                @endif
                
                <div>
                    <span class="font-medium text-gray-700">Criado por:</span>
                    <span class="ml-2 text-gray-600">{{ $event->user->name }}</span>
                </div>
                
                <div>
                    <span class="font-medium text-gray-700">Criado em:</span>
                    <span class="ml-2 text-gray-600">{{ $event->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                @if($event->updated_at != $event->created_at)
                    <div>
                        <span class="font-medium text-gray-700">Atualizado em:</span>
                        <span class="ml-2 text-gray-600">{{ $event->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
                
                @if($event->max_participants)
                    <div>
                        <span class="font-medium text-gray-700">Máx. Participantes:</span>
                        <span class="ml-2 text-gray-600">{{ $event->max_participants }}</span>
                    </div>
                @else
                    <div>
                        <span class="font-medium text-gray-700">Participantes:</span>
                        <span class="ml-2 text-gray-600">Sem limite</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Navigation -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Navegação</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.administrativo.events.index') }}" 
                   class="block text-blue-600 hover:text-blue-800 text-sm">
                    ← Todos os Eventos
                </a>
                <a href="{{ route('admin.administrativo.events.create') }}" 
                   class="block text-green-600 hover:text-green-800 text-sm">
                    + Novo Evento
                </a>
                <a href="{{ \App\Helpers\DashboardHelper::getDashboardRoute(auth()->user()->role) }}" 
                   class="block text-gray-600 hover:text-gray-800 text-sm">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
