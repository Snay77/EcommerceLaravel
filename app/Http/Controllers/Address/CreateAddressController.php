<?php
namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CreateAddressController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'postcode' => 'required|integer',
            'city' => 'required|string|max:255',
            'is_default' => 'boolean', // Cela peut être vrai ou faux
        ]);

        // Vérifier si l'utilisateur souhaite définir cette adresse comme "par défaut"
        if ($validated['is_default']) {
            // S'assurer qu'une seule adresse peut être définie par défaut pour l'utilisateur
            // 1. Trouver l'adresse existante par défaut et la mettre à jour
            Addresse::where('customer_id', auth()->id())
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        // Créer la nouvelle adresse
        Addresse::create([
            'customer_id' => auth()->id(),
            'street' => $validated['street'],
            'postcode' => $validated['postcode'],
            'city' => $validated['city'],
            'is_default' => $validated['is_default'] ?? false, // Si aucune valeur n'est fournie, on la définit comme "false"
        ]);

        // Rediriger ou renvoyer une réponse
        return redirect()->route('addresses.index')->with('success', 'Adresse ajoutée avec succès');
    }
}
