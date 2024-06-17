<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Service;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function show()
    {
        $carousels = Carousel::all();
        $spareParts = SparePart::all();

        return Inertia::render('Welcome', [
            'carousels' => $carousels,
            'spareParts' => $spareParts,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function store(Request $request, Carousel $carousels)
    {
        $service_code = $request->input('service_code');
        $service = Service::where('service_code', $service_code)->with('customer', 'customer.user', 'device')->first();

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
