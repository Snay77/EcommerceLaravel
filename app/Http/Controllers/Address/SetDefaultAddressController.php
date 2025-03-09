<?php
namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SetDefaultAddressController extends Controller
{
    public function __invoke(Request $request, Addresse $address)
    {
        dd($address);
    }
}
