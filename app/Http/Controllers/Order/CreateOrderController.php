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

        // Récupérer l'adresse par défaut dans la table 'addresses'
        $defaultAddress = Addresse::where('customer_id', auth()->id())
            ->where('is_default', true)
            ->first();

        if (!$defaultAddress) {
            return back()->withErrors(['error' => 'Veuillez définir une adresse de livraison']);
        }

        // Créer une nouvelle entrée dans 'shipping_addresses' sans relation avec 'customer_id'
        $shippingAddress = ShippingAddresse::create([
            'street' => $defaultAddress->street,
            'postcode' => $defaultAddress->postcode,
            'city' => $defaultAddress->city,
        ]);

        // Calculer le total
        $totalAmount = $cart->product->sum(function($item) {
            return $item->pivot->quantity * $item->price;
        });

        // Créer la commande avec l'adresse de livraison
        $order = Order::create([
            'customer_id' => $request->user()->customer->id,
            'shipping_addresses_id' => $shippingAddress->id, // Utiliser la nouvelle adresse créée
            'total_amount' => $totalAmount,
            'status' => 'pending'
        ]);

        // Ajouter les produits à la commande
        foreach ($cart->product as $product) {
            $order->product()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'price' => $product->price
            ]);
        }

        // Vider le panier
        $cart->product()->detach();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Votre commande a été passée avec succès');
    }
}
