<?php

namespace App\Http\Controllers;

use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DeviceTypeController extends Controller
{
    public function show()
    {
        $deviceTypes = DeviceType::all();

        return Inertia::render('DeviceTypes', [
            'deviceTypes' => $deviceTypes
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:device_types,id',
        ]);

        $deviceType = DeviceType::find($request->input('id'));

        if ($deviceType) {
            $deviceType->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
