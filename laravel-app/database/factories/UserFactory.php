<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
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
            'login' => $this->faker->login(),
            'password' => Hash::make('password'),
            'token' => $this->faker->uuid(),
            'role' => 1,
            'name' => $this->faker->name(),
            'token_last_used_at' => $this->faker->dateTimeThisDecade(),
            'address' => $this->faker->address()
        ];
    }

    // public function withRole($role)
    // {
    //     return $this->state(function (array $attributes) use ($role) {
    //         return [
    //             'role' => $role,
    //         ];
    //     });
    // }

    // /**
    //  * Indicate that the model's email address should be unverified.
    //  */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
