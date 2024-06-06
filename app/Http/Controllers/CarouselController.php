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
