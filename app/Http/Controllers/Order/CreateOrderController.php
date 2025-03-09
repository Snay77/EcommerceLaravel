<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Addresse;
use App\Models\Order;
use App\Models\ShippingAddresse;
use Illuminate\Http\Request;

class CreateOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $cart = $request->user()->customer->cart;
        
        if (!$cart || $cart->product->isEmpty()) {
            return back()->withErrors(['error' => 'Votre panier est vide']);
        }

        $defaultAddress = Addresse::where('customer_id', auth()->id())
            ->where('is_default', true)
            ->first();

        if (!$defaultAddress) {
            return back()->withErrors(['error' => 'Veuillez définir une adresse de livraison']);
        }

        $shippingAddress = ShippingAddresse::create([
            'street' => $defaultAddress->street,
            'postcode' => $defaultAddress->postcode,
            'city' => $defaultAddress->city,
        ]);

        $totalAmount = $cart->product->sum(function($item) {
            return $item->pivot->quantity * $item->price;
        });

        $order = Order::create([
            'customer_id' => $request->user()->customer->id,
            'shipping_addresses_id' => $shippingAddress->id,
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        foreach ($cart->product as $product) {
            $order->product()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price' => $product->price
            ]);
        }

        $cart->product()->detach();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Votre commande a été passée avec succès');
    }
}
