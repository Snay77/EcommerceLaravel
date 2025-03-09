<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    public function __invoke(Request $request, $orderId)
    {
        // Récupérer la commande avec ses produits et l'adresse de livraison
        $order = Order::with(['product', 'shippingadresse'])->findOrFail($orderId);

        // dd($order);

        // Passer l'objet $order à la vue
        return inertia('Order/Show', [
            'order' => $order,  // Passer l'objet order ici
        ]);
    }
}