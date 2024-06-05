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

    public function update(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:device_types,type_name',
        ]);

        $deviceType = DeviceType::find($request->input('id'));

        $deviceType->update([
            'type_name' => $request->type_name,
        ]);

        return Redirect::back();
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
