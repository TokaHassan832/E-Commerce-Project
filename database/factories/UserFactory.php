<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'avatar' => $this->generateRandomAvatar(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Custom function to generate random avatar URLs using Lorempixel service.
     *
     * @return string
     */
    function generateRandomAvatar()
    {
        $avatars = [
            'abstract', 'animals', 'business', 'cats', 'city', 'food', 'nightlife',
            'fashion', 'people', 'nature', 'sports', 'technics', 'transport'
        ];

        $category = $avatars[array_rand($avatars)];
        $width = rand(200, 300);
        $height = rand(200, 300);

        return "https://lorempixel.com/{$width}/{$height}/{$category}/";
    }
}
