<?php
namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeleteAddressController extends Controller
{
    public function __invoke(Request $request, Addresse $address)
    {
        $address->delete();
        return redirect()->route('addresses.index'); // rediriger après suppression
    }
}
