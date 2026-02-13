@extends('layouts.app')

@section('title', 'Minhas Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero">
            <div class="sp-hero-content">
                <h1 class="sp-hero-title"> Minhas Solicitações</h1>
                <p class="sp-hero-subtitle">
                    Acompanhe o status das suas solicitações de entrada em grupos e pastorais
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="sp-alert sp-alert-success sp-mb-6">
                <div class="sp-alert-icon"></div>
                <div class="sp-alert-content">
                    <strong>Sucesso!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="sp-alert sp-alert-error sp-mb-6">
                <div class="sp-alert-icon"></div>
                <div class="sp-alert-content">
                    <strong>Atenção!</strong> {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- Actions Section --}}
        @if(!auth()->user()->parish_group_id)
            <section class="sp-section">
                <div class="sp-content-wrapper sp-text-center">
                    <div class="sp-cta">
                        <h3 class="sp-cta-title">Quer participar de mais grupos?</h3>
                        <p class="sp-cta-text">
                            Envie uma nova solicitação para se juntar a outros grupos da nossa paróquia.
                        </p>
                        <a href="{{ route('group-requests.create') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                             Nova Solicitação
                        </a>
                    </div>
                </div>
            </section>
        @endif

        {{-- Main Content --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                @forelse($requests as $request)
                    <div class="sp-card sp-mb-6" style="border-left: 4px solid {{ $request->status === 'pending' ? 'var(--sp-gold)' : ($request->status === 'approved' ? 'var(--sp-teal)' : 'var(--sp-red)') }};">
                        
                        {{-- Header --}}
                        <div class="sp-card-header">
                            <div class="sp-flex sp-justify-between sp-items-start">
                                <div>
                                    <h3 class="sp-card-title"> {{ $request->group->name }}</h3>
                                    <p class="sp-text-sm sp-text-muted">
                                        Solicitado em {{ $request->created_at->format('d/m/Y \à\s H:i') }}
                                    </p>
                                </div>
                                
                                <div class="sp-badge sp-badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'error') }}">
                                    @if($request->status === 'pending')
                                        ⏳ Pendente
                                    @elseif($request->status === 'approved')
                                         Aprovada
                                    @else
                                         Rejeitada
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="sp-card-content">
                            
                            {{-- Timeline --}}
                            <div class="sp-timeline">
                                {{-- Solicitação Enviada --}}
                                <div class="sp-timeline-item">
                                    <div class="sp-timeline-marker sp-timeline-marker-blue"></div>
                                    <div class="sp-timeline-content">
                                        <h4 class="sp-font-semibold sp-text-blue-900"> Solicitação Enviada</h4>
                                        <p class="sp-text-sm sp-text-muted">
                                            {{ $request->created_at->format('d/m/Y \à\s H:i') }}
                                        </p>
                                        @if($request->message)
                                            <div class="sp-card sp-mt-3" style="background: var(--sp-gray-50); border: 1px solid var(--sp-gray-200);">
                                                <div class="sp-card-content" style="padding: var(--space-3);">
                                                    <p class="sp-text-sm sp-italic" style="color: var(--sp-gray-700);">
                                                        "{{ $request->message }}"
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Resposta (se houver) --}}
                                @if($request->approved_at || $request->rejected_at)
                                    <div class="sp-timeline-item">
                                        <div class="sp-timeline-marker sp-timeline-marker-{{ $request->status === 'approved' ? 'green' : 'red' }}"></div>
                                        <div class="sp-timeline-content">
                                            <h4 class="sp-font-semibold" style="color: {{ $request->status === 'approved' ? 'var(--sp-teal)' : 'var(--sp-red)' }};">
                                                @if($request->status === 'approved')
                                                     Solicitação Aprovada
                                                @else
                                                     Solicitação Rejeitada
                                                @endif
                                            </h4>
                                            <p class="sp-text-sm sp-text-muted">
                                                {{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y \à\s H:i') }}
                                                @if($request->approver)
                                                    por {{ $request->approver->name }}
                                                @endif
                                            </p>
                                            @if($request->response_message)
                                                <div class="sp-card sp-mt-3" style="background: {{ $request->status === 'approved' ? 'var(--sp-teal-50)' : 'var(--sp-red-50)' }}; border: 1px solid {{ $request->status === 'approved' ? 'var(--sp-teal-200)' : 'var(--sp-red-200)' }};">
                                                    <div class="sp-card-content" style="padding: var(--space-3);">
                                                        <p class="sp-text-sm" style="color: {{ $request->status === 'approved' ? 'var(--sp-teal-700)' : 'var(--sp-red-700)' }};">
                                                            <strong>Resposta:</strong> {{ $request->response_message }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Informações do Grupo --}}
                            <div class="sp-card sp-mt-4" style="background: var(--sp-ivory); border: 1px solid var(--sp-gray-200);">
                                <div class="sp-card-header">
                                    <h4 class="sp-text-lg sp-font-semibold" style="color: var(--sp-red);"> Informações do Grupo</h4>
                                </div>
                                <div class="sp-card-content">
                                    <div class="sp-grid sp-grid-2">
                                        <div class="sp-flex sp-items-center sp-mb-2">
                                            <span class="sp-icon"></span>
                                            <span class="sp-text-sm">
                                                <strong>Categoria:</strong> {{ $request->group->getCategoryName() }}
                                            </span>
                                        </div>
                                        
                                        @if($request->group->requires_scale)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon"></span>
                                                <span class="sp-text-sm">
                                                    <strong>Tipo:</strong> Grupo com escala
                                                </span>
                                            </div>
                                        @endif
                                        
                                        @if($request->group->coordinator_name)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon"></span>
                                                <span class="sp-text-sm">
                                                    <strong>Coordenador:</strong> {{ $request->group->coordinator_name }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        @if($request->group->coordinator_phone)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon"></span>
                                                <span class="sp-text-sm">
                                                    <strong>Contato:</strong> {{ $request->group->coordinator_phone }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($request->group->meeting_info)
                                        <div class="sp-flex sp-items-center sp-mt-3 sp-pt-3" style="border-top: 1px solid var(--sp-gray-200);">
                                            <span class="sp-icon"></span>
                                            <span class="sp-text-sm">
                                                <strong>Reuniões:</strong> {{ $request->group->meeting_info }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Ações para solicitações aprovadas --}}
                            @if($request->status === 'approved')
                                <div class="sp-alert sp-alert-success sp-mt-4">
                                    <div class="sp-alert-icon"></div>
                                    <div class="sp-alert-content">
                                        <strong>Parabéns!</strong> Você agora faz parte do grupo <strong>{{ $request->group->name }}</strong>.
                                        @if($request->group->requires_scale)
                                            Fique atento às escalas que serão publicadas pelo coordenador.
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="sp-card sp-text-center">
                        <div class="sp-card-content">
                            <div class="sp-icon-large sp-mb-4" style="color: var(--sp-gray-light);"></div>
                            <h3 class="sp-title-lg sp-mb-2">Nenhuma solicitação encontrada</h3>
                            <p class="sp-text-muted sp-mb-6">
                                Você ainda não fez nenhuma solicitação de entrada em grupos.
                            </p>
                            @if(!auth()->user()->parish_group_id)
                                <a href="{{ route('group-requests.create') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                                     Fazer Primeira Solicitação
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Call to Action --}}
        <section class="sp-section">
            <div class="sp-content-wrapper sp-text-center">
                <div class="sp-cta">
                    <h3 class="sp-cta-title">Precisa de ajuda?</h3>
                    <p class="sp-cta-text">
                        Se tiver dúvidas sobre suas solicitações, entre em contato com os coordenadores.
                    </p>
                    <a href="{{ route('groups') }}" class="sp-btn sp-btn-outline sp-btn-lg">
                         Ver Todos os Grupos
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles para Timeline --}}
    <style>
        .sp-timeline {
            position: relative;
            margin-left: 1rem;
        }
        
        .sp-timeline::before {
            content: '';
            position: absolute;
            left: 1rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--sp-gray-300);
        }
        
        .sp-timeline-item {
            position: relative;
            margin-bottom: var(--space-6);
            margin-left: var(--space-4);
        }
        
        .sp-timeline-marker {
            position: absolute;
            left: -1.375rem;
            top: 0.25rem;
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            border: 2px solid var(--sp-white);
            box-shadow: 0 0 0 2px var(--sp-gray-300);
        }
        
        .sp-timeline-marker-blue {
            background: var(--sp-blue);
        }
        
        .sp-timeline-marker-green {
            background: var(--sp-teal);
        }
        
        .sp-timeline-marker-red {
            background: var(--sp-red);
        }
        
        .sp-timeline-content {
            margin-left: var(--space-4);
        }
    </style>
@endsection
                                    </div>

                                    <!-- Timeline -->
                                    <div class="border-l-2 border-gray-200 pl-4 ml-2">
                                        <!-- Data da solicitação -->
                                        <div class="mb-4">
                                            <div class="flex items-center mb-1">
                                                <div class="w-3 h-3 bg-blue-400 rounded-full -ml-6 mr-3"></div>
                                                <span class="text-sm font-medium text-gray-900">Solicitação enviada</span>
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                {{ $request->created_at->format('d/m/Y \à\s H:i') }}
                                            </p>
                                            @if($request->message)
                                                <div class="mt-2 bg-gray-50 rounded p-3">
                                                    <p class="text-sm text-gray-700 italic">
                                                        "{{ $request->message }}"
                                                    </p>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Resposta (se houver) -->
                                        @if($request->approved_at || $request->rejected_at)
                                            <div class="mb-4">
                                                <div class="flex items-center mb-1">
                                                    @if($request->status === 'approved')
                                                        <div class="w-3 h-3 bg-green-400 rounded-full -ml-6 mr-3"></div>
                                                        <span class="text-sm font-medium text-green-700">Solicitação aprovada</span>
                                                    @else
                                                        <div class="w-3 h-3 bg-red-400 rounded-full -ml-6 mr-3"></div>
                                                        <span class="text-sm font-medium text-red-700">Solicitação rejeitada</span>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-600">
                                                    {{ ($request->approved_at ?? $request->rejected_at)->format('d/m/Y \à\s H:i') }}
                                                    @if($request->approver)
                                                        por {{ $request->approver->name }}
                                                    @endif
                                                </p>
                                                @if($request->response_message)
                                                    <div class="mt-2 bg-{{ $request->status === 'approved' ? 'green' : 'red' }}-50 rounded p-3">
                                                        <p class="text-sm text-{{ $request->status === 'approved' ? 'green' : 'red' }}-700">
                                                            <span class="font-medium">Resposta:</span> {{ $request->response_message }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Informações do grupo -->
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="font-medium text-gray-700">Categoria:</span>
                                                <span class="text-gray-600">{{ $request->group->category_name }}</span>
                                            </div>
                                            @if($request->group->requires_scale)
                                                <div>
                                                    <span class="font-medium text-gray-700">Tipo:</span>
                                                    <span class="text-gray-600">Grupo com escala</span>
                                                </div>
                                            @endif
                                            @if($request->group->coordinator_name)
                                                <div>
                                                    <span class="font-medium text-gray-700">Coordenador:</span>
                                                    <span class="text-gray-600">{{ $request->group->coordinator_name }}</span>
                                                </div>
                                            @endif
                                            @if($request->group->coordinator_phone)
                                                <div>
                                                    <span class="font-medium text-gray-700">Contato:</span>
                                                    <span class="text-gray-600">{{ $request->group->coordinator_phone }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Ações para solicitações aprovadas -->
                                    @if($request->status === 'approved')
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <div class="bg-green-50 border border-green-200 rounded p-3">
                                                <p class="text-sm text-green-800">
                                                     <span class="font-medium">Parabéns!</span> Você agora faz parte do grupo <strong>{{ $request->group->name }}</strong>.
                                                    @if($request->group->requires_scale)
                                                        Fique atento às escalas que serão publicadas.
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $requests->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4"></div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma solicitação encontrada</h3>
                            <p class="text-gray-600 mb-6">Você ainda não fez nenhuma solicitação de entrada em grupos.</p>
                            
                            <a href="{{ route('group-requests.create') }}" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                                Solicitar Entrada em Grupo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>