<?php

namespace App\Http\Controllers;

use App\Models\StatusWarrantyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StatusWarrantyServiceController extends Controller
{
    public function show()
    {
        $statusWarrantyServices = StatusWarrantyService::all();

        return Inertia::render('Service/Status/Warranty/StatusWarrantyServices', [
            'statusWarrantyServices' => $statusWarrantyServices
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255|unique:' . StatusWarrantyService::class,
            'description' => 'required|string',
        ]);

        StatusWarrantyService::create([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:status_warranty_services,id',
            'status' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $statusWarrantyService = StatusWarrantyService::findOrFail($request->id);

        $statusWarrantyService->update([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:status_warranty_services,id',
        ]);

        $statusWarrantyService = StatusWarrantyService::findOrFail($request->id);
        $statusWarrantyService->delete();

        return Redirect::back();
    }
}
