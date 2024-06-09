<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
// Belum Selesai

class CarouselController extends Controller
{
    public function show()
    {
        $carousels = Carousel::all();
        return Inertia::render('Carousels', ['carousels' => $carousels]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt' => 'required|string|max:255',
        ]);

        $originalName = $request->file('image')->getClientOriginalName();
        $uniqueName = time() . '_' . $originalName;
        $path = $request->file('image')->storeAs('images', $uniqueName);

        Carousel::create([
            'alt' => $request->alt,
            'image_path' => 'storage/' . $path,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carousels,id',
        ]);

        $carousel = Carousel::find($request->input('id'));

        if ($carousel) {
            $path = str_replace('storage/', '', $carousel->image_path);
            Storage::disk('public')->delete($path);

            $carousel->delete();

            return Redirect::back();
        }

        return Redirect::back();
    }
}
