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

        return Inertia::render('DeviceType/DeviceTypes', [
            'deviceTypes' => $deviceTypes
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:' . DeviceType::class,
            'description' => 'required|string',
        ]);

        DeviceType::create([
            'type_name' => $request->type_name,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:device_types,id',
            'type_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $deviceType = DeviceType::findOrFail($request->id);

        $deviceType->update([
            'type_name' => $request->type_name,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:device_types,id',
        ]);

        $deviceType = DeviceType::findOrFail($request->id);
        $deviceType->delete();

        return Redirect::back();
    }
}
