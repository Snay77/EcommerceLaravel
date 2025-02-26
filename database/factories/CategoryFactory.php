<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categoryname = $this->faker->words(3, true);

        return [
            'label' => $categoryname,
            'slug' => Str::slug($categoryname),
            'description' => $this->faker->sentence(),
            'parent_id' => null, // Pour les sous catéogies
        ];
    }
}