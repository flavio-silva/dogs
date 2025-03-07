<?php

namespace Tests\Feature;

use App\Models\User;
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

    public function test_user_can_sign_in()
    {
        $user  = User::factory()->create([
            'password' => $password = $this->faker->password,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();
    }
}
