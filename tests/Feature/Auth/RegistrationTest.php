<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_redirects_to_the_identity_provider(): void
    {
        config(['sso.auth_server' => 'https://identity.example.test']);

        $this->get('/register')->assertRedirect('https://identity.example.test/register');
        $this->assertGuest();
    }

    public function test_local_registration_is_not_available(): void
    {
        $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(405);

        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'test@example.com']);
    }
}
