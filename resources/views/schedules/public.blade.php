@extends('layout')

@section('title', 'Escalas - ' . $group->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm-px-6 lg-px-8 py-12">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl fw-bold text-gray-900 mb-4">Escalas - {{ $group->name }}</h1>
        <p class="text-xl text-gray-600">{{ $group->description }}</p>
    </div>

    @if($currentSchedule)
        <!-- Escala Atual -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-8 text-white mb-8">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="text-2xl fw-bold mb-2"> Escala Atual</h2>
                    <h3 class="text-xl fw-semibold mb-3">{{ $currentSchedule->title }}</h3>
                    <p class="text-blue-100 mb-4">
                        Período: {{ $currentSchedule->start_date->format('d/m/Y') }} - {{ $currentSchedule->end_date->format('d/m/Y') }}
                    </p>
                    @if($currentSchedule->description)
                        <p class="text-blue-100">{{ $currentSchedule->description }}</p>
                    @endif
                </div>
                
                <div class="text-center">
                    <a href="{{ $currentSchedule->getPdfUrl() }}" target="_blank"
                       class="bg-white text-blue-600 px-6 py-3 rounded-lg fw-semibold hover-bg-blue-50 transition d-inline-flex align-items-center">
                        <svg class="w-5 h-5 me-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                        </svg>
                        Ver PDF Oficial
                    </a>
                    <p class="text-blue-200 text-sm mt-2">Arquivo: {{ $currentSchedule->pdf_filename }}</p>
                </div>
            </div>
        </div>

        <!-- Aviso Importante -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
            <div class="d-flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ms-3">
                    <p class="text-sm text-yellow-700">
                        <strong>Importante:</strong> Sempre consulte o PDF oficial para informações atualizadas sobre a escala. 
                        O documento em PDF é a fonte oficial e pode conter alterações de última hora.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Todas as Escalas -->
    @if($schedules->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="px-6 py-4 border-bottom border-gray-200">
                <h2 class="text-xl fw-semibold text-gray-900">Histórico de Escalas</h2>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($schedules as $schedule)
                    <div class="px-6 py-4 hover-bg-gray-50 transition">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900 mb-1">
                                    {{ $schedule->title }}
                                </h3>
                                
                                <div class="d-flex align-items-center gap-4 text-sm text-gray-600 mb-2">
                                    <span class="d-flex align-items-center">
                                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }}
                                    </span>
                                    
                                    <span class="d-flex align-items-center">
                                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Criada em {{ $schedule->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                @if($schedule->description)
                                    <p class="text-gray-700 text-sm">{{ $schedule->description }}</p>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <!-- Status -->
                                @php $status = $schedule->getStatusBadge() @endphp
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $status['color'] }}-100 text-{{ $status['color'] }}-800">
                                    {{ $status['text'] }}
                                </span>

                                <!-- Download -->
                                <a href="{{ $schedule->getPdfUrl() }}" target="_blank"
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover-bg-blue-700 d-inline-flex align-items-center">
                                    <svg class="w-4 h-4 me-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    PDF
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4"></div>
            <h3 class="text-2xl font-medium text-gray-900 mb-2">Nenhuma escala disponível</h3>
            <p class="text-gray-600 mb-6">
                As escalas para {{ $group->name }} ainda não foram publicadas.
            </p>
        </div>
    @endif

    <!-- Informações do Grupo -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl fw-semibold text-gray-900 mb-4">Sobre o Grupo</h2>
        
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <h3 class="font-medium text-gray-900 mb-2">Informações Gerais</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Categoria:</span>
                        <span class="text-gray-600">{{ $group->category_name }}</span>
                    </div>
                    @if($group->meeting_info)
                        <div>
                            <span class="font-medium text-gray-700">Reuniões:</span>
                            <span class="text-gray-600">{{ $group->meeting_info }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="font-medium text-gray-700">Membros:</span>
                        <span class="text-gray-600">{{ $group->getMembersCount() }} pessoas</span>
                    </div>
                </div>
            </div>

            @if($group->coordinator_name || $group->coordinator_phone || $group->coordinator_email)
                <div class="col">
                    <h3 class="font-medium text-gray-900 mb-2">Coordenação</h3>
                    <div class="space-y-2 text-sm">
                        @if($group->coordinator_name)
                            <div>
                                <span class="font-medium text-gray-700">Coordenador:</span>
                                <span class="text-gray-600">{{ $group->coordinator_name }}</span>
                            </div>
                        @endif
                        @if($group->coordinator_phone)
                            <div>
                                <span class="font-medium text-gray-700">Telefone:</span>
                                <a href="tel:{{ $group->coordinator_phone }}" class="text-blue-600 hover-text-blue-800">
                                    {{ $group->coordinator_phone }}
                                </a>
                            </div>
                        @endif
                        @if($group->coordinator_email)
                            <div>
                                <span class="font-medium text-gray-700">E-mail:</span>
                                <a href="mailto:{{ $group->coordinator_email }}" class="text-blue-600 hover-text-blue-800">
                                    {{ $group->coordinator_email }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- CTA para entrar no grupo -->
        @auth
            @if(!auth()->user()->parish_group_id)
                <div class="mt-6 pt-6 border-top border-gray-200">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900 mb-2">Interessado em participar?</h4>
                        <p class="text-blue-800 text-sm mb-3">
                            Faça uma solicitação para entrar em {{ $group->name }} e participe das nossas atividades.
                        </p>
                        <a href="{{ route('group-requests.create') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover-bg-blue-700">
                            Solicitar Entrada
                        </a>
                    </div>
                </div>
            @endif
        @else
            <div class="mt-6 pt-6 border-top border-gray-200">
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">Quer participar?</h4>
                    <p class="text-gray-700 text-sm mb-3">
                        Faça login ou registre-se para solicitar entrada em {{ $group->name }}.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover-bg-blue-700">
                            Fazer Login
                        </a>
                        <a href="{{ route('register') }}" 
                           class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover-bg-gray-700">
                            Registrar-se
                        </a>
                    </div>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection