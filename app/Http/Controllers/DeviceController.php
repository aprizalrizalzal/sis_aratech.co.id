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

        return Inertia::render('Device/Devices', [
            'devices' => $devices
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:devices,serial_number',
        ]);

        Device::create([
            'device_type_id' => $request->device_type_id,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
        ]);

        $device = Device::find($request->input('id'));

        $device->update([
            'device_type_id' => $request->device_type_id,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
        ]);

        return Redirect::back();
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
