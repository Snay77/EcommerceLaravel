<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AddItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        // dd($request->user()->customer());
        $cart = $request->user()->customer->cart()->firstOrCreate();
        $cartItem = $cart->product()->where("product_id", $product->id)->first();

        if ($cartItem) {
            $cart->product()->updateExistingPivot($product->id, [
                'quantity' => $cartItem->pivot->quantity + $request->quantity,
            ]);
        } else {
            $cart->product()->attach($product->id,[
                'quantity' => $request->quantity
            ]);
        }
        
        return redirect()->route('cart.show')->with('success', 'Produit ajouté au panier');
    }
}
