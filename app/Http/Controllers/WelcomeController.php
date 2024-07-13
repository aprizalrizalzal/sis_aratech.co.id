<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CategorySparePart;
use App\Models\Service;
use App\Models\SparePart;
use App\Models\StatusService;
use App\Models\StatusWarrantyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function show()
    {
        $statusServices = StatusService::all();
        $statusWarrantyServices = StatusWarrantyService::all();
        $categorySpareParts = CategorySparePart::all();
        $carousels = Carousel::all();
        $spareParts = SparePart::withoutGlobalScope('order')->inRandomOrder()->with('categorySparePart')->get();

        return Inertia::render('Welcome', [
            'statusServices' => $statusServices,
            'statusWarrantyServices' => $statusWarrantyServices,
            'categorySpareParts' => $categorySpareParts,
            'carousels' => $carousels,
            'spareParts' => $spareParts,

            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function store(Request $request, Carousel $carousels)
    {
        $categorySpareParts = CategorySparePart::all();
        $carousels = Carousel::all();
        $spareParts = SparePart::withoutGlobalScope('order')->inRandomOrder()->with('categorySparePart')->get();

        $service_code = $request->input('service_code');
        $service = Service::where('service_code', $service_code)->with('customer', 'customer.user', 'device', 'device.deviceType', 'statusWarrantyService', 'statusService')->first();

        if ($service) {
            return Inertia::render('Welcome', [
                'categorySpareParts' => $categorySpareParts,
                'carousels' => $carousels,
                'spareParts' => $spareParts,
                'service' => $service,

                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        }

        return Inertia::render('Welcome', [
            'categorySpareParts' => $categorySpareParts,
            'carousels' => $carousels,
            'spareParts' => $spareParts,
            'message' => 'Service Code not found!',

            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
