<?php

namespace App\Http\Controllers;

use App\Models\CategorySparePart;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SparePartController extends Controller
{
    public function show()
    {
        $categorySpareParts = CategorySparePart::all();
        $spareParts = SparePart::with('categorySparePart')->get();

        return Inertia::render('SparePart/SpareParts', [
            'spareParts' => $spareParts,
            'categorySpareParts' => $categorySpareParts
        ]);
    }

    public function show_detail(Request $request)
    {
        $sparePart = SparePart::findOrFail($request->id);

        return Inertia::render('SparePart/SparePartDetail', [
            'sparePart' => $sparePart,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'name' => 'required|string|max:255|unique:' . SparePart::class,
            'category_spare_part_id' => 'required|exists:category_spare_parts,id',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        $originalName = $request->file('image')->getClientOriginalName();
        $uniqueName = time() . '_' . $originalName;
        $path = $request->file('image')->storeAs('images/spareParts', $uniqueName, 'public');

        SparePart::create([
            'image_path' => 'storage/' . $path,
            'name' => $request->name,
            'category_spare_part_id' => $request->category_spare_part_id,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return Redirect::back();
    }

    public function update_image(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:spare_parts,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:512',
        ]);

        $sparePart = SparePart::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $oldPath = str_replace('storage/', '', $sparePart->image_path);
            Storage::disk('public')->delete($oldPath);

            $originalName = $request->file('image')->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $path = $request->file('image')->storeAs('images/spareParts', $uniqueName, 'public');

            $sparePart->image_path = 'storage/' . $path;
            $sparePart->save();
        }

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:spare_parts,id',
            'name' => 'required|string|max:255',
            'category_spare_part_id' => 'required|exists:category_spare_parts,id',
            'description' => 'required|string',
            'price' => 'required|integer',
        ]);

        $sparePart = SparePart::findOrFail($request->id);

        $sparePart->update([
            'name' => $request->name,
            'category_spare_part_id' => $request->category_spare_part_id,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:spare_parts,id',
        ]);

        $sparePart = SparePart::findOrFail($request->id);

        $path = str_replace('storage/', '', $sparePart->image_path);
        Storage::disk('public')->delete($path);

        $sparePart->delete();

        return Redirect::back();
    }
}
