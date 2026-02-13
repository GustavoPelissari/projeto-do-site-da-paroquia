@extends('admin.layout')

@section('title', 'Painel do Padre - Admin Global')

@section('content')
<section class="card mb-4 overflow-hidden">
    <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #6b1129 0%, #7b1430 55%, #8f1d3b 100%); color: #fff;">
        <p class="text-uppercase small mb-2" style="letter-spacing: .08em; opacity: .85;">Área administrativa global</p>
        <h2 class="display-6 mb-2 text-white">Bem-vindo, {{ auth()->user()->name }}</h2>
        <p class="mb-0" style="max-width: 60ch; color: #f1e3e7;">Visão consolidada para acompanhar membros, conteúdos e atividades da paróquia com clareza.</p>
    </div>
</section>

<section class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Fiéis cadastrados</small><div class="display-6 fw-semibold text-primary">{{ $stats['users_count'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Grupos ativos</small><div class="display-6 fw-semibold text-primary">{{ $stats['groups_count'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Horários de missa</small><div class="display-6 fw-semibold text-primary">{{ $stats['masses_count'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Eventos futuros</small><div class="display-6 fw-semibold text-primary">{{ $stats['upcoming_events'] ?? 0 }}</div></div></div></div>
</section>

<section class="row g-4 mb-4">
    <div class="col-12 col-xl-7">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Ações rápidas</h3>
                <span class="text-secondary small">Atalhos principais</span>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6 d-grid"><a href="{{ route('admin.global.news.create') }}" class="btn btn-outline-primary"><i class="bi bi-newspaper me-1"></i>Nova notícia</a></div>
                    <div class="col-md-6 d-grid"><a href="{{ route('admin.global.events.create') }}" class="btn btn-outline-primary"><i class="bi bi-calendar-plus me-1"></i>Novo evento</a></div>
                    <div class="col-md-6 d-grid"><a href="{{ route('admin.global.groups.index') }}" class="btn btn-outline-primary"><i class="bi bi-people me-1"></i>Gerenciar grupos</a></div>
                    <div class="col-md-6 d-grid"><a href="{{ route('admin.global.masses.index') }}" class="btn btn-outline-primary"><i class="bi bi-clock-history me-1"></i>Horários de missa</a></div>
                    <div class="col-md-6 d-grid"><a href="{{ route('admin.global.users') }}" class="btn btn-outline-secondary"><i class="bi bi-person-gear me-1"></i>Usuários</a></div>
                    <div class="col-md-6 d-grid"><a href="{{ route('home') }}" class="btn btn-outline-secondary"><i class="bi bi-globe me-1"></i>Ver site público</a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-5">
        <div class="card h-100">
            <div class="card-header"><h3 class="h5 mb-0">Solicitações pendentes</h3></div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Aguardando aprovação</span>
                    <span class="badge text-bg-warning">{{ $stats['pending_requests'] ?? 0 }}</span>
                </div>
                @if($recent_requests->count())
                    <ul class="list-group list-group-flush">
                        @foreach($recent_requests as $request)
                            <li class="list-group-item px-0">
                                <div class="fw-semibold">{{ $request->user->name ?? 'Usuário' }}</div>
                                <small class="text-secondary">{{ $request->group->name ?? 'Grupo não informado' }} · {{ $request->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-secondary mb-0">Sem solicitações recentes.</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="row g-4">
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header"><h3 class="h5 mb-0">Últimas notícias</h3></div>
            <div class="card-body p-0">
                @if($recent_news->count())
                    <ul class="list-group list-group-flush">
                        @foreach($recent_news as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <small class="text-secondary">{{ $item->user->name ?? 'Sem autor' }}</small>
                                </div>
                                <small class="text-secondary">{{ $item->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-3 text-secondary mb-0">Nenhuma notícia publicada recentemente.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header"><h3 class="h5 mb-0">Próximos eventos</h3></div>
            <div class="card-body p-0">
                @if($upcoming_events->count())
                    <ul class="list-group list-group-flush">
                        @foreach($upcoming_events as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    <small class="text-secondary">{{ $event->location ?: 'Local a definir' }}</small>
                                </div>
                                <small class="text-secondary">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-3 text-secondary mb-0">Nenhum evento futuro cadastrado.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
