<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\{PublicContentRevision, PublicRouteManifest};
use Illuminate\Support\Facades\Cache;

class ManifestController extends Controller
{
    public function __construct(private PublicContentRevision $revisions, private PublicRouteManifest $manifest) {}

    public function index(): array
    {
        // The revision is read live; the route list is cached per revision.
        $revision = $this->revisions->current();
        $routes = Cache::store(config('public_site.cache_store'))
            ->rememberForever('public-route-manifest:revision-'.$revision, fn () => $this->manifest->routes());
        return ['data' => ['revision' => $revision, 'routes' => $routes]];
    }
}
