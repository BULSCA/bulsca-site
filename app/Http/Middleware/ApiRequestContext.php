<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiRequestContext
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->is('api/v1/*')) {
            return $next($request);
        }
        // Never trust a caller-controlled correlation ID or negotiate an HTML error page.
        $request->attributes->set('request_id', (string) Str::uuid());
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);
        $response->headers->set('X-Request-ID', $request->attributes->get('request_id'));
        return $response;
    }
}
