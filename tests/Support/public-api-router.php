<?php

$app = require __DIR__.'/public-api-bootstrap.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::capture();
// Fault injection exists only in this guarded local test server, never in product routes.
if ($request->header('X-Public-Test-Failure') === 'clubs') {
    \Illuminate\Support\Facades\Route::get('api/v1/clubs', fn () => throw new \RuntimeException('Injected test failure'))->middleware('api');
}
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
