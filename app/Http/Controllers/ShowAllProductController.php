<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowAllProductController extends Controller
{
    public function __invoke(Request $request) {
        $products = Product::all();

        return Inertia::render("Product/Index", [
            'products' => $products,
        ]);
    }
}
