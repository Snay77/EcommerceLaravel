<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::factory(10)->create();

        $categories->each(function ($category) { // pour chaque catégorie
            $products = Product::factory(5)->create(); // créé 5 produits
            $category->products()->attach($products->pluck('id')); // associe les produits à la catégorie
        });

        // Optionnel: si tu veux assigner plusieurs catégories aux produits
        // $products = Product::all();
        // foreach ($products as $product) {
        //     // On attache entre 1 et 3 catégories aléatoires par produit
        //     $product->categories()->attach(
        //         Category::inRandomOrder()->take(rand(1, 3))->pluck('id')
        //     );
        // }
    }
}