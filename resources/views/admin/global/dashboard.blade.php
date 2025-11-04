@extends('admin.layout')

@section('title', 'Painel do Padre - Admin Global')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Hero Header - Boas-vindas Padre -->
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 20px; overflow: hidden;">
        <div class="card-body text-white py-5 px-4 position-relative">
            <!-- Padrão decorativo de fundo -->
            <div style="position: absolute; top: 0; right: 0; width: 300px; height: 300px; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22 opacity=%220.1%22>✟</text></svg>'); background-size: contain; opacity: 0.15;"></div>
            
            <div class="row align-items-center position-relative">
                <div class="col-lg-8">
                    <!-- Ícone e saudação -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-white bg-opacity-20 p-3 rounded-circle me-3" style="backdrop-filter: blur(10px);">
                            <i class="bi bi-person-badge-fill" style="font-size: 2.5rem; color: #FFD66B;"></i>
                        </div>
                        <div>
                            <h1 class="display-4 fw-bold mb-0" style="color: #FFFFFF; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                                Bem-vindo, {{ str_replace('Padre ', '', Auth::user()->name) }}!
                            </h1>
                            <p class="lead mb-0 mt-2" style="color: #FFD66B; font-weight: 500;">
                                <i class="bi bi-shield-fill-check me-2"></i>Administrador Global da Paróquia
                            </p>
                        </div>
                    </div>
                    
                    <!-- Mensagem inspiradora -->
                    <div class="mt-4 p-3 bg-white bg-opacity-10 rounded-3" style="backdrop-filter: blur(10px); border-left: 4px solid #FFD66B;">
                        <p class="mb-0 fst-italic" style="color: #FFFFFF; font-size: 1.1rem; line-height: 1.6;">
                            <i class="bi bi-quote" style="font-size: 1.5rem; opacity: 0.7;"></i>
                            "Combati o bom combate, terminei a corrida, guardei a fé."
                            <span class="d-block text-end mt-2" style="color: #FFFFFF; font-size: 0.9rem; opacity: 0.9;">- 2 Timóteo 4:7</span>
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
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['users_count'] }}</h3>
                    <p class="text-muted mb-0">Fiéis Cadastrados</p>
                    <small class="text-muted">Total de membros da comunidade</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-diagram-3-fill text-success" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['groups_count'] }}</h3>
                    <p class="text-muted mb-0">Grupos Ativos</p>
                    <small class="text-muted">Pastorais e ministérios em atividade</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-peace text-danger" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['masses_count'] }}</h3>
                    <p class="text-muted mb-0">Horários de Missa</p>
                    <small class="text-muted">Celebrações semanais ativas</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                            <i class="bi bi-calendar-event-fill text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold text-brand-vinho mb-2">{{ $stats['upcoming_events'] }}</h3>
                    <p class="text-muted mb-0">Próximos Eventos</p>
                    <small class="text-muted">Eventos programados</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
