<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        
        return [
            'code' => 'SP' . fake()->unique()->numerify('####'),
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'unit' => fake()->randomElement(['cái', 'hộp', 'bộ', 'cuốn', 'chiếc']),
            'price' => fake()->numberBetween(5000, 500000),
            'stock_quantity' => fake()->numberBetween(0, 200),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'is_active' => true,
            'is_featured' => fake()->boolean(20),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_quantity' => 0,
        ]);
    }
}
