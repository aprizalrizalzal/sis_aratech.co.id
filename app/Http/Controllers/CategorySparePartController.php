<?php

namespace App\Http\Controllers;

use App\Models\CategorySparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategorySparePartController extends Controller
{
    public function show()
    {
        $categorySpareParts = CategorySparePart::all();

        return Inertia::render('SparePart/Category/CategorySpareParts', [
            'categorySpareParts' => $categorySpareParts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:' . CategorySparePart::class,
            'description' => 'required|string',
        ]);

        CategorySparePart::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:category_spare_parts,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $deviceType = CategorySparePart::findOrFail($request->id);

        $deviceType->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:category_spare_parts,id',
        ]);

        $deviceType = CategorySparePart::findOrFail($request->id);
        $deviceType->delete();

        return Redirect::back();
    }
}
