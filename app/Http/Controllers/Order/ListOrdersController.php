<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ListOrdersController extends Controller
{
    public function __invoke()
    {
        // Renvoyer la vue avec la liste des commandes
        return inertia('Order/Index', [
            // 'orders' => $orders
        ]);
    }
}
