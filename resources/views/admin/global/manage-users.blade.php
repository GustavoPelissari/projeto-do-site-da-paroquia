@extends('admin.layout')

@section('title', 'Gerenciar Usuários - Admin Global')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-lg mb-4" style="background: linear-gradient(135deg, #8B1538 0%, #6E1530 50%, #8B1538 100%); border-radius: 20px;">
        <div class="card-body text-white py-4 px-4">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="display-6 fw-bold mb-2" style="color: #FFFFFF;">
                        <i class="bi bi-people-fill me-2"></i>Gerenciamento de Usuários
                    </h1>
                    <p class="mb-0" style="color: #FFD66B; font-size: 1.1rem;">
                        Administração global de todos os usuários do sistema paroquial
                    </p>
                </div>
                <div class="text-end">
                    <h3 class="mb-0" style="color: #FFD66B;">{{ $users->total() }}</h3>
                    <small style="color: #FFFFFF; opacity: 0.9;">Usuários Cadastrados</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($users as $user)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 user-card">
                    <div class="card-header border-0 text-white py-3 card-header-{{ $user->role->value }}">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <span class="fw-bold" style="font-size: 1.2rem; color: #FFFFFF;">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold" style="color: #FFFFFF;">{{ Str::limit($user->name, 20) }}</h6>
                                <small style="opacity: 0.9; color: #FFFFFF;">
                                    @switch($user->role->value)
                                        @case('admin_global')
                                            <i class="bi bi-shield-fill-check"></i> Admin Global
                                            @break
                                        @case('administrativo')
                                            <i class="bi bi-clipboard-check"></i> Administrativo
                                            @break
                                        @case('coordenador_de_pastoral')
                                            <i class="bi bi-person-badge"></i> Coordenador
                                            @break
                                        @default
                                            <i class="bi bi-person"></i> Usuário Padrão
                                    @endswitch
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-envelope"></i> Email</small>
                            <p class="mb-0 text-break" style="font-size: 0.9rem;">{{ $user->email }}</p>
                        </div>

                        @if($user->parishGroup)
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1"><i class="bi bi-people"></i> Grupo</small>
                                <span class="badge bg-success-subtle text-success border border-success">
                                    {{ $user->parishGroup->name }}
                                </span>
                            </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-calendar-plus"></i> Cadastro</small>
                            <p class="mb-0" style="font-size: 0.85rem;">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        @if($user->email_verified_at)
                            <div class="mb-2">
                                <span class="badge bg-success">
                                    <i class="bi bi-check-circle-fill"></i> Email Verificado
                                </span>
                            </div>
                        @else
                            <div class="mb-2">
                                <span class="badge bg-warning">
                                    <i class="bi bi-exclamation-circle"></i> Email Não Verificado
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-light border-0">
                        <div class="d-flex gap-2">
                            @if($user->id !== auth()->id())
                                <button class="btn btn-sm btn-outline-danger btn-delete-user" 
                                        data-user-id="{{ $user->id }}" 
                                        data-user-name="{{ $user->name }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            @endif
                            @if($user->role->value !== 'admin_global' || $user->id !== auth()->id())
                                <button class="btn btn-sm btn-outline-secondary flex-fill btn-change-role" 
                                        data-user-id="{{ $user->id }}" 
                                        data-user-name="{{ $user->name }}" 
                                        data-user-role="{{ $user->role->value }}">
                                    <i class="bi bi-arrow-repeat"></i> Função
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-people" style="font-size: 4rem; color: #6B7280;"></i>
                        <h3 class="mt-3 text-muted">Nenhum usuário encontrado</h3>
                        <p class="text-muted">O sistema ainda não possui usuários cadastrados.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

<div class="modal fade" id="changeRoleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-brand-vinho text-white">
                <h5 class="modal-title"><i class="bi bi-arrow-repeat"></i> Alterar Função do Usuário</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="changeRoleForm">
                @csrf
                <div class="modal-body">
                    <p>Alterar função de: <strong id="userName"></strong></p>
                    
                    <div class="mb-3">
                        <label class="form-label">Nova Função</label>
                        <select name="role" class="form-select" required>
                            <option value="">Selecione uma função</option>
                            <option value="usuario_padrao">👤 Usuário Padrão</option>
                            <option value="coordenador_de_pastoral">🎯 Coordenador de Pastoral</option>
                            <option value="administrativo">📋 Administrativo</option>
                            <option value="admin_global">⛪ Admin Global (Padre)</option>
                        </select>
                    </div>

                    <x-alert type="warning">
                        <strong>Atenção:</strong> Alterar a função do usuário modificará suas permissões no sistema.
                    </x-alert>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Confirmar Alteração
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Confirmar Exclusão</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteUserForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <x-alert type="error">
                        <strong>ATENÇÃO:</strong> Esta ação não pode ser desfeita!
                    </x-alert>

                    <p class="mb-0">Tem certeza que deseja excluir o usuário <strong id="deleteUserName"></strong>?</p>
                    <p class="text-muted small mt-2">Todos os dados relacionados a este usuário serão removidos permanentemente.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Excluir Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Event listener para botões de edição
document.addEventListener('DOMContentLoaded', function() {
    // Botões de alterar função
    document.querySelectorAll('.btn-change-role').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const currentRole = this.dataset.userRole;
            
            document.getElementById('userName').textContent = userName;
            document.getElementById('changeRoleForm').action = `/admin/users/${userId}/role`;
            document.querySelector('#changeRoleModal select[name="role"]').value = currentRole;
            
            const modal = new bootstrap.Modal(document.getElementById('changeRoleModal'));
            modal.show();
        });
    });

    // Botões de deletar usuário
    document.querySelectorAll('.btn-delete-user').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
            modal.show();
        });
    });
});
</script>

<style>
.user-card {
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.user-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(139, 21, 56, 0.15) !important;
}

/* Cores dos headers por role */
.card-header-admin_global {
    background: linear-gradient(135deg, #8B1538, #6E1530);
}

.card-header-coordenador_de_pastoral {
    background: linear-gradient(135deg, #2C5F2D, #1E4620);
}

.card-header-administrativo {
    background: linear-gradient(135deg, #1E3A8A, #1E293B);
}

.card-header-usuario_padrao {
    background: linear-gradient(135deg, #6B7280, #4B5563);
}

.bg-brand-vinho {
    background: linear-gradient(135deg, #8B1538, #6E1530);
}

.badge {
    padding: 0.4rem 0.8rem;
    font-weight: 500;
}
</style>
@endsection