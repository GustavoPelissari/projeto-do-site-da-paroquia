@extends('admin.layout')

@section('title', 'Eventos do grupo')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <p class="admin-overline mb-1">Coordenação pastoral</p>
        <h2 class="h3 mb-0">Eventos do grupo</h2>
    </div>
    <span class="badge text-bg-light border">Criação disponível em breve</span>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($events->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Evento</th>
                            <th>Data</th>
                            <th>Local</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $event->title }}</div>
                                    <small class="text-secondary">{{ Str::limit($event->description, 90) }}</small>
                                </td>
                                <td>{{ $event->start_date?->format('d/m/Y H:i') ?: '—' }}</td>
                                <td>{{ $event->location ?: '—' }}</td>
                                <td><span class="badge text-bg-secondary">{{ ucfirst($event->status ?? 'agendado') }}</span></td>
                                <td class="text-end">
                                    <span class="text-secondary small">Edição indisponível</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhum evento cadastrado para o seu grupo.</div>
        @endif
    </div>
</div>

@if($events->hasPages())
    <div class="mt-4">{{ $events->links() }}</div>
@endif
@endsection
