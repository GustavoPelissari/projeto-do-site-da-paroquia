<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class DashboardHelper
{
    /**
     * Get appropriate dashboard route for a specific user role
     */
    public static function getDashboardRoute($userRole): string
    {
        $roleValue = $userRole instanceof \App\Enums\UserRole ? $userRole->value : $userRole;

        return match ($roleValue) {
            'admin_global' => route('admin.global.dashboard'),
            'coordenador_de_pastoral' => route('admin.coordenador.dashboard'),
            'administrativo' => route('admin.administrativo.dashboard'),
            default => route('dashboard')
        };
    }

    /**
     * Get appropriate dashboard route for current user
     */
    public static function getUserDashboardRoute(): string
    {
        if (! Auth::check()) {
            return route('login');
        }

        $user = Auth::user();
        $userRole = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;

        return match ($userRole) {
            'admin_global' => route('admin.global.dashboard'),
            'coordenador_de_pastoral' => route('admin.coordenador.dashboard'),
            'administrativo' => route('admin.administrativo.dashboard'),
            default => route('dashboard')
        };
    }

    /**
     * Get user area label
     */
    public static function getUserAreaLabel(): string
    {
        if (! Auth::check()) {
            return 'Login';
        }

        $user = Auth::user();
        $userRole = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;

        return match ($userRole) {
            'admin_global' => 'Admin Global',
            'coordenador_de_pastoral' => 'Painel Coordenador',
            'administrativo' => 'Painel Administrativo',
            default => 'Meu Painel'
        };
    }
}
