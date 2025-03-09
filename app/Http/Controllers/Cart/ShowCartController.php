<?php

namespace App\Http\Controllers\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Addresse;
use Inertia\Inertia;

class ShowCartController extends Controller
{
    public function __invoke(Request $request)
    {
        $cart = $request->user()->customer->cart;

        $defaultAddress = Addresse::where('customer_id', auth()->id())
            ->where('is_default', true)
            ->first();

        if ($cart) {
            $cart->load('product');
            $total = $cart->product->sum(fn($item) => $item->pivot->quantity * $item->price);
            $totalEspace = number_format($total, 2, '.', ' ');
        } else {
            $total = 0;
            $totalEspace = '0.00';
        }

        return Inertia::render('Cart/Show', [
            'cart' => $cart ?? null,
            'total' => $totalEspace,
            'defaultAddress' => $defaultAddress
        ]);
    }
}
