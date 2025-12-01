@extends('layout')

@section('title', 'Minhas Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="sp-container sp-py-large">
        {{-- Hero Section --}}
        <section class="sp-hero">
            <div class="sp-hero-content">
                <h1 class="sp-hero-title">📋 Minhas Solicitações</h1>
                <p class="sp-hero-subtitle">
                    Acompanhe o status das suas solicitações de entrada em grupos e pastorais
                </p>
            </div>
        </section>

        {{-- Alerts --}}
        @if (session('success'))
            <x-alert type="success">
                ✅ <strong>Sucesso!</strong> {{ session('success') }}
            </x-alert>
        @endif

        @if (session('error'))
            <x-alert type="error">
                ❌ <strong>Atenção!</strong> {{ session('error') }}
            </x-alert>
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
                            ➕ Nova Solicitação
                        </a>
                    </div>
                </div>
            </section>
        @endif

        {{-- Main Content --}}
        <section class="sp-section">
            <div class="sp-content-wrapper">
                @forelse($requests as $request)
                    <div class="sp-card sp-mb-6 status-{{ $request->status }}">
                        
                        {{-- Header --}}
                        <div class="sp-card-header">
                            <div class="sp-flex sp-justify-between sp-items-start">
                                <div>
                                    <h3 class="sp-card-title">🏛️ {{ $request->group->name }}</h3>
                                    <p class="sp-text-sm sp-text-muted">
                                        Solicitado em {{ $request->created_at?->format('d/m/Y') }} às {{ $request->created_at?->format('H:i') }}
                                    </p>
                                </div>
                                
                                <div class="sp-badge sp-badge-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'error') }}">
                                    @if($request->status === 'pending')
                                        ⏳ Pendente
                                    @elseif($request->status === 'approved')
                                        ✅ Aprovada
                                    @else
                                        ❌ Rejeitada
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
                                        <h4 class="sp-font-semibold sp-text-blue-900">📝 Solicitação Enviada</h4>
                                        <p class="sp-text-sm sp-text-muted">
                                            {{ $request->created_at?->format('d/m/Y') }} às {{ $request->created_at?->format('H:i') }}
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
                                    @php $statusAt = $request->approved_at ?? $request->rejected_at; @endphp
                                    <div class="sp-timeline-item">
                                        <div class="sp-timeline-marker sp-timeline-marker-{{ $request->status === 'approved' ? 'green' : 'red' }}"></div>
                                        <div class="sp-timeline-content">
                                            <h4 class="sp-font-semibold status-title-{{ $request->status }}">
                                                @if($request->status === 'approved')
                                                    ✅ Solicitação Aprovada
                                                @else
                                                    ❌ Solicitação Rejeitada
                                                @endif
                                            </h4>
                                            <p class="sp-text-sm sp-text-muted">
                                                @if($statusAt)
                                                    {{ $statusAt->format('d/m/Y') }} às {{ $statusAt->format('H:i') }}
                                                @endif
                                                @if($request->approver)
                                                    por {{ $request->approver->name }}
                                                @endif
                                            </p>
                                            @if($request->response_message)
                                                <div class="sp-card sp-mt-3 response-chip response-{{ $request->status }}">
                                                    <div class="sp-card-content response-chip-content">
                                                        <p class="sp-text-sm response-chip-text response-chip-text-{{ $request->status }}">
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
                                    <h4 class="sp-text-lg sp-font-semibold" style="color: var(--sp-red);">📖 Informações do Grupo</h4>
                                </div>
                                <div class="sp-card-content">
                                    <div class="sp-grid sp-grid-2">
                                        <div class="sp-flex sp-items-center sp-mb-2">
                                            <span class="sp-icon">🏷️</span>
                                            <span class="sp-text-sm">
                                                <strong>Categoria:</strong> {{ $request->group->category_name }}
                                            </span>
                                        </div>
                                        
                                        @if($request->group->requires_scale)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon">📅</span>
                                                <span class="sp-text-sm">
                                                    <strong>Tipo:</strong> Grupo com escala
                                                </span>
                                            </div>
                                        @endif
                                        
                                        @if($request->group->coordinator_name)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon">👤</span>
                                                <span class="sp-text-sm">
                                                    <strong>Coordenador:</strong> {{ $request->group->coordinator_name }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        @if($request->group->coordinator_phone)
                                            <div class="sp-flex sp-items-center sp-mb-2">
                                                <span class="sp-icon">📞</span>
                                                <span class="sp-text-sm">
                                                    <strong>Contato:</strong> {{ $request->group->coordinator_phone }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    @if($request->group->meeting_info)
                                        <div class="sp-flex sp-items-center sp-mt-3 sp-pt-3" style="border-top: 1px solid var(--sp-gray-200);">
                                            <span class="sp-icon">📅</span>
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
                                    <div class="sp-alert-icon">🎉</div>
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
                            <div class="sp-icon-large sp-mb-4" style="color: var(--sp-gray-light);">📝</div>
                            <h3 class="sp-title-lg sp-mb-2">Nenhuma solicitação encontrada</h3>
                            <p class="sp-text-muted sp-mb-6">
                                Você ainda não fez nenhuma solicitação de entrada em grupos.
                            </p>
                            @if(!auth()->user()->parish_group_id)
                                <a href="{{ route('group-requests.create') }}" class="sp-btn sp-btn-gold sp-btn-lg">
                                    📝 Fazer Primeira Solicitação
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
                        📖 Ver Todos os Grupos
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles para Timeline --}}
    <style>
        /* Status border colors for each request card */
        .status-pending { border-left: 4px solid var(--sp-gold); }
        .status-approved { border-left: 4px solid var(--sp-teal); }
        .status-rejected { border-left: 4px solid var(--sp-red); }

        /* Titles per status */
        .status-title-approved { color: var(--sp-teal); }
        .status-title-rejected { color: var(--sp-red); }

        /* Response chip styles */
        .response-chip { border: 1px solid transparent; }
        .response-chip-content { padding: var(--space-3); }
        .response-chip.response-approved { background: var(--sp-teal-50); border-color: var(--sp-teal-200); }
        .response-chip.response-rejected { background: var(--sp-red-50); border-color: var(--sp-red-200); }
        .response-chip-text-approved { color: var(--sp-teal-700); }
        .response-chip-text-rejected { color: var(--sp-red-700); }
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