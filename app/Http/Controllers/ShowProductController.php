<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowProductController extends Controller
{
    public function __invoke(Request $request, Product $product){
        return Inertia::render("Product/Show", [
            'product' => $product,
        ]);
    }
}
