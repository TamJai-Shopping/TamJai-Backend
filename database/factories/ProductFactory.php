<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Shop;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'shop_id' => Shop::inRandomOrder()->first()->id,
            'name' => fake()->realText(10),
            'description' => fake()->realText(100),
            'total_amount' => fake()->numberBetween(0, 10000),
            'sell_amount' => fake()->numberBetween(0, 10000),
            'alert_amount' => fake()->numberBetween(0, 10000),
            'price' => fake()->numberBetween(0, 10000),
        ];
    }
}
