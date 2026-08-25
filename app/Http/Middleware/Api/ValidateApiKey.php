<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;

class ValidateApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'API key required'
            ], 401);
        }

        if (!$this->isValidApiKey($apiKey)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid API key'
            ], 403);
        }

        return $next($request);
    }

    private function isValidApiKey(string $apiKey): bool
    {
        $validKeys = explode(',', env('API_KEYS', ''));
        return in_array(trim($apiKey), array_map('trim', $validKeys));
    }
}