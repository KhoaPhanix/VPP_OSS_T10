<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => 'ORD-' . fake()->unique()->numerify('##########'),
            'user_id' => User::factory(),
            'total_amount' => fake()->numberBetween(50000, 5000000),
            'status' => 'pending',
            'payment_method' => fake()->randomElement(['cod', 'bank_transfer']),
            'shipping_address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'approved_at' => now()->subHour(),
            'completed_at' => now(),
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'rejected_at' => now(),
            'reject_reason' => fake()->sentence(),
        ]);
    }
}
