<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory(20)->create();
        Category::factory(10)->create();
        Offer::factory(4)->create();
        Review::factory(10)->create();
        Coupon::factory()->create([
            'code' => 'ABC123',
            'type' => 'fixed',
            'value' => 30
        ]);

        Coupon::factory()->create([
            'code' => 'XYZ456',
            'type' => 'percentage',
            'offer_id' => Offer::factory(),
        ]);
    }
}
