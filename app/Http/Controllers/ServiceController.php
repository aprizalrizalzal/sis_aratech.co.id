<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ServiceController extends Controller
{
    public function show()
    {
        $services = Service::with('customer', 'device')->get();

        return Inertia::render('Services', [
            'services' => $services
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:service,id',
        ]);

        $service = Service::find($request->input('id'));

        if ($service) {
            $service->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
