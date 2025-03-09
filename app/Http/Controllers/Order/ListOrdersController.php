<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ListOrdersController extends Controller
{
    public function __invoke()
    {
        $customer = Auth::user()->customer;
        $orders = $customer->orders()
            ->with(['product', 'shippingadresse'])
            ->orderByDesc('created_at')
            ->get();

        return inertia('Order/Index', [
            'orders' => $orders
        ]);
    }
} 