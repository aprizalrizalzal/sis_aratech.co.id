<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function show_carousel()
    {
        $carousels = Carousel::all();

        return Inertia::render('Welcome', [
            'carousels' => $carousels,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function store_service_code(Request $request, Carousel $carousels)
    {
        $service_code = $request->input('service_code');
        $service = Service::where('service_code', $service_code)->with('customer', 'device')->first();

        $carousels = Carousel::all();

        if ($service) {
            return Inertia::render('Welcome', [
                'carousels' => $carousels,
                'service' => $service,
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        }

        return Inertia::render('Welcome', [
            'carousels' => $carousels,
            'message' => 'Service Code not found!',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
