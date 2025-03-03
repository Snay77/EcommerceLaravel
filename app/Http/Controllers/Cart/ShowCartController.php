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
        $cart = $request->user()->customer->cart()
            ->with(['items.product'])
            ->first();

        return Inertia::render('Cart/Show', [
            'cart' => $cart ? [
                'items' => $cart->items->map(fn($item) => [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'product' => [
                        'id' => $item->product->id,
                        'label' => $item->product->label,
                        'price' => $item->product->price,
                        'stock' => $item->product->stock,
                        'cover_image' => $item->product->cover_image?->url
                    ]
                ]),
                'total' => $cart->items->sum(fn($item) => $item->quantity * $item->product->price)
            ] : null
        ]);
    }
}
