@extends('admin.layout')

@section('title', 'Gerenciar Usuários - Admin Global')

@section('content')
<div class="mb-4">
    <p class="admin-overline mb-1">Administração de acesso</p>
    <h2 class="h3 mb-1">Gerenciamento de usuários</h2>
    <p class="text-secondary mb-0">Controle de perfis e papéis de acesso do sistema.</p>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="h5 mb-0">Usuários cadastrados</h3>
        <span class="badge text-bg-light border">{{ $users->total() }} usuários</span>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Perfil atual</th>
                            <th>Criado em</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @php
                                $role = is_object($user->role) ? $user->role->value : $user->role;
                                $roleLabel = [
                                    'admin_global' => 'Administrador Global',
                                    'administrativo' => 'Administrativo',
                                    'coordenador_de_pastoral' => 'Coordenador de Pastoral',
                                    'usuario_padrao' => 'Usuário padrão',
                                ][$role] ?? $role;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-pill text-bg-light border">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge text-bg-secondary">{{ $roleLabel }}</span></td>
                                <td>{{ $user->created_at?->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    @if($role !== 'admin_global')
                                        <form method="POST" action="{{ route('admin.global.users.updateRole', $user) }}" class="d-inline-flex gap-2 align-items-center">
                                            @csrf
                                            <select class="form-select form-select-sm" name="role" aria-label="Alterar função de {{ $user->name }}">
                                                <option value="usuario_padrao" @selected($role === 'usuario_padrao')>Usuário padrão</option>
                                                <option value="coordenador_de_pastoral" @selected($role === 'coordenador_de_pastoral')>Coordenador</option>
                                                <option value="administrativo" @selected($role === 'administrativo')>Administrativo</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Salvar</button>
                                        </form>
                                    @else
                                        <span class="text-secondary small">Sem alteração</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4 text-center text-secondary">Nenhum usuário encontrado.</div>
        @endif
    </div>
</div>

@if($users->hasPages())
    <div class="mt-4">{{ $users->links() }}</div>
@endif
@endsection
