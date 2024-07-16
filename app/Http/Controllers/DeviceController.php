<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function show()
    {
        $deviceTypes = DeviceType::all();
        $devices = Device::with('deviceType')->get();

        return Inertia::render('Device/Devices', [
            'devices' => $devices,
            'deviceTypes' => $deviceTypes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:' . Device::class,
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
            'id' => 'required|exists:devices,id',
            'device_type_id' => 'required|exists:device_types,id',
            'model' => 'required|string|max:255',
            'serial_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('devices')->ignore($request->id),
            ],
        ]);

        $device = Device::findOrFail($request->id);

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

        $device = Device::findOrFail($request->id);
        $device->delete();

        return Redirect::back();
    }
}
