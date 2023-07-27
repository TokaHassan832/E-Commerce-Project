<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Product::factory(20)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Offer::factory(5)->create();
        \App\Models\Cart::factory(3)->create();
    }
}
