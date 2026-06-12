<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;
     public function test_user_can_register(): void
    {
        $response = $this->postJson('/api/register', [
            'fname' => 'Dipali',
            'email' => 'dipali@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => 'dipali@example.com'
        ]);
    }
}
