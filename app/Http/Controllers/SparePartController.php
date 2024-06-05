<?php

namespace App\Http\Controllers;

use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SparePartController extends Controller
{
    public function show()
    {
        $spareParts = SparePart::all();

        return Inertia::render('SpareParts', [
            'spareParts' => $spareParts
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);

        $sparePart = SparePart::find($request->input('id'));

        $sparePart->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:spare_parts,id',
        ]);

        $sparePart = SparePart::find($request->input('id'));

        if ($sparePart) {
            $sparePart->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
