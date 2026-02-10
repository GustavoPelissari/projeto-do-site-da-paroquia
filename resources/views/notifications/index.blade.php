@extends('layout')

@section('title', 'Notificações - Paróquia São Paulo Apóstolo')

@section('content')
<div class="container py-5">
    <section class="section-paroquia">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1><i class="bi bi-bell me-2" aria-hidden="true"></i> Minhas Notificações</h1>
                <p class="lead mb-0">Acompanhe atualizações de notícias, eventos, escalas e solicitações</p>
            </div>
            @if($unreadCount > 0)
                <span class="badge bg-danger fs-5 px-3 py-2">
                    {{ $unreadCount }} não {{ $unreadCount === 1 ? 'lida' : 'lidas' }}
                </span>
            @else
                <span class="badge bg-success fs-6 px-3 py-2">
                    <i class="bi bi-check-circle me-1" aria-hidden="true"></i> Tudo em dia!
                </span>
            @endif
        </div>
    </section>

    <section class="section-paroquia">
        @forelse($notifications as $n)
            <div class="card-paroquia mb-3 {{ $n->read_at ? '' : 'border border-2' }}" style="border-color: {{ $n->read_at ? 'transparent' : 'var(--dourado-suave)' }};">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="rounded-circle circle-center me-3" style="width: 40px; height: 40px; background: var(--bg-rose);">
                            @php
                                $icon = 'bi-bell';
                                if ($n->type === 'news_published') $icon = 'bi-newspaper';
                                elseif ($n->type === 'event_published') $icon = 'bi-calendar-event';
                                elseif ($n->type === 'scale_published') $icon = 'bi-file-earmark-pdf';
                                elseif ($n->type === 'group_request_status_changed') $icon = 'bi-clipboard-check';
                            @endphp
                            <i class="bi {{ $icon }}" style="color: var(--brand-vinho) !important;" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h5 class="mb-1" style="color: var(--brand-vinho);">{{ $n->title }}</h5>
                            <p class="text-muted mb-1 small">{{ $n->message }}</p>
                            <p class="text-muted small mb-0"><i class="bi bi-clock me-1" aria-hidden="true"></i>{{ $n->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @if(!$n->read_at)
                        <form action="{{ route('notifications.read', $n) }}" method="POST">
                            @csrf
                            <button class="btn btn-sm btn-outline-secondary" style="border-color: var(--brand-vinho); color: var(--brand-vinho);">
                                <i class="bi bi-check2-circle me-1" aria-hidden="true"></i> Marcar como lida
                            </button>
                        </form>
                    @else
                        <span class="badge bg-secondary">Lida</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="card-paroquia text-center">
                <div class="card-body py-5">
                    <div class="mb-3" style="font-size: 3rem; color: #9ca3af;"><i class="bi bi-bell" aria-hidden="true"></i></div>
                    <h3 class="h4 mb-2">Nenhuma notificação</h3>
                    <p class="text-muted mb-0">Você verá aqui todas as novidades e atualizações do sistema.</p>
                </div>
            </div>
        @endforelse
        @if($notifications->hasPages())
            <div class="d-flex justify-content-center mt-3">{{ $notifications->links() }}</div>
        @endif
    </section>
</div>
@endsection