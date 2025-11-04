@extends('admin.layout')

@section('title', 'Solicitações - Coordenador')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="bi bi-envelope-check"></i>
            Solicitações de Entrada
        </h1>
        <p class="page-description">Gerencie as solicitações de entrada para {{ Auth::user()->parishGroup->name ?? 'seu grupo' }}</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-clock-history"></i>
            Solicitações Pendentes
        </h3>
        <span class="badge bg-warning">{{ $requests->total() }} pendente(s)</span>
    </div>
    
    <div class="card-body p-0">
        @if($requests->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Solicitante</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Data</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-2">
                                        {{ substr($request->user->name, 0, 1) }}
                                    </div>
                                    <strong>{{ $request->user->name }}</strong>
                                </div>
                            </td>
                            <td>{{ $request->user->email }}</td>
                            <td>{{ $request->user->phone ?? 'Não informado' }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $request->created_at->format('d/m/Y H:i') }}
                                    <br>
                                    <em>{{ $request->created_at->diffForHumans() }}</em>
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <form action="{{ route('admin.coordenador.requests.approve', $request) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Aprovar">
                                            <i class="bi bi-check-circle"></i>
                                            Aprovar
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.coordenador.requests.reject', $request) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Tem certeza que deseja rejeitar esta solicitação?')" 
                                                title="Rejeitar">
                                            <i class="bi bi-x-circle"></i>
                                            Rejeitar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                {{ $requests->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">✅</div>
                <h3>Nenhuma solicitação pendente</h3>
                <p>Não há solicitações de entrada aguardando sua análise no momento.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        color: var(--color-text-primary);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: var(--color-text-secondary);
        max-width: 500px;
        margin: 0 auto;
    }
</style>
@endsection
