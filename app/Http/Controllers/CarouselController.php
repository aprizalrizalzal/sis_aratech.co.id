<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
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
            'url' => 'required|url'
        ]);

        $image = Carousel::create([
            'url' => $request->url
        ]);

        return response()->json($image, 201);
    }

    public function destroy($id)
    {
        $image = Carousel::findOrFail($id);
        $image->delete();

        return response()->json(null, 204);
    }
}
