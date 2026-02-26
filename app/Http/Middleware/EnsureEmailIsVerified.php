<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Allow access if user is not authenticated or already verified
        if (!$user || $user->hasVerifiedEmail()) {
            return $next($request);
        }

        // Redirect unverified users to verification page
        return redirect()->route('verification.notice')
            ->with('status', 'Por favor, verifique seu e-mail antes de continuar.');
    }
}
