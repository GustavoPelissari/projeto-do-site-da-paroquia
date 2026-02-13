@extends('admin.layout')

@section('title', 'Gerenciar Usuários - Admin Global')

@push('styles')
<style>
    .users-management {
        padding: var(--space-6);
    }
    
    .users-header {
        background: linear-gradient(135deg, var(--sp-red-dark) 0%, var(--sp-red) 100%);
        color: var(--sp-white);
        padding: var(--space-xl);
        border-radius: var(--radius-xl);
        margin-bottom: var(--space-6);
        text-align: center;
    }
    
    .users-grid {
        display: grid;
        gap: var(--space-4);
    }
    
    .user-card {
        background: var(--sp-white);
        border: 1px solid var(--sp-gray-200);
        border-radius: var(--radius-lg);
        padding: var(--space-5);
        box-shadow: var(--shadow-md);
        transition: all var(--duration-300) ease;
    }
    
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        margin-bottom: var(--space-4);
    }
    
    .user-avatar {
        width: 60px;
        height: 60px;
        background: var(--sp-red);
        color: var(--sp-white);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: var(--text-lg);
    }
    
    .user-details h3 {
        margin: 0 0 var(--space-1) 0;
        font-size: var(--text-lg);
        font-weight: var(--font-semibold);
        color: var(--sp-red-dark);
    }
    
    .user-role {
        color: var(--sp-gray-600);
        font-size: var(--text-sm);
    }
    
    .user-email {
        color: var(--sp-teal);
        font-size: var(--text-sm);
    }
    
    .user-actions {
        display: flex;
        gap: var(--space-2);
        justify-content: flex-end;
    }
    
    .btn {
        padding: var(--space-2) var(--space-3);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: var(--text-sm);
        font-weight: var(--font-medium);
        border: none;
        cursor: pointer;
        transition: all var(--duration-200) ease;
    }
    
    .btn-primary {
        background: var(--sp-red);
        color: var(--sp-white);
    }
    
    .btn-primary:hover {
        background: var(--sp-red-dark);
    }
    
    .btn-secondary {
        background: var(--sp-gray-100);
        color: var(--sp-gray-700);
    }
    
    .btn-secondary:hover {
        background: var(--sp-gray-200);
    }
</style>
@endpush

@section('content')
<div class="users-management">
    <div class="users-header">
        <h1> Gerenciamento de Usuários</h1>
        <p>Administração global de todos os usuários do sistema paroquial</p>
    </div>
    
    <div class="users-grid">
        @foreach($users as $user)
            <div class="user-card">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <h3>{{ $user->name }}</h3>
                        <div class="user-role">
                            @switch($user->role)
                                @case('admin_global')
                                     Padre - Admin Global
                                    @break
                                @case('administrativo')
                                     Administrativo
                                    @break
                                @case('coordenador_de_pastoral')
                                     Coordenador de Pastoral
                                    @break
                                @case('usuario_padrao')
                                     Usuário Padrão
                                    @break
                                @default
                                     {{ $user->role }}
                            @endswitch
                        </div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>
                </div>
                
                <div class="user-actions">
                    <button class="btn btn-secondary"> Editar</button>
                    @if($user->role !== 'admin_global')
                        <button class="btn btn-primary"> Alterar Função</button>
                    @endif
                </div>
            </div>
        @endforeach
        
        @if($users->isEmpty())
            <div class="user-card">
                <div style="text-align: center; padding: var(--space-8); color: var(--sp-gray-500);">
                    <h3> Nenhum usuário encontrado</h3>
                    <p>O sistema ainda não possui usuários cadastrados.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
