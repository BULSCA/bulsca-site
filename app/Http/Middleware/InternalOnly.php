<?php
namespace App\Http\Middleware;


class InternalOnly
{
    public function handle($request, $next)
    {
        if (! $request->ip() === '127.0.0.1') {
            abort(403, 'Forbidden');
        }
        return $next($request);
    }
}