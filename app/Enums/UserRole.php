<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN_GLOBAL = 'admin_global';
    case ADMINISTRATIVO = 'administrativo';
    case COORDENADOR_PASTORAL = 'coordenador_de_pastoral';
    case USUARIO_PADRAO = 'usuario_padrao';
    case VISITANTE = 'visitante';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN_GLOBAL => 'Administrador Global',
            self::ADMINISTRATIVO => 'Administrativo',
            self::COORDENADOR_PASTORAL => 'Coordenador de Pastoral',
            self::USUARIO_PADRAO => 'Usuário Padrão',
            self::VISITANTE => 'Visitante',
        };
    }

    public function canManageUsers(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            default => false,
        };
    }

    public function canManageMasses(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            self::ADMINISTRATIVO => true,
            default => false,
        };
    }

    public function canCreateNews(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            self::ADMINISTRATIVO => true,
            self::COORDENADOR_PASTORAL => true,
            default => false,
        };
    }

    public function canManageGroups(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            default => false,
        };
    }

    public function canManageOwnGroup(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            self::COORDENADOR_PASTORAL => true,
            default => false,
        };
    }

    public function canManageSchedules(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            self::COORDENADOR_PASTORAL => true,
            default => false,
        };
    }

    public function canApproveRequests(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            self::COORDENADOR_PASTORAL => true,
            default => false,
        };
    }

    public function canDeleteGroups(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            default => false,
        };
    }

    public function canChangeSystemSettings(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            default => false,
        };
    }

    public function canAccessAuditLogs(): bool
    {
        return match ($this) {
            self::ADMIN_GLOBAL => true,
            default => false,
        };
    }

    public function getPermissions(): array
    {
        return [
            'manage_users' => $this->canManageUsers(),
            'manage_masses' => $this->canManageMasses(),
            'create_news' => $this->canCreateNews(),
            'manage_groups' => $this->canManageGroups(),
            'manage_own_group' => $this->canManageOwnGroup(),
            'manage_schedules' => $this->canManageSchedules(),
            'approve_requests' => $this->canApproveRequests(),
            'delete_groups' => $this->canDeleteGroups(),
            'change_system_settings' => $this->canChangeSystemSettings(),
            'access_audit_logs' => $this->canAccessAuditLogs(),
        ];
    }
}
