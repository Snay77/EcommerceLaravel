<?php

namespace App\Http\Controllers\Address;

use App\Models\Addresse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateAddressController extends Controller
{
    public function __invoke(Request $request, Addresse $address)
    {
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'postcode' => 'required|integer',
            'city' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default']) {
            Addresse::where('customer_id', $address->customer_id)
                ->where('is_default', true)
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update([
            'street' => $validated['street'],
            'postcode' => $validated['postcode'],
            'city' => $validated['city'],
            'is_default' => $validated['is_default'] ?? false,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Adresse mise à jour avec succès');
    }
}
