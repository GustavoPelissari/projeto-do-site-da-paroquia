@extends('layout')

@section('title', 'Paróquia São José')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-4">⛪ Paróquia São José</h1>
            <p class="text-xl mb-8">Bem-vindos à nossa comunidade de fé e amor</p>
            
            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Entrar
                </a>
                <a href="{{ route('register') }}" class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Cadastrar-se
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-blue-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-blue-600 mb-2">{{ $groups->count() }}</div>
                    <div class="text-gray-600">Grupos e Pastorais</div>
                </div>
                <div class="bg-green-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-green-600 mb-2">{{ $recentSchedules->count() }}</div>
                    <div class="text-gray-600">Escalas Ativas</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-6">
                    <div class="text-3xl font-bold text-purple-600 mb-2">∞</div>
                    <div class="text-gray-600">Fé e Esperança</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Groups Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nossos Grupos e Pastorais</h2>
                <p class="text-gray-600">Participe da nossa comunidade e encontre seu lugar</p>
            </div>

            @if($groups->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($groups->take(6) as $group)
                        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $group->name }}</h3>
                            @if($group->description)
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($group->description, 100) }}</p>
                            @endif
                            
                            @if($group->coordinator)
                                <div class="text-xs text-blue-600 mb-3">
                                    <strong>Coordenador:</strong> {{ $group->coordinator->name }}
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                    {{ $group->members->count() }} membros
                                </span>
                                
                                <a href="{{ route('login') }}" 
                                   class="text-blue-600 text-sm hover:text-blue-800">
                                    Ver Mais →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-6xl mb-4">👥</div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Sistema Paroquial Ativo!</h3>
                    <p class="text-gray-600">Faça login para acessar as funcionalidades do sistema.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">🚀 Funcionalidades do Sistema</h2>
                <p class="text-gray-600">Sistema completo de gestão paroquial</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-blue-50 rounded-lg p-6 text-center">
                    <div class="text-3xl mb-3">👑</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Admin Global</h3>
                    <p class="text-sm text-gray-600">Controle total do sistema</p>
                </div>
                
                <div class="bg-green-50 rounded-lg p-6 text-center">
                    <div class="text-3xl mb-3">📋</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Coordenadores</h3>
                    <p class="text-sm text-gray-600">Gerencie escalas e grupos</p>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-6 text-center">
                    <div class="text-3xl mb-3">📄</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Upload de PDFs</h3>
                    <p class="text-sm text-gray-600">Escalas em formato PDF</p>
                </div>
                
                <div class="bg-purple-50 rounded-lg p-6 text-center">
                    <div class="text-3xl mb-3">🔔</div>
                    <h3 class="font-semibold text-gray-900 mb-2">Notificações</h3>
                    <p class="text-sm text-gray-600">Sistema de avisos</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Sistema Paroquial Completo!</h2>
            <p class="text-xl mb-8">Gestão de grupos, escalas, solicitações e muito mais</p>
            
            <div class="space-x-4">
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Cadastre-se Agora
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                    Fazer Login
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h3 class="text-lg font-semibold mb-2">⛪ Paróquia São José</h3>
            <p class="text-gray-400 mb-4">Sistema de Gestão Paroquial - Laravel 12</p>
            <div class="border-t border-gray-700 pt-4">
                <p class="text-sm text-gray-400">
                    © {{ date('Y') }} Sistema desenvolvido seguindo as regras: "Para exceções, consulte admin_global"
                </p>
            </div>
        </div>
    </footer>
</div>
@endsection