<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    public function __invoke(Request $request, $orderId)
    {
        $order = Order::with(['products', 'shippingadresse'])->findOrFail($orderId);

        return inertia('Order/Show', [
            'order' => $order,
        ]);
    }
}