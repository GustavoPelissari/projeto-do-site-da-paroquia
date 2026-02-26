<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAndArea
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        $user = Auth::user();
        $userRole = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;

        // Verificação rigorosa de papel
        if ($userRole !== $role) {
            // Log da tentativa de acesso não autorizado
            Log::warning('Tentativa de acesso não autorizado', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $userRole,
                'required_role' => $role,
                'url' => $request->url(),
                'ip' => $request->ip(),
            ]);

            // Redirecionar para área apropriada do usuário
            return $this->redirectToUserArea($userRole, 'Acesso negado. Você não tem permissão para acessar esta área.');
        }

        // Verificação adicional para coordenadores - só podem acessar recursos do seu grupo
        if ($role === UserRole::COORDENADOR_PASTORAL->value && $this->requiresGroupRestriction($request)) {
            if (! $user->parish_group_id) {
                return $this->redirectToUserArea($userRole, 'Você precisa estar associado a um grupo para acessar esta área.');
            }
        }

        return $next($request);
    }

    /**
     * Redireciona o usuário para sua área apropriada
     */
    private function redirectToUserArea(string $userRole, string $message): Response
    {
        $routes = [
            UserRole::ADMIN_GLOBAL->value => 'admin.global.dashboard',
            UserRole::COORDENADOR_PASTORAL->value => 'admin.coordenador.dashboard',
            UserRole::ADMINISTRATIVO->value => 'admin.administrativo.dashboard',
        ];

        $route = $routes[$userRole] ?? 'home';

        return redirect()->route($route)->with('error', $message);
    }

    /**
     * Verifica se a rota requer restrição por grupo
     */
    private function requiresGroupRestriction(Request $request): bool
    {
        $restrictedRoutes = [
            'admin.coordenador.news',
            'admin.coordenador.events',
            'admin.coordenador.schedules',
            'admin.coordenador.scales',
        ];

        foreach ($restrictedRoutes as $route) {
            if (str_contains($request->route()->getName(), $route)) {
                return true;
            }
        }

        return false;
    }
}
