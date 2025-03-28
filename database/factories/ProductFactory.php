<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $productname = $this->faker->words(3, true);
        return [
            'label' => $productname,
            'slug' => Str::slug($productname),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(1000, 50000), // Prix aléatoire entre 10€ et 500€
            'stock' => $this->faker->numberBetween(0, 100), // Stock aléatoire
        ];
    }
}