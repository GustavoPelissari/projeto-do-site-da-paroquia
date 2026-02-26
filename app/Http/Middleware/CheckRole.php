<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (! $request->user()) {
            return redirect('/login');
        }

        $user = $request->user();

        // Se não há permissões específicas requeridas, apenas verifica autenticação
        if (empty($permissions)) {
            return $next($request);
        }

        // Admin global tem acesso a tudo
        if ($user->role === UserRole::ADMIN_GLOBAL) {
            return $next($request);
        }

        // Verificar permissões específicas
        foreach ($permissions as $permission) {
            if ($this->userHasPermission($user, $permission, $request)) {
                return $next($request);
            }
        }

        // Se chegou aqui, usuário não tem permissão
        return redirect()->route('dashboard')
            ->with('error', 'Você não tem permissão para acessar esta área.');
    }

    private function userHasPermission($user, string $permission, Request $request): bool
    {
        // Verificações específicas por permissão
        return match ($permission) {
            // Permissões básicas por papel
            'admin_global' => $user->role === UserRole::ADMIN_GLOBAL,
            'administrativo' => $user->role === UserRole::ADMINISTRATIVO,
            'coordenador_pastoral' => $user->role === UserRole::COORDENADOR_PASTORAL,
            'usuario_padrao' => $user->role === UserRole::USUARIO_PADRAO,

            // Permissões funcionais
            'manage_users' => $user->canManageUsers(),
            'manage_masses' => $user->canManageMasses(),
            'create_news' => $user->canCreateNews(),
            'manage_groups' => $user->canManageGroups(),
            'manage_schedules' => $user->canManageSchedules(),
            'approve_requests' => $user->canApproveRequests(),
            'delete_groups' => $user->canDeleteGroups(),
            'access_audit_logs' => $user->role->canAccessAuditLogs(),

            // Permissões contextuais (requerem verificação do recurso)
            'manage_own_group' => $this->canManageOwnGroup($user, $request),
            'manage_group_schedules' => $this->canManageGroupSchedules($user, $request),
            'view_group_requests' => $this->canViewGroupRequests($user, $request),

            // Permissões administrativas específicas
            'manage_parish_settings' => $user->role === UserRole::ADMIN_GLOBAL,
            'view_all_audit_logs' => $user->role === UserRole::ADMIN_GLOBAL,
            'assign_roles' => $user->role === UserRole::ADMIN_GLOBAL,
            'delete_sensitive_content' => $user->role === UserRole::ADMIN_GLOBAL,

            // Hierarquia de permissões para conteúdo
            'publish_news' => in_array($user->role, [
                UserRole::ADMIN_GLOBAL,
                UserRole::ADMINISTRATIVO,
                UserRole::COORDENADOR_PASTORAL,
            ]),

            'moderate_comments' => in_array($user->role, [
                UserRole::ADMIN_GLOBAL,
                UserRole::ADMINISTRATIVO,
            ]),

            default => false,
        };
    }

    private function canManageOwnGroup($user, Request $request): bool
    {
        if (! $user->canManageOwnGroup()) {
            return false;
        }

        // Se é admin global, pode gerenciar qualquer grupo
        if ($user->isAdminGlobal()) {
            return true;
        }

        // Se é coordenador, só pode gerenciar seu próprio grupo
        if ($user->isCoordenador()) {
            $groupId = $request->route('group') ?? $request->route('id');

            if ($groupId) {
                return $user->parish_group_id == $groupId;
            }
        }

        return false;
    }

    private function canManageGroupSchedules($user, Request $request): bool
    {
        if (! $user->canManageSchedules()) {
            return false;
        }

        // Admin global pode gerenciar escalas de qualquer grupo
        if ($user->isAdminGlobal()) {
            return true;
        }

        // Coordenador só pode gerenciar escalas do seu grupo
        if ($user->isCoordenador()) {
            $groupId = $request->route('group') ?? $request->get('group_id');

            return $user->parish_group_id == $groupId;
        }

        return false;
    }

    private function canViewGroupRequests($user, Request $request): bool
    {
        if (! $user->canApproveRequests()) {
            return false;
        }

        // Admin global vê todas as solicitações
        if ($user->isAdminGlobal()) {
            return true;
        }

        // Coordenador só vê solicitações do seu grupo
        if ($user->isCoordenador()) {
            $groupId = $request->route('group') ?? $request->get('group_id');

            return $user->parish_group_id == $groupId;
        }

        return false;
    }
}
