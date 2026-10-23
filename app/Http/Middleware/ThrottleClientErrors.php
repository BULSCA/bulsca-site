<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ThrottleClientErrors
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(strlen($request->getContent()) > 8192, 413);
        // Explicit file store: logging remains available when DB/Redis fail.
        $limiter = new RateLimiter(Cache::store('file'));
        $key = 'client-errors:'.hash('sha256', $request->ip() ?? 'unknown');
        if ($limiter->tooManyAttempts($key, 30)) {
            abort(429, '', ['Retry-After' => (string) $limiter->availableIn($key)]);
        }
        $limiter->hit($key, 60);
        return $next($request);
    }
}
