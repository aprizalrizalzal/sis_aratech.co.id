<?php

namespace App\Http\Controllers;

use App\Models\TypeFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TypeFooterController extends Controller
{
    public function show()
    {
        $typeFooters = TypeFooter::all();

        return Inertia::render('Setting/Footer/Type/TypeFooters', [
            'typeFooters' => $typeFooters
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:' . TypeFooter::class,
            'description' => 'required|string',
        ]);

        TypeFooter::create([
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:type_footers,id',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $typeFooter = TypeFooter::findOrFail($request->id);

        $typeFooter->update([
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:type_footers,id',
        ]);

        $typeFooter = TypeFooter::findOrFail($request->id);
        $typeFooter->delete();

        return Redirect::back();
    }
}
