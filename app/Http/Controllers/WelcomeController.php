<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CategorySparePart;
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
        $categorySpareParts = CategorySparePart::all();
        $spareParts = SparePart::withoutGlobalScope('order')->inRandomOrder()->with('categorySparePart')->get();

        return Inertia::render('Welcome', [
            'carousels' => $carousels,
            'categorySpareParts' => $categorySpareParts,
            'spareParts' => $spareParts,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function store(Request $request, Carousel $carousels)
    {
        $service_code = $request->input('service_code');
        $service = Service::where('service_code', $service_code)->with('customer', 'customer.user', 'device', 'device.deviceType')->first();

        $carousels = Carousel::all();
        $categorySpareParts = CategorySparePart::all();
        $spareParts = SparePart::withoutGlobalScope('order')->inRandomOrder()->with('categorySparePart')->get();

        if ($service) {
            return Inertia::render('Welcome', [
                'carousels' => $carousels,
                'categorySpareParts' => $categorySpareParts,
                'spareParts' => $spareParts,
                'service' => $service,
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        }

        return Inertia::render('Welcome', [
            'carousels' => $carousels,
            'spareParts' => $spareParts,
            'message' => 'Service Code not found!',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
