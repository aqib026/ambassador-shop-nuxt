<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product  = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);

        return [
            'product_title' => $product->title,
            'price'         => $product->price,
            'quantity'      => $quantity,
            'admin_revenue' => 0.9 * $quantity * $product->price,
            'ambassador _revenue' => 0.1 * $quantity * $product->price,
        ];
    }
}
