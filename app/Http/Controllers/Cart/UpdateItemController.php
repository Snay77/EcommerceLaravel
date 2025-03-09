<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateItemController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $item)
    {
        // dd($item);
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->user()->customer->cart()->firstOrCreate();

        // dd($cart);

        $cartItem = $cart->product()->where('product_id', $item->id)->first();

        // dd($cartItem);


        if ($cartItem) {
            $cart->product()->updateExistingPivot($cartItem->id, [
                'quantity' => $request->quantity,
            ]);

            return redirect()->back()->with('success', 'Quantité du produit mise à jour.');
        } else {
            return redirect()->back()->withErrors('Produit introuvable dans le panier.');
        }
    }
}
