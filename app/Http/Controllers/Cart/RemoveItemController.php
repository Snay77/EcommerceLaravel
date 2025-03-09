<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class RemoveItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $item)
    {
        $cart = $request->user()->customer->cart()->firstOrCreate();

        // dd($cart);

        // $cartItem = $cart->product()->get();
        $cartItem = $cart->product()->where('product_id', $item->id)->first();

        // dd($cartItem);


        if ($cartItem) {

            $cart->product()->detach($item->id);
            return redirect()->back()->with('success', 'Produit supprimé du panier');
            
        } else {
            return redirect()->back()->withErrors('Produit introuvable dans le panier.');
        }
    }
}
