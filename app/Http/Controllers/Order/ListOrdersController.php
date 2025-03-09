<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ListOrdersController extends Controller
{
    public function __invoke()
    {
        // Récupérer toutes les commandes de l'utilisateur connecté
        $orders = Order::where('customer_id', Auth::id()) // Filtre pour l'utilisateur connecté
            ->orderByDesc('created_at') // Trier par date de création, de la plus récente à la plus ancienne
            ->paginate(10); // Pagination des résultats
        

        // Renvoyer la vue avec la liste des commandes
        return inertia('Order/Index', [
            'orders' => $orders // Passer les commandes à la vue
        ]);
    }
}
