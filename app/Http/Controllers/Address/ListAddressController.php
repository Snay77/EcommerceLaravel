<?php
namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class ListAddressController extends Controller
{
    public function __invoke()
    {
        $addresses = Addresse::where('customer_id', auth()->id())->get();

        return Inertia::render('Address/Index', [
            'addresses' => $addresses
        ]);
    }
}
