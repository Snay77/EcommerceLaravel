<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ShowOrderController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        
    }
}
