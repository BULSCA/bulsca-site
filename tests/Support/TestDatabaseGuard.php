<?php

namespace Tests\Support;

use RuntimeException;

class TestDatabaseGuard
{
    public static function check(string $environment, array $connection, ?string $applicationDatabase): void
    {
        $database = $connection['database'] ?? '';
        if ($environment !== 'testing'
            || ($connection['driver'] ?? '') !== 'mysql'
            || ! is_string($database)
            || ! preg_match('/^[a-zA-Z0-9_]+_test$/', $database)
            || ! empty($connection['url'])
            || ! in_array($connection['host'] ?? '', ['127.0.0.1', 'localhost', 'mysql'], true)
            || $database === $applicationDatabase) {
            throw new RuntimeException('Refusing database tests: use a separate local MySQL database ending in _test, without a connection URL.');
        }
    }
}
