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

    public function update(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'date_received' => 'date',
            'items_brought' => 'required|string|max:255',
            'estimated_completion' => 'date',
            'status' => 'required|string|max:255',
        ]);

        $service = Service::find($request->input('id'));

        $service->update([
            'customer_id' => $request->customer_id,
            'device_id' => $request->device_id,
            'date_received' => $request->date_received,
            'items_brought' => $request->items_brought,
            'estimated_completion' => $request->estimated_completion,
            'status' => $request->status,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id',
        ]);

        $service = Service::find($request->input('id'));

        if ($service) {
            $service->delete();
            return Redirect::back();
        }

        return Redirect::back();
    }
}
