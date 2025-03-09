<?php

namespace App\Http\Controllers\Cart;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ShowCartController extends Controller
{
    public function __invoke(Request $request)
    {
        $cart = $request->user()->customer->cart
            ->load('product')
            ->first();

        $total = $cart ? $cart->product->sum(fn($item) => $item->pivot->quantity * $item->price) : 0;
        // dd($total);
        $totalEspace = number_format($total, 2, '.', ' ');

        return Inertia::render(
            'Cart/Show',
            [
                'cart' => $cart,
                'total' => $totalEspace
            ]
        );
    }
}
