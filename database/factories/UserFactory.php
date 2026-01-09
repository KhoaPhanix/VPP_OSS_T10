<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'full_name' => fake()->name(),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => fake()->date(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'role' => 'customer',
            'is_verified' => true,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
            'is_verified' => false,
        ]);
    }
}
