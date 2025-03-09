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
        // Récupérer les adresses de l'utilisateur authentifié
        $addresses = Addresse::where('customer_id', auth()->id())->get();

        // Retourner la vue avec les adresses
        return Inertia::render('Address/Index', [
            'addresses' => $addresses
        ]);
    }
}
