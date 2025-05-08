<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->optional()->word,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date('Y-m-d', '2000-01-01'),
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'), // Default password
            'is_logged_in' => false,
            'logged_in_at' => null,
            'logged_out_at' => null,
            'is_active' => true,
            'remark' => $this->faker->sentence,
        ];
    }
}
