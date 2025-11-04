@extends('admin.layout')

@section('title', 'Painel do Padre - Admin Global')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #A91B47 50%, #D4AF37 100%);">
        <div class="card-body text-white text-center py-5">
            <h1 class="display-5 fw-bold mb-2"> Bem-vindo, Padre {{ Auth::user()->name }}!</h1>
            <p class="lead mb-0" style="color: #F4D03F;">Painel de Administração Global - Paróquia São Paulo Apóstolo</p>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.3);">
            <p class="mb-0 fst-italic">"Combati o bom combate, terminei a corrida, guardei a fé." - 2 Timóteo 4:7</p>
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
