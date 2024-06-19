<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function show()
    {
        $carousels = Carousel::all();

        return Inertia::render('Setting/Edit',[
            'carousels' => $carousels
        ]);
    }
}
