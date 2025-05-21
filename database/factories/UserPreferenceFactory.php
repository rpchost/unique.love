<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPreference>
 */
class UserPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'interested_in' => fake()->randomElement(['male', 'female', 'all']),
            'age_range' => [fake()->numberBetween(18, 30), fake()->numberBetween(30, 65)],
            'distance_preference' => fake()->randomElement([5, 10, 25, 50, 100]),
        ];
    }
}
