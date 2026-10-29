<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Cache, DB};
use Illuminate\Support\Str;

class HealthController extends Controller
{
    public function live()
    {
        return response()->json(['status' => 'ok'])->header('Cache-Control', 'no-store');
    }

    public function ready()
    {
        try {
            DB::select('SELECT 1');
            foreach (config('release.writable_paths') as $path) {
                if (! is_dir($path) || ! is_writable($path)) throw new \RuntimeException('Storage unavailable');
            }
            $cache = Cache::store(config('public_site.cache_store'));
            $key = 'health-'.Str::uuid();
            try {
                if (! $cache->put($key, 'ok', 10) || $cache->get($key) !== 'ok') throw new \RuntimeException('Cache unavailable');
            } finally {
                $cache->forget($key);
            }
            return $this->live();
        } catch (\Throwable) {
            return response()->json(['status' => 'unavailable'], 503)->header('Cache-Control', 'no-store');
        }
    }
}
