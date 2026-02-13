@extends('admin.layout')

@section('title', 'Solicitações do Grupo')

@section('content')
<div class="mb-4">
    <p class="admin-overline mb-1">Coordenação pastoral</p>
    <h2 class="h3 mb-0">Solicitações de ingresso</h2>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($requests->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Mensagem</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $requestItem)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $requestItem->user->name ?? 'Usuário' }}</div>
                                    <small class="text-secondary">{{ $requestItem->user->email ?? '' }}</small>
                                </td>
                                <td>{{ Str::limit($requestItem->message ?: 'Sem mensagem', 100) }}</td>
                                <td>
                                    @php $status = $requestItem->status; @endphp
                                    <span class="badge {{ $status === 'pending' ? 'text-bg-warning' : ($status === 'approved' ? 'text-bg-success' : 'text-bg-secondary') }}">{{ ucfirst($status) }}</span>
                                </td>
                                <td>{{ $requestItem->created_at->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    @if($requestItem->status === 'pending')
                                        <div class="btn-group btn-group-sm" role="group">
                                            <form method="POST" action="{{ route('admin.coordenador.requests.approve', $requestItem) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary">Aprovar</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.coordenador.requests.reject', $requestItem) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Rejeitar</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-secondary small">Concluída</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhuma solicitação encontrada para seu grupo.</div>
        @endif
    </div>
</div>

@if($requests->hasPages())
    <div class="mt-4">{{ $requests->links() }}</div>
@endif
@endsection
