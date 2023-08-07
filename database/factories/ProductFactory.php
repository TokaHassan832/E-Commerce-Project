<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {


        $colors = $this->faker->randomElements(['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'], $this->faker->numberBetween(1, 4));
        $sizes = $this->faker->randomElements(['Small', 'Medium', 'Large', 'XL', 'XXL'], $this->faker->numberBetween(1,5 ));

        return [
            'category_id'=>Category::factory(),
            'offer_id'=>Offer::factory(),
            'cart_id'=>Cart::factory(),
            'name'=>$this->faker->word,
            'original_price'=>$this->faker->randomNumber(5,10000),
            'discounted_price'=>$this->faker->randomNumber(5,10000),
            'sizes' => json_encode($sizes),
            'colors' => json_encode($colors),
            'image'=> $this->faker->imageUrl,
            'description'=>$this->faker->paragraph,
            'details'=>$this->faker->paragraph(5)
        ];
    }
}
