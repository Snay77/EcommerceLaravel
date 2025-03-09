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
        $validated = $request->validate([
            'street' => 'required|string|max:255',
            'postcode' => 'required|integer',
            'city' => 'required|string|max:255',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default']) {
            Addresse::where('customer_id', auth()->id())
                ->where('is_default', true)
                ->update(['is_default' => false]);
        }

        Addresse::create([
            'customer_id' => auth()->id(),
            'street' => $validated['street'],
            'postcode' => $validated['postcode'],
            'city' => $validated['city'],
            'is_default' => $validated['is_default'] ?? false,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Adresse ajoutée avec succès');
    }
}
