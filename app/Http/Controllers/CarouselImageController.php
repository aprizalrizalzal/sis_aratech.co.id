<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;

class CarouselImageController extends Controller
{
    public function index()
    {
        $images = CarouselImage::all();
        return response()->json($images);
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $image = CarouselImage::create([
            'url' => $request->url
        ]);

        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        $image = CarouselImage::findOrFail($id);
        $image->delete();

        return response()->json(null, 204);
    }
}
