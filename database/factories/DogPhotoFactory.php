<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DogPhoto>
 */
class DogPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'age' => $this->faker->numberBetween(0, 100),
            'weight' => $this->faker->numberBetween(0, 100),
            'path' => $this->faker->image,
            'owner_id' => User::factory(),
        ];
    }
}
