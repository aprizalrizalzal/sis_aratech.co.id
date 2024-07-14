<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\PlatformFooter;
use App\Models\TypeFooter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function show()
    {
        $carousels = Carousel::all();
        $typeFooters = TypeFooter::all();
        $platformFooters = PlatformFooter::all();

        return Inertia::render('Setting/Edit', [
            'carousels' => $carousels,
            'typeFooters' => $typeFooters,
            'platformFooters' => $platformFooters,
        ]);
    }
}
