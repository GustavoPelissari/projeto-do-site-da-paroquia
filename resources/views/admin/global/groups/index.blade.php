@extends('admin.layout')

@section('title', 'Gerenciar Grupos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Gerenciar Grupos</h2>
    <a href="{{ route('admin.global.groups.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
        Novo Grupo
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
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                    <select name="category" id="category" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Todas</option>
                        <option value="liturgy" {{ request('category') === 'liturgy' ? 'selected' : '' }}>Liturgia</option>
                        <option value="pastoral" {{ request('category') === 'pastoral' ? 'selected' : '' }}>Pastoral</option>
                        <option value="service" {{ request('category') === 'service' ? 'selected' : '' }}>Serviço</option>
                        <option value="formation" {{ request('category') === 'formation' ? 'selected' : '' }}>Formação</option>
                        <option value="youth" {{ request('category') === 'youth' ? 'selected' : '' }}>Juventude</option>
                        <option value="family" {{ request('category') === 'family' ? 'selected' : '' }}>Família</option>
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
                           placeholder="Nome ou descrição..." 
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        Filtrar
                    </button>
                </div>
            </div>
        </form>

        <!-- Groups Grid -->
        @if($groups->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($groups as $group)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    @if($group->image)
                        <img src="{{ Storage::url($group->image) }}" 
                             alt="{{ $group->name }}" 
                             class="w-full h-48 object-cover rounded-t-lg">
                    @else
                        <div class="w-full h-48 bg-gray-100 rounded-t-lg flex items-center justify-center">
                            <span class="text-gray-400 text-4xl">👥</span>
                        </div>
                    @endif
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900">{{ $group->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded {{ $group->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $group->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($group->description, 80) }}</p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <span class="px-2 py-1 bg-gray-100 rounded">{{ $group->category_name }}</span>
                            @if($group->coordinator_name)
                                <span>Coord: {{ $group->coordinator_name }}</span>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.global.groups.show', $group) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">Ver</a>
                                <a href="{{ route('admin.global.groups.edit', $group) }}" 
                                   class="text-green-600 hover:text-green-800 text-sm">Editar</a>
                            </div>
                            
                            <form method="POST" action="{{ route('admin.global.groups.destroy', $group) }}" 
                                  class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este grupo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $groups->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-400 text-6xl mb-4">👥</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum grupo encontrado</h3>
                <p class="text-gray-500 mb-4">Comece criando seu primeiro grupo.</p>
                <a href="{{ route('admin.global.groups.create') }}" 
                   class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                    Criar Primeiro Grupo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
