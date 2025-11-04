@extends('admin.layout')

@section('title', 'Dashboard Coordenador')

@push('styles')
<style>
    .text-brand-vinho {
        color: #8B1538 !important;
    }
    
    .list-group-item-action:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Hero Header - Boas-vindas Coordenador -->
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 20px; overflow: hidden;">
        <div class="card-body text-white py-5 px-4 position-relative">
            <!-- Padrão decorativo de fundo -->
            <div style="position: absolute; top: 0; right: 0; width: 300px; height: 300px; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22 opacity=%220.1%22>✟</text></svg>'); background-size: contain; opacity: 0.15;"></div>
            
            <div class="row align-items-center position-relative">
                <div class="col-lg-8">
                    <!-- Ícone e saudação -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle me-3" style="backdrop-filter: blur(10px);">
                            <i class="bi bi-person-workspace" style="font-size: 2.5rem; color: #FFD66B;"></i>
                        </div>
                        <div>
                            <h1 class="display-4 fw-bold mb-0" style="color: #FFFFFF; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                Bem-vindo, Coordenador!
                            </h1>
                            <p class="lead mb-0 mt-2" style="color: #FFD66B; font-weight: 500;">
                                <i class="bi bi-person-fill me-2"></i>{{ Auth::user()->name }}
                            </p>
                            <p class="mb-0 mt-1" style="color: #FFFFFF; font-size: 1.1rem; opacity: 0.9;">
                                <i class="bi bi-diagram-3-fill me-2"></i>{{ $stats['grupo_nome'] }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Mensagem inspiradora -->
                    <div class="mt-4 p-3 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px); border-left: 4px solid #FFD66B;">
                        <p class="mb-0 fst-italic" style="color: #FFFFFF; font-size: 1.1rem; line-height: 1.6;">
                            <i class="bi bi-quote" style="font-size: 1.5rem; opacity: 0.7;"></i>
                            "Deixai vir a mim as criancinhas e não as impeçais, porque das tais é o Reino dos céus."
                            <span class="d-block text-end mt-2" style="color: #FFFFFF; font-size: 0.9rem; opacity: 0.9;">- Mateus 19:14</span>
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-4 text-end d-none d-lg-block">
                    <div class="bg-white bg-opacity-10 p-4 rounded-3" style="backdrop-filter: blur(10px);">
                        <i class="bi bi-calendar-event" style="color: #FFFFFF; font-size: 1.2rem; opacity: 0.8;"></i>
                        <p class="mb-1 mt-2 fw-semibold" style="color: #FFFFFF; font-size: 1.1rem;">{{ now()->locale('pt_BR')->isoFormat('dddd') }}</p>
                        <p class="mb-0 h4 fw-bold" style="color: #FFD66B;">{{ now()->format('d/m/Y') }}</p>
                        <p class="mb-0 mt-1" style="color: #FFFFFF; font-size: 0.9rem; opacity: 0.9;">{{ now()->format('H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['membros_grupo'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Membros do Grupo</p>
                    <small class="text-muted">Total de integrantes</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-newspaper text-info" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['noticias_grupo'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Notícias do Grupo</p>
                    <small class="text-muted">Publicações realizadas</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-calendar-event text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['eventos_grupo'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Eventos do Grupo</p>
                    <small class="text-muted">Atividades programadas</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-clipboard-check text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['solicitacoes_pendentes'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Solicitações Pendentes</p>
                    <small class="text-muted">Aguardando aprovação</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Notícias Recentes -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-newspaper text-primary me-2"></i>
                Notícias Recentes da Paróquia
            </h5>
        </div>
        <div class="card-body p-0">
            @if($recent_news && $recent_news->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recent_news as $news)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-semibold">{{ $news->title }}</h6>
                                    <p class="mb-2 text-muted small">{{ $news->excerpt ?: Str::limit($news->content, 120) }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $news->created_at->format('d/m/Y') }}
                                        <i class="bi bi-clock ms-2 me-1"></i>{{ $news->created_at->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-newspaper text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 text-muted">Nenhuma notícia recente</h5>
                    <p class="text-muted mb-0">Não há notícias publicadas recentemente.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Próximos Eventos -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-calendar-event text-success me-2"></i>
                Próximos Eventos da Paróquia
            </h5>
        </div>
        <div class="card-body p-0">
            @if($upcoming_events && $upcoming_events->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($upcoming_events as $event)
                        <div class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-semibold">{{ $event->title }}</h6>
                                    @if($event->location)
                                        <p class="mb-1 small">
                                            <i class="bi bi-geo-alt text-danger me-1"></i>
                                            <span class="text-muted">{{ $event->location }}</span>
                                        </p>
                                    @endif
                                    <p class="mb-2 text-muted small">{{ Str::limit($event->description, 120) }}</p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $event->start_date->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-event text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 text-muted">Nenhum evento próximo</h5>
                    <p class="text-muted mb-0">Não há eventos programados no momento.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Escalas do Grupo -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                    Escalas do Grupo
                </h5>
                <a href="{{ route('admin.coordenador.scales.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-right-circle me-1"></i>Ver Todas
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($scales && $scales->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($scales as $scale)
                        <div class="list-group-item px-0 border-0 border-bottom py-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 2.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-2 fw-semibold">{{ $scale->title }}</h6>
                                    @if($scale->description)
                                        <p class="mb-2 text-muted small">{{ Str::limit($scale->description, 100) }}</p>
                                    @endif
                                    <div class="d-flex gap-3 align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            @if($scale->valid_from && $scale->valid_until)
                                                {{ $scale->valid_from->format('d/m/Y') }} até {{ $scale->valid_until->format('d/m/Y') }}
                                            @elseif($scale->valid_from)
                                                A partir de {{ $scale->valid_from->format('d/m/Y') }}
                                            @else
                                                Enviado em {{ $scale->created_at->format('d/m/Y') }}
                                            @endif
                                        </small>
                                        @if($scale->isValid())
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Ativo
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.coordenador.scales.download', $scale) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar3 text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h5 class="mt-3 text-muted">Nenhuma escala enviada</h5>
                    <p class="text-muted mb-3">Organize as escalas de atividades do seu grupo</p>
                    <a href="{{ route('admin.coordenador.scales.index') }}" class="btn btn-primary">
                        <i class="bi bi-calendar-plus me-2"></i>Gerenciar Escalas
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
