<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Add security headers to all responses.
 * Implements best practices for OWASP and browser security.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Clickjacking protection - prevent embedding in frames
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // MIME type sniffing protection
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection (legacy, but still useful for older browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy - limit referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Feature Policy / Permissions Policy - restrict browser features
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        // HSTS (HTTP Strict-Transport-Security) - force HTTPS
        if (app()->environment('production')) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // Content-Security-Policy - strict policy against XSS
        $csp = "default-src 'self'; "
            . "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com; "
            . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; "
            . "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net; "
            . "img-src 'self' data: https:; "
            . "connect-src 'self' https://maps.googleapis.com; "
            . "frame-src https://www.google.com; "
            . "form-action 'self'; "
            . "base-uri 'self'; "
            . "upgrade-insecure-requests";

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
