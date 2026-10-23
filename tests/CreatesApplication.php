<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $applicationDatabase = null;
        if (is_file(base_path('.env'))) {
            $applicationDatabase = \Dotenv\Dotenv::parse(file_get_contents(base_path('.env')))['DB_DATABASE'] ?? null;
        }
        $connection = config('database.default');
        \Tests\Support\TestDatabaseGuard::check($app->environment(), config("database.connections.$connection"), $applicationDatabase);

        return $app;
    }
}
