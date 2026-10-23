<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Tests\Support\TestDatabaseGuard;

class TestDatabaseGuardTest extends TestCase
{
    private function connection(array $overrides = []): array
    {
        return array_merge(['driver' => 'mysql', 'host' => '127.0.0.1', 'database' => 'bulsca_test', 'url' => null], $overrides);
    }

    public function test_a_separate_local_test_database_is_allowed(): void
    {
        TestDatabaseGuard::check('testing', $this->connection(), 'bulsca');
        $this->addToAssertionCount(1);
    }

    public function test_live_databases_remote_hosts_and_url_overrides_are_rejected(): void
    {
        foreach ([['database' => 'bulsca'], ['host' => 'production.example'], ['url' => 'mysql://live'], ['driver' => 'sqlite']] as $override) {
            try {
                TestDatabaseGuard::check('testing', $this->connection($override), 'bulsca');
                $this->fail('Unsafe connection was accepted');
            } catch (RuntimeException) {
                $this->addToAssertionCount(1);
            }
        }
    }

    public function test_using_the_application_database_is_rejected_even_with_a_test_name(): void
    {
        $this->expectException(RuntimeException::class);
        TestDatabaseGuard::check('testing', $this->connection(), 'bulsca_test');
    }
}
