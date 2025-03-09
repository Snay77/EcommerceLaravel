<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        // Charger la commande avec ses produits et l'adresse de livraison
        $order->load(['product', 'shippingadresse']);

        // Passer l'objet $order à la vue
        return inertia('Order/Show', [
            'order' => $order,  // Passer l'objet order ici
        ]);
    }
}
