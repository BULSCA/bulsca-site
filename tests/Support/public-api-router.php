<?php

$app = require __DIR__.'/public-api-bootstrap.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::capture();
// Exercise loading-state readiness even when the runner/server is unusually fast.
if ($request->is('api/v1/contact/config') || preg_match('#^api/v1/resources/[^/]+$#', $request->path())) {
    usleep(150000);
}
// Fault injection exists only in this guarded local test server, never in product routes.
if ($request->header('X-Public-Test-Failure') === 'clubs') {
    \Illuminate\Support\Facades\Route::get('api/v1/clubs', fn () => throw new \RuntimeException('Injected test failure'))->middleware('api');
}
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
