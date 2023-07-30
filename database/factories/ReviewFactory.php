<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id'=>Product::factory(),
            'user_id'=>User::factory(),
            'name'=>$this->faker->name,
            'email'=>$this->faker->email,
//            'rate'=> $this->faker->randomFloat(1, 1, 5),
            'content'=>$this->faker->text,
        ];
    }
}
