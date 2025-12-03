@extends('layout')

@section('title', 'Minhas Solicitações - Paróquia São Paulo Apóstolo')

@section('content')
    <div class="container py-5">
        {{-- Header Section --}}
        <section class="section-paroquia">
            <div class="section-header">
                <h1><i class="bi bi-clipboard-check me-2"></i> Minhas Solicitações</h1>
                <p class="lead">Acompanhe o status das suas solicitações de entrada em grupos e pastorais</p>
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
            <section class="section-paroquia">
                <div class="card-paroquia text-center">
                    <div class="card-body py-4">
                        <h3 class="fw-semibold mb-2" style="color: var(--brand-vinho);">
                            <i class="bi bi-people me-2"></i> Quer participar de mais grupos?
                        </h3>
                        <p class="text-muted mb-3">Envie uma nova solicitação para se juntar a outros grupos da nossa paróquia.</p>
                        <a href="{{ route('group-requests.create') }}" class="btn-paroquia btn-primary-paroquia btn-lg">
                            <i class="bi bi-plus-circle me-2"></i> Nova Solicitação
                        </a>
                    </div>
                </div>
            </section>
        @endif

        {{-- Main Content --}}
        <section class="section-paroquia">
            <div class="section-content">
                @forelse($requests as $request)
                    <div class="card-paroquia mb-4 status-{{ $request->status }} shadow-sm" style="border-radius: 16px; overflow: hidden;">
                        
                        {{-- Header --}}
                        <div class="card-header-paroquia" style="background: linear-gradient(135deg, var(--brand-vinho) 0%, #6B0F2A 100%); color: #fff;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="h5 mb-1 text-white"><i class="bi bi-bank me-2"></i>{{ $request->group->name }}</h3>
                                    <p class="small mb-0" style="color: #FFD66B;">
                                        <i class="bi bi-calendar me-1"></i>
                                        Solicitado em {{ $request->created_at?->format('d/m/Y') }} às {{ $request->created_at?->format('H:i') }}
                                    </p>
                                </div>
                                <span class="badge bg-{{ $request->status === 'pending' ? 'warning' : ($request->status === 'approved' ? 'success' : 'danger') }} rounded-pill px-3 py-2 align-self-start">
                                    @if($request->status === 'pending')
                                        <i class="bi bi-clock"></i> Pendente
                                    @elseif($request->status === 'approved')
                                        <i class="bi bi-check-circle"></i> Aprovada
                                    @else
                                        <i class="bi bi-x-circle"></i> Rejeitada
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="card-body p-4">
                            
                            {{-- Timeline --}}
                            <div class="sp-timeline" style="margin-left: 1.25rem;">
                                {{-- Solicitação Enviada --}}
                                <div class="sp-timeline-item">
                                    <div class="sp-timeline-marker sp-timeline-marker-blue"></div>
                                    <div class="sp-timeline-content">
                                        <h6 class="fw-semibold" style="color: var(--brand-vinho);"><i class="bi bi-envelope me-2"></i> Solicitação Enviada</h6>
                                        <p class="small text-muted mb-2">
                                            {{ $request->created_at?->format('d/m/Y') }} às {{ $request->created_at?->format('H:i') }}
                                        </p>
                                        @if($request->message)
                                            <div class="card mb-3" style="background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 10px;">
                                                <div class="card-body py-2 px-3">
                                                    <p class="small fst-italic text-muted mb-0">"{{ $request->message }}"</p>
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
                                            <h6 class="fw-semibold status-title-{{ $request->status }} mb-1">
                                                @if($request->status === 'approved')
                                                    <i class="bi bi-check-circle me-2"></i> Solicitação Aprovada
                                                @else
                                                    <i class="bi bi-x-circle me-2"></i> Solicitação Rejeitada
                                                @endif
                                            </h6>
                                            <p class="small text-muted mb-2">
                                                @if($statusAt)
                                                    {{ $statusAt->format('d/m/Y') }} às {{ $statusAt->format('H:i') }}
                                                @endif
                                                @if($request->approver)
                                                    por {{ $request->approver->name }}
                                                @endif
                                            </p>
                                            @if($request->response_message)
                                                <div class="card mb-3 response-card response-{{ $request->status }}" style="border-radius: 10px;">
                                                    <div class="card-body py-2 px-3">
                                                        <p class="small mb-0 response-text-{{ $request->status }}">
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
                            <div class="card mt-3" style="background: var(--bg-rose); border: 1px solid rgba(139, 30, 63, 0.2); border-radius: 12px;">
                                <div class="card-header py-2" style="background: rgba(139, 30, 63, 0.06);">
                                    <h6 class="mb-0 fw-semibold" style="color: var(--brand-vinho);">
                                        <i class="bi bi-book me-2"></i> Informações do Grupo
                                    </h6>
                                </div>
                                <div class="card-body px-3">
                                    <div class="row">
                                        <div class="col-md-6 mb-2 small">
                                            <i class="bi bi-tag me-2" style="color: var(--brand-vinho);"></i>
                                            <strong>Categoria:</strong> {{ $request->group->category_name }}
                                        </div>
                                        @if($request->group->requires_scale)
                                        <div class="col-md-6 mb-2 small">
                                            <i class="bi bi-calendar-event me-2" style="color: var(--brand-vinho);"></i>
                                            <strong>Tipo:</strong> Grupo com escala
                                        </div>
                                        @endif
                                        @if($request->group->coordinator_name)
                                        <div class="col-md-6 mb-2 small">
                                            <i class="bi bi-person-fill me-2" style="color: var(--brand-vinho);"></i>
                                            <strong>Coordenador:</strong> {{ $request->group->coordinator_name }}
                                        </div>
                                        @endif
                                        @if($request->group->coordinator_phone)
                                        <div class="col-md-6 mb-2 small">
                                            <i class="bi bi-telephone me-2" style="color: var(--brand-vinho);"></i>
                                            <strong>Contato:</strong> {{ $request->group->coordinator_phone }}
                                        </div>
                                        @endif
                                    </div>
                                    @if($request->group->meeting_info)
                                    <div class="small mt-2 pt-2 border-top">
                                        <i class="bi bi-calendar-check me-2" style="color: var(--brand-vinho);"></i>
                                        <strong>Reuniões:</strong> {{ $request->group->meeting_info }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Ações para solicitações aprovadas --}}
                            @if($request->status === 'approved')
                                <div class="alert alert-success mt-3" style="border-radius: 12px;">
                                    <i class="bi bi-emoji-smile me-2"></i>
                                    <strong>Parabéns!</strong> Você agora faz parte do grupo <strong>{{ $request->group->name }}</strong>.
                                    @if($request->group->requires_scale)
                                        Fique atento às escalas que serão publicadas pelo coordenador.
                                    @endif
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
        <section class="section-paroquia">
            <div class="card-paroquia text-center">
                <div class="card-body py-4">
                    <h3 class="fw-semibold mb-2" style="color: var(--brand-vinho);">
                        <i class="bi bi-question-circle me-2"></i> Precisa de ajuda?
                    </h3>
                    <p class="text-muted mb-3">Se tiver dúvidas sobre suas solicitações, entre em contato com os coordenadores.</p>
                    <a href="{{ route('groups') }}" class="btn btn-outline-secondary px-4" style="border: 2px solid var(--brand-vinho); color: var(--brand-vinho);">
                        <i class="bi bi-book me-2"></i> Ver Todos os Grupos
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- Custom Styles para Timeline --}}
    <style>
        /* Status border colors for each request card */
        .status-pending { border-left: 4px solid #FFD66B; }
        .status-approved { border-left: 4px solid #28a745; }
        .status-rejected { border-left: 4px solid #dc3545; }

        /* Titles per status */
        .status-title-approved { color: #28a745; }
        .status-title-rejected { color: #dc3545; }

        /* Response chip styles */
        .response-card.response-approved { background: rgba(40, 167, 69, 0.08); border: 1px solid #28a745; }
        .response-card.response-rejected { background: rgba(220, 53, 69, 0.08); border: 1px solid #dc3545; }
        .response-text-approved { color: #1f7a35; }
        .response-text-rejected { color: #a3202f; }
        .sp-timeline {
            position: relative;
            margin-left: 1rem;
        }
        
        .sp-timeline::before {
            display: none; /* remover a linha vertical de fundo */
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
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e5e7eb;
        }
        
        .sp-timeline-marker-blue {
            background: #0d6efd;
        }
        
        .sp-timeline-marker-green {
            background: #28a745;
        }
        
        .sp-timeline-marker-red {
            background: #dc3545;
        }
        
        .sp-timeline-content {
            margin-left: var(--space-4);
        }
    </style>
@endsection