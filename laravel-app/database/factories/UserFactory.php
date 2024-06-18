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
            'login' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'token' => $this->faker->uuid(),
            'role' => 1,
            'last_update_token' => $this->faker->dateTimeThisDecade(),
            'name' => $this->faker->name(),
            'address' => $this->faker->streetAddress(),
            'executor_id' => null
        ];
    }

    public function withRole($role)
    {
        return $this->state(function (array $attributes) use ($role) {
            return [
                'role' => $role,
                'executor_id' => $role === 2 ? Str::random(10) : null
            ];
        });
    }

    public function executor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 2,
                'login' => 'executor',
                'password' => Hash::make('123'),
                'executor_id' => Str::random(10)
            ];
        });
    }

    public function dispatcher()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 0,
                'login' => 'dispatcher',
                'password' => Hash::make('123')
            ];
        });
    }

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
