<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function show()
    {
        $devices = Device::with('deviceType')->get();

        return Inertia::render('Devices', [
            'devices' => $devices
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:devices,id',
        ]);

        $device = Device::find($request->input('id'));

        if ($device) {
            $device->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
