<?php

// Test-server entrypoints require explicit test configuration before touching the DB.
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$connection = config('database.default');
$applicationDatabase = is_file(base_path('.env')) ? (\Dotenv\Dotenv::parse(file_get_contents(base_path('.env')))['DB_DATABASE'] ?? null) : null;
\Tests\Support\TestDatabaseGuard::check($app->environment(), config("database.connections.$connection"), $applicationDatabase);
$directory = getenv('PUBLIC_INTEGRATION_DIRECTORY') ?: sys_get_temp_dir().'/bulsca-public-integration';
config(['filesystems.default' => 'local', 'filesystems.disks.local.root' => $directory.'/files', 'cache.stores.file.path' => $directory.'/cache', 'cache.stores.file.lock_path' => $directory.'/cache', 'public_site.cache_store' => 'file', 'services.turnstile.site_key' => 'integration-site-key', 'services.turnstile.secret_key' => 'integration-secret', 'services.meta.access_token' => null]);
config(['logging.channels.diagnostics.path' => $directory.'/diagnostics.log']);
\Carbon\Carbon::setTestNow('2026-10-28 12:00:00 UTC');
\Illuminate\Support\Facades\Http::preventStrayRequests();
\Illuminate\Support\Facades\Http::fake(['challenges.cloudflare.com/*' => \Illuminate\Support\Facades\Http::response(['success' => true])]);
\Illuminate\Support\Facades\Mail::fake();
return $app;
