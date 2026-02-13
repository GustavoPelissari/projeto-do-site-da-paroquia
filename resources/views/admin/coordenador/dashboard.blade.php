@extends('admin.layout')

@section('title', 'Painel do Coordenador')

@section('content')
<section class="card mb-4 overflow-hidden">
    <div class="card-body p-4 p-lg-5" style="background: linear-gradient(135deg, #6b1129 0%, #7b1430 55%, #8f1d3b 100%); color: #fff;">
        <p class="text-uppercase small mb-2" style="letter-spacing: .08em; opacity: .85;">Área do coordenador</p>
        <h2 class="display-6 mb-2 text-white">Bem-vindo, {{ auth()->user()->name }}</h2>
        <p class="mb-0" style="max-width: 65ch; color: #f1e3e7;">
            @if($group)
                Gestão da pastoral <strong>{{ $group->name }}</strong>: acompanhe membros, solicitações, conteúdos e escalas.
            @else
                Associe seu usuário a um grupo para liberar todos os recursos de coordenação.
            @endif
        </p>
    </div>
</section>

<section class="row g-3 mb-4">
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Membros do grupo</small><div class="display-6 fw-semibold text-primary">{{ $stats['total_coroinhas'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Membros ativos</small><div class="display-6 fw-semibold text-primary">{{ $stats['coroinhas_ativos'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Solicitações pendentes</small><div class="display-6 fw-semibold text-primary">{{ $stats['solicitacoes_pendentes'] ?? 0 }}</div></div></div></div>
    <div class="col-12 col-md-6 col-xl-3"><div class="card h-100"><div class="card-body"><small class="text-secondary">Escalas PDF ativas</small><div class="display-6 fw-semibold text-primary">{{ $stats['escalas_ativas'] ?? 0 }}</div></div></div></div>
</section>

<section class="row g-4">
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Últimas notícias do grupo</h3>
                <a href="{{ route('admin.coordenador.news.index') }}" class="btn btn-sm btn-outline-primary">Abrir</a>
            </div>
            <div class="card-body p-0">
                @if($recent_news->count())
                    <ul class="list-group list-group-flush">
                        @foreach($recent_news as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $item->title }}</div>
                                    <small class="text-secondary">{{ Str::limit(strip_tags($item->content), 85) }}</small>
                                </div>
                                <small class="text-secondary">{{ $item->created_at->format('d/m') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-3 text-secondary mb-0">Nenhuma notícia cadastrada para este grupo.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Próximos eventos do grupo</h3>
                <a href="{{ route('admin.coordenador.events.index') }}" class="btn btn-sm btn-outline-primary">Abrir</a>
            </div>
            <div class="card-body p-0">
                @if($upcoming_events->count())
                    <ul class="list-group list-group-flush">
                        @foreach($upcoming_events as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    <small class="text-secondary">{{ $event->location ?: 'Local a definir' }}</small>
                                </div>
                                <small class="text-secondary">{{ $event->start_date?->format('d/m') }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="p-3 text-secondary mb-0">Nenhum evento próximo cadastrado.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
