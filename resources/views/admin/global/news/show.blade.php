@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $news->title }}</h2>
        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
            <span>Por {{ $news->user->name }}</span>
            <span>•</span>
            <span>{{ $news->created_at->format('d/m/Y H:i') }}</span>
            <span>•</span>
            <span class="px-2 py-1 rounded text-xs
                {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
            </span>
            @if($news->featured)
                <span class="text-yellow-500">⭐ Destaque</span>
            @endif
        </div>
    </div>
    
    <div class="flex space-x-3">
        <a href="{{ route('admin.global.news.edit', $news) }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Editar
        </a>
        <a href="{{ route('admin.global.news.index') }}" 
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
            <!-- Featured Image -->
            @if($news->featured_image)
                <div class="mb-6">
                    <img src="{{ Storage::url($news->featured_image) }}" 
                         alt="{{ $news->title }}" 
                         class="w-full h-64 object-cover rounded-t-lg">
                </div>
            @endif
            
            <div class="p-6">
                <!-- Summary -->
                @if($news->summary)
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <p class="text-blue-800 font-medium">{{ $news->summary }}</p>
                    </div>
                @endif

                <!-- Content -->
                <div class="prose max-w-none">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- Meta Information -->
                @if($news->meta_description)
                    <div class="mt-8 pt-6 border-t">
                        <h3 class="font-semibold text-gray-900 mb-2">Meta Descrição (SEO)</h3>
                        <p class="text-gray-600">{{ $news->meta_description }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Preview Notice -->
        @if($news->status === 'draft')
            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="text-yellow-400 mr-3">⚠️</div>
                    <div>
                        <h3 class="font-medium text-yellow-800">Esta notícia está em rascunho</h3>
                        <p class="text-yellow-700 text-sm">
                            Ela não será exibida no site público até ser publicada.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Ações Rápidas</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.global.news.edit', $news) }}" 
                   class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition">
                    ✏️ Editar Notícia
                </a>
                
                @if($news->status === 'published')
                    <form method="POST" action="{{ route('admin.global.news.update', $news) }}" class="block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="draft">
                        <button type="submit" 
                                class="w-full bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-yellow-700 transition">
                            📝 Tornar Rascunho
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.global.news.update', $news) }}" class="block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="published">
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition">
                            🚀 Publicar Agora
                        </button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.global.news.destroy', $news) }}" 
                      onsubmit="return confirm('Tem certeza que deseja excluir esta notícia? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition">
                        🗑️ Excluir Notícia
                    </button>
                </form>
            </div>
        </div>

        <!-- Publishing Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Informações de Publicação</h3>
            <div class="space-y-3 text-sm">
                <div>
                    <span class="font-medium text-gray-700">Status:</span>
                    <span class="ml-2 px-2 py-1 rounded text-xs
                        {{ $news->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $news->status === 'published' ? 'Publicado' : 'Rascunho' }}
                    </span>
                </div>
                
                <div>
                    <span class="font-medium text-gray-700">Autor:</span>
                    <span class="ml-2 text-gray-600">{{ $news->user->name }}</span>
                </div>
                
                <div>
                    <span class="font-medium text-gray-700">Criado em:</span>
                    <span class="ml-2 text-gray-600">{{ $news->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                @if($news->updated_at != $news->created_at)
                    <div>
                        <span class="font-medium text-gray-700">Atualizado em:</span>
                        <span class="ml-2 text-gray-600">{{ $news->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
                
                @if($news->published_at)
                    <div>
                        <span class="font-medium text-gray-700">Publicado em:</span>
                        <span class="ml-2 text-gray-600">{{ $news->published_at->format('d/m/Y H:i') }}</span>
                    </div>
                @endif
                
                <div>
                    <span class="font-medium text-gray-700">Destaque:</span>
                    <span class="ml-2 text-gray-600">{{ $news->featured ? 'Sim' : 'Não' }}</span>
                </div>
                
                @if($news->slug)
                    <div>
                        <span class="font-medium text-gray-700">URL:</span>
                        <span class="ml-2 text-gray-600 text-xs break-all">{{ $news->slug }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- SEO Information -->
        @if($news->meta_description || $news->slug)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-gray-900 mb-4">SEO</h3>
                <div class="space-y-3 text-sm">
                    @if($news->slug)
                        <div>
                            <span class="font-medium text-gray-700">URL Amigável:</span>
                            <div class="mt-1 p-2 bg-gray-50 rounded text-xs font-mono">
                                /noticias/{{ $news->slug }}
                            </div>
                        </div>
                    @endif
                    
                    @if($news->meta_description)
                        <div>
                            <span class="font-medium text-gray-700">Meta Descrição:</span>
                            <div class="mt-1 text-gray-600">{{ $news->meta_description }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Navigation -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Navegação</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.global.news.index') }}" 
                   class="block text-blue-600 hover:text-blue-800 text-sm">
                    ← Todas as Notícias
                </a>
                <a href="{{ route('admin.global.news.create') }}" 
                   class="block text-green-600 hover:text-green-800 text-sm">
                    + Nova Notícia
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
