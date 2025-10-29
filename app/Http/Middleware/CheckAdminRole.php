<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = $user->role instanceof \App\Enums\UserRole ? $user->role->value : $user->role;

        if ($userRole !== $role) {
            abort(403, 'Acesso negado. Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}
