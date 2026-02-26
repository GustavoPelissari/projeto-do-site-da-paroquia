<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Add cache headers for static assets and HTML content.
 * Improves performance by reducing unnecessary requests.
 */
class CacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Cache static assets aggressively
        if ($this->isStaticAsset($request->path())) {
            $response->header('Cache-Control', 'public, max-age=31536000, immutable');
            $response->header('Pragma', 'cache');
        }
        // Cache HTML pages moderately
        elseif ($request->expectsJson() === false && $response->getStatusCode() === 200) {
            $response->header('Cache-Control', 'public, max-age=3600, must-revalidate');
        }
        // Don't cache API responses
        else {
            $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
            $response->header('Pragma', 'no-cache');
        }

        return $response;
    }

    protected function isStaticAsset(string $path): bool
    {
        $staticExtensions = [
            '.css', '.js', '.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg',
            '.woff', '.woff2', '.ttf', '.eot', '.otf', '.ico',
        ];

        foreach ($staticExtensions as $ext) {
            if (str_ends_with(strtolower($path), $ext)) {
                return true;
            }
        }

        return false;
    }
}
