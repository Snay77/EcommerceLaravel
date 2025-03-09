<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ListOrdersController extends Controller
{
    public function __invoke()
    {
        // Récupérer les commandes de l'utilisateur authentifié
        // $orders = Order::where('customer_id', Auth::id())->with('product')->get();

        // Renvoyer la vue avec la liste des commandes
        return inertia('Order/Index', [
            // 'orders' => $orders
        ]);
    }
}
