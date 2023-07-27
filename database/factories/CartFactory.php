<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 50);
        $unit_price = $this->faker->randomFloat(2, 10, 100);
        $Subtotal = $quantity * $unit_price;

        return [
            'user_id'=>User::factory(),
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'Subtotal' => $Subtotal,
        ];
    }
}
