<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'email' => 'jean@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'consentement' => '1',
        ]);

        $response->assertRedirect(route('/dashboard'));

        $this->assertDatabaseHas('users', [
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'email' => 'jean@example.com',
        ]);

        $this->assertAuthenticated();
    }
}