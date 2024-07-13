<?php

namespace App\Http\Controllers;

use App\Models\StatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StatusServiceController extends Controller
{
    public function show()
    {
        $statusServices = StatusService::all();

        return Inertia::render('Service/Status/StatusServices', [
            'statusServices' => $statusServices
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255|unique:' . StatusService::class,
            'description' => 'required|string',
        ]);

        StatusService::create([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:status_services,id',
            'status' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $statusService = StatusService::findOrFail($request->id);

        $statusService->update([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:status_services,id',
        ]);

        $statusService = StatusService::findOrFail($request->id);
        $statusService->delete();

        return Redirect::back();
    }
}
