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
        $label = $this->faker->word();

        return [
            'label' => ucfirst($label),
            'slug' => Str::slug($label),
            'description' => $this->faker->sentence(),
            'parent_id' => null, // Pour les sous catéogies
        ];
    }
}