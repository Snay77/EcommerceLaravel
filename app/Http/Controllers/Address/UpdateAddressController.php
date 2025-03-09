<?php

namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateAddressController extends Controller
{
    public function __invoke(Request $request, Addresse $address)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'postcode' => 'required|integer',
            'city' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        // Vérifier si l'utilisateur souhaite définir cette adresse comme "par défaut"
        if ($validated['is_default']) {
            // Si l'utilisateur définit cette adresse comme par défaut, on doit enlever "is_default" à l'ancienne adresse par défaut
            Addresse::where('customer_id', $address->customer_id)
                ->where('is_default', true)
                ->where('id', '!=', $address->id) // On exclut l'adresse courante
                ->update(['is_default' => false]);
        }

        // Mettre à jour l'adresse
        $address->update([
            'street' => $validated['street'],
            'postcode' => $validated['postcode'],
            'city' => $validated['city'],
            'is_default' => $validated['is_default'] ?? false,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Adresse mise à jour avec succès');
    }
}
