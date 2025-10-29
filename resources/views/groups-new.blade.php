@extends('layout')

@section('title', 'Grupos Paroquiais')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-white py-8">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">🙏 Grupos e Pastorais</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Conheça nossos grupos paroquiais e encontre seu lugar na nossa comunidade de fé
            </p>
        </div>

        <!-- Groups Grid -->
        @if($groups->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($groups as $group)
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 border border-gray-100">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-2xl">👥</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $group->name }}</h3>
                        </div>
                        
                        @if($group->description)
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ $group->description }}</p>
                        @endif
                        
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                ✅ Ativo
                            </span>
                            
                            @auth
                                <a href="{{ route('group-requests.create') }}" 
                                   class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Participar →
                                </a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 mb-12">
                <div class="text-8xl mb-6">🏗️</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Grupos em Organização</h3>
                <p class="text-gray-600 text-lg max-w-md mx-auto">
                    Estamos organizando nossos grupos paroquiais. Em breve você poderá se inscrever!
                </p>
            </div>
        @endif
        
        <!-- Call to Action Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-2xl p-8 text-white text-center">
            <h2 class="text-3xl font-bold mb-4">Quer Fazer Parte?</h2>
            <p class="text-blue-100 mb-8 text-lg max-w-2xl mx-auto">
                Junte-se à nossa comunidade! Cadastre-se no sistema e solicite participação em nossos grupos e pastorais.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" 
                       class="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition-all duration-300 shadow-lg">
                        🚀 Cadastrar-se Agora
                    </a>
                    <a href="{{ route('login') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Já tenho conta
                    </a>
                @else
                    <a href="{{ route('group-requests.create') }}" 
                       class="bg-white text-blue-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-100 transition-all duration-300 shadow-lg">
                        ✋ Solicitar Participação
                    </a>
                    <a href="{{ route('group-requests.my-requests') }}" 
                       class="border-2 border-white text-white px-8 py-4 rounded-xl font-bold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Minhas Solicitações
                    </a>
                @endguest
            </div>
        </div>

        <!-- Contact Section -->
        <div class="mt-12 bg-gray-50 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">💬 Dúvidas sobre os Grupos?</h3>
            <p class="text-gray-600 mb-6 text-lg">
                Nossa equipe está pronta para ajudar você a encontrar o grupo ideal para sua caminhada de fé.
            </p>
            <a href="mailto:grupos@paroquia.com?subject=Interesse em participar de grupos" 
               class="bg-blue-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-blue-700 transition-all duration-300 inline-flex items-center">
                📧 Entrar em Contato
            </a>
        </div>
    </div>
</div>
@endsection