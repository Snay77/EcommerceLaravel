<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowProductController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        $cart = $request->user()->customer->cart()->with('product')->first();

        $cartProduct = $cart ? $cart->product->where('slug', $product->slug)->first() : null;
        $currentCartQuantity = $cartProduct ? $cartProduct->pivot->quantity : 0;

        return Inertia::render("Product/Show", [
            'product' => $product->load(['categories', 'images']),
            'currentCartQuantity' => $currentCartQuantity,
        ]);
    }
}
