@extends('admin.layout')

@section('title', 'Solicitações - Coordenador')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 15px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h2 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-envelope-check" aria-hidden="true"></i> Solicitações de Entrada
                    </h1>
                    <p class="mb-0" style="color: #FFD66B;">
                        Gerencie as solicitações de entrada para {{ Auth::user()->parishGroup->name ?? 'seu grupo' }}
                    </p>
                </div>
                @if($requests->count() > 0)
                <span class="badge bg-warning text-dark fs-5 px-3 py-2">
                    {{ $requests->total() }} pendente(s)
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="card border-0 shadow-sm">
        @if($requests->count() > 0)
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-clock-history text-warning" aria-hidden="true"></i> Solicitações Pendentes
                </h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="px-4 py-3">Solicitante</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Telefone</th>
                                <th class="py-3">Data</th>
                                <th class="text-center py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white fw-bold me-3" 
                                             style="width: 45px; height: 45px; background: linear-gradient(135deg, #8B1538 0%, #6B0F2A 100%); font-size: 1.2rem;">
                                            {{ substr($request->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong class="d-block">{{ $request->user->name }}</strong>
                                            <small class="text-muted">ID: {{ $request->user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope text-muted me-1" aria-hidden="true"></i>
                                    {{ $request->user->email }}
                                </td>
                                <td>
                                    <i class="bi bi-telephone text-muted me-1" aria-hidden="true"></i>
                                    {{ $request->user->phone ?? 'Não informado' }}
                                </td>
                                <td>
                                    <div>
                                        <i class="bi bi-calendar-event text-muted me-1" aria-hidden="true"></i>
                                        <small>{{ $request->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <small class="text-muted fst-italic">
                                        {{ $request->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <!-- Aprovar -->
                                        <form action="{{ route('admin.coordenador.requests.approve', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Aprovar e adicionar ao grupo imediatamente">
                                                <i class="bi bi-check-circle-fill" aria-hidden="true"></i>
                                                Aprovar
                                            </button>
                                        </form>

                                        <!-- Formação -->
                                        <button type="button" 
                                                class="btn btn-warning btn-sm text-white" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#formationModal{{ $request->id }}"
                                                title="Marcar como 'Em Formação'">
                                            <i class="bi bi-book-fill text-white" aria-hidden="true"></i>
                                            Formação
                                        </button>

                                        <!-- Rejeitar -->
                                        <form action="{{ route('admin.coordenador.requests.reject', $request) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="return confirm('Tem certeza que deseja rejeitar esta solicitação?')" 
                                                    title="Rejeitar solicitação">
                                                <i class="bi bi-x-circle-fill" aria-hidden="true"></i>
                                                Rejeitar
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal de Formação -->
                                    <div class="modal fade" id="formationModal{{ $request->id }}" tabindex="-1" aria-labelledby="formationModalLabel{{ $request->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%);">
                                                    <h5 class="modal-title text-white" id="formationModalLabel{{ $request->id }}">
                                                        <i class="bi bi-book-fill me-2" aria-hidden="true"></i>Marcar como "Em Formação"
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                </div>
                                                <form action="{{ route('admin.coordenador.requests.formation', $request) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="alert alert-info">
                                                            <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
                                                            O candidato receberá uma mensagem informando que precisa realizar formação antes de ser aprovado.
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="message{{ $request->id }}" class="form-label fw-semibold">Mensagem para o Candidato</label>
                                                            <textarea 
                                                                class="form-control" 
                                                                id="message{{ $request->id }}" 
                                                                name="message" 
                                                                rows="8"
                                                                placeholder="Você pode editar a mensagem padrão ou mantê-la">Olá {{ $request->user->name }}!

Para fazer parte da pastoral {{ Auth::user()->parishGroup->name }}, é necessário realizar uma formação. Como já sei que você tem interesse, vou deixar marcado para assim que tiver a formação, eu entro em contato com você.

Fique atento(a) às próximas comunicações!

Coordenador(a): {{ Auth::user()->name }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="bi bi-x-circle me-1" aria-hidden="true"></i>Cancelar
                                                        </button>
                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="bi bi-check-circle me-1" aria-hidden="true"></i>Marcar como Em Formação
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($requests->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $requests->links() }}
            </div>
            @endif
        @else
            <!-- Estado Vazio -->
            <div class="card-body text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-check-circle-fill text-success" aria-hidden="true" style="font-size: 5rem;"></i>
                </div>
                <h3 class="fw-bold mb-3">Nenhuma solicitação pendente</h3>
                <p class="text-muted mb-0">
                    Não há solicitações de entrada aguardando sua análise no momento.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
