<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListOrdersController extends Controller
{
    public function __invoke()
    {
        // Récupérer toutes les commandes de l'utilisateur connecté avec leurs relations
        $customer = Auth::user()->customer;
        $orders = $customer->orders()
            ->with(['product', 'shippingadresse'])
            ->orderByDesc('created_at')
            ->get();

        // Renvoyer la vue avec la liste des commandes
        return inertia('Order/Index', [
            'orders' => $orders
        ]);
    }
} 