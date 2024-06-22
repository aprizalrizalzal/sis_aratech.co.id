<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CarouselController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
            'alt' => 'required|string|max:255',
        ]);

        $originalName = $request->file('image')->getClientOriginalName();
        $uniqueName = time() . '_' . $originalName;
        $path = $request->file('image')->storeAs('images/carousel', $uniqueName, 'public');

        Carousel::create([
            'alt' => $request->alt,
            'image_path' => 'storage/' . $path,
        ]);

        return Redirect::back();
    }

    public function update_image(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carousels,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:512',
        ]);

        $carousel = Carousel::findOrFail($request->id);

        if ($request->hasFile('image')) {
            $oldPath = str_replace('storage/', '', $carousel->image_path);
            Storage::disk('public')->delete($oldPath);

            $originalName = $request->file('image')->getClientOriginalName();
            $uniqueName = time() . '_' . $originalName;
            $path = $request->file('image')->storeAs('images/carousel', $uniqueName, 'public');

            $carousel->image_path = 'storage/' . $path;
            $carousel->save();
        }

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carousels,id',
            'alt' => 'required|string|max:255',
        ]);

        $carousel = Carousel::findOrFail($request->id);

        $carousel->update([
            'alt' => $request->alt,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carousels,id',
        ]);

        $carousel = Carousel::findOrFail($request->id);

        $path = str_replace('storage/', '', $carousel->image_path);
        Storage::disk('public')->delete($path);

        $carousel->delete();

        return Redirect::back();
    }
}
