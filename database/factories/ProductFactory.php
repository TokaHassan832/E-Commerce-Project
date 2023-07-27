<?php

namespace Database\Factories;

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
        $original_price = $this->faker->randomFloat(2, 100, 1000);
        $offerPercentage = Offer::inRandomOrder()->value('offer_percentage');
        $discountAmount = $original_price * ($offerPercentage / 100);
        $discounted_price = $original_price - $discountAmount;

        $colors = $this->faker->randomElements(['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White'], $this->faker->numberBetween(1, 4));
        $sizes = $this->faker->randomElements(['Small', 'Medium', 'Large', 'XL', 'XXL'], $this->faker->numberBetween(1,5 ));

        return [
            'category_id'=>Category::factory(),
            'offer_id'=>Offer::factory(),
            'name'=>$this->faker->word,
            'original_price'=>$original_price,
            'discounted_price'=>$discounted_price,
            'sizes' => json_encode($sizes),
            'colors' => json_encode($colors),
            'image'=> $this->faker->imageUrl,
            'description'=>$this->faker->paragraph,
            'details'=>$this->faker->paragraph(5)
        ];
    }
}
