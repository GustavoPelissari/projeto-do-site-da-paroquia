@extends('layout')

@section('title', 'Escalas - ' . $group->name)

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Escalas - {{ $group->name }}</h1>
        <p class="lead text-muted">{{ $group->description }}</p>
    </div>

    @if($currentSchedule)
        <!-- Escala Atual -->
        <div class="p-4 p-lg-5 rounded-3 text-white mb-4" style="background: linear-gradient(90deg, #0d6efd 0%, #0b5ed7 100%);">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
                <div>
                    <h2 class="h4 fw-bold mb-2">📅 Escala Atual</h2>
                    <h3 class="h5 fw-semibold mb-3">{{ $currentSchedule->title }}</h3>
                    <p class="text-white-50 mb-3">
                        Período: {{ $currentSchedule->start_date->format('d/m/Y') }} - {{ $currentSchedule->end_date->format('d/m/Y') }}
                    </p>
                    @if($currentSchedule->description)
                        <p class="text-white-50 mb-0">{{ $currentSchedule->description }}</p>
                    @endif
                </div>
                
                <div class="text-lg-end">
                    <a href="{{ $currentSchedule->getPdfUrl() }}" target="_blank"
                       class="btn btn-light btn-lg d-inline-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf me-2" aria-hidden="true"></i>
                        Ver PDF Oficial
                    </a>
                    <p class="text-white-50 small mt-2 mb-0">Arquivo: {{ $currentSchedule->pdf_filename }}</p>
                </div>
            </div>
        </div>

        <!-- Aviso Importante -->
        <div class="alert alert-warning d-flex align-items-start mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2 mt-1" aria-hidden="true"></i>
            <div class="small">
                <strong>Importante:</strong> Sempre consulte o PDF oficial para informações atualizadas sobre a escala. 
                O documento em PDF é a fonte oficial e pode conter alterações de última hora.
            </div>
        </div>
    @endif

    <!-- Todas as Escalas -->
    @if($schedules->count() > 0)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h2 class="h5 mb-0">Histórico de Escalas</h2>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($schedules as $schedule)
                    @php
                        $status = $schedule->getStatusBadge();
                        $statusClass = [
                            'gray' => 'secondary',
                            'blue' => 'primary',
                            'red' => 'danger',
                            'green' => 'success',
                        ][$status['color']] ?? 'secondary';
                    @endphp
                    <li class="list-group-item">
                        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                            <div class="flex-grow-1">
                                <h3 class="h6 fw-semibold mb-1">{{ $schedule->title }}</h3>
                                
                                <div class="d-flex flex-wrap gap-3 text-muted small mb-2">
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-calendar-event" aria-hidden="true"></i>
                                        {{ $schedule->start_date->format('d/m/Y') }} - {{ $schedule->end_date->format('d/m/Y') }}
                                    </span>
                                    <span class="d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-clock" aria-hidden="true"></i>
                                        Criada em {{ $schedule->created_at->format('d/m/Y') }}
                                    </span>
                                </div>

                                @if($schedule->description)
                                    <p class="text-muted small mb-0">{{ $schedule->description }}</p>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <span class="badge bg-{{ $statusClass }}">
                                    {{ $status['text'] }}
                                </span>

                                <a href="{{ $schedule->getPdfUrl() }}" target="_blank"
                                   class="btn btn-primary btn-sm d-inline-flex align-items-center">
                                    <i class="bi bi-download me-1" aria-hidden="true"></i>
                                    PDF
                                </a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="text-center py-5">
            <div class="text-muted fs-1 mb-3">📋</div>
            <h3 class="h5 fw-semibold mb-2">Nenhuma escala disponível</h3>
            <p class="text-muted mb-0">
                As escalas para {{ $group->name }} ainda não foram publicadas.
            </p>
        </div>
    @endif

    <!-- Informações do Grupo -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="h5 mb-3">Sobre o Grupo</h2>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <h3 class="h6 fw-semibold mb-2">Informações Gerais</h3>
                    <div class="d-grid gap-2 small">
                        <div>
                            <span class="fw-semibold text-muted">Categoria:</span>
                            <span class="text-muted">{{ $group->category_name }}</span>
                        </div>
                        @if($group->meeting_info)
                            <div>
                                <span class="fw-semibold text-muted">Reuniões:</span>
                                <span class="text-muted">{{ $group->meeting_info }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="fw-semibold text-muted">Membros:</span>
                            <span class="text-muted">{{ $group->getMembersCount() }} pessoas</span>
                        </div>
                    </div>
                </div>

                @if($group->coordinator_name || $group->coordinator_phone || $group->coordinator_email)
                    <div class="col-md-6">
                        <h3 class="h6 fw-semibold mb-2">Coordenação</h3>
                        <div class="d-grid gap-2 small">
                            @if($group->coordinator_name)
                                <div>
                                    <span class="fw-semibold text-muted">Coordenador:</span>
                                    <span class="text-muted">{{ $group->coordinator_name }}</span>
                                </div>
                            @endif
                            @if($group->coordinator_phone)
                                <div>
                                    <span class="fw-semibold text-muted">Telefone:</span>
                                    <a href="tel:{{ $group->coordinator_phone }}" class="link-primary">
                                        {{ $group->coordinator_phone }}
                                    </a>
                                </div>
                            @endif
                            @if($group->coordinator_email)
                                <div>
                                    <span class="fw-semibold text-muted">E-mail:</span>
                                    <a href="mailto:{{ $group->coordinator_email }}" class="link-primary">
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
                    <div class="mt-4 pt-4 border-top">
                        <div class="alert alert-primary mb-0">
                            <h4 class="h6 fw-semibold mb-2">Interessado em participar?</h4>
                            <p class="small mb-3">
                                Faça uma solicitação para entrar em {{ $group->name }} e participe das nossas atividades.
                            </p>
                            <a href="{{ route('group-requests.create') }}" class="btn btn-primary btn-sm">
                                Solicitar Entrada
                            </a>
                        </div>
                    </div>
                @endif
            @else
                <div class="mt-4 pt-4 border-top">
                    <div class="alert alert-light mb-0">
                        <h4 class="h6 fw-semibold mb-2">Quer participar?</h4>
                        <p class="small mb-3">
                            Faça login ou registre-se para solicitar entrada em {{ $group->name }}.
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                Fazer Login
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm">
                                Registrar-se
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
@endsection