<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_user_can_signup(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => $this->faker->name,
            'email'  => $this->faker->email(),
            'password' => $this->faker->password(),
        ]);

        $response->assertOk();
    }
}
