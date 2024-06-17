<?php

namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ServiceDetailController extends Controller
{
    public function show()
    {
        $serviceDetails = ServiceDetail::with('user', 'service')->get();

        return Inertia::render('ServiceDetail/ServiceDetails', [
            'serviceDetails' => $serviceDetails
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'problem_description' => 'required|string|max:255',
            'repair_description' => 'nullable|string|max:255',
            'cost' => 'required|numeric',
        ]);

        $existingServiceDetail = ServiceDetail::where('service_id', $request->service_id)->first();

        if ($existingServiceDetail) {
            return Redirect::back()->withErrors(['error' => 'A service detail already exists for this service.']);
        }

        $serviceDetail = ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(8)),
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'problem_description' => $request->problem_description,
            'repair_description' => $request->repair_description,
            'cost' => $request->cost,
        ]);

        $printServiceDetail = route('service.detail.print', $serviceDetail->service_detail_code);

        return Redirect::back()->with([
            'printServiceDetail' => $printServiceDetail
        ]);
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|exists:service_details,id',
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'problem_description' => 'required|string|max:255',
            'repair_description' => 'required|string|max:255',
            'cost' => 'required|integer',
        ]);

        $serviceDetail = ServiceDetail::findOrFail($request->id);

        $serviceDetail->update([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'problem_description' => $request->problem_description,
            'repair_description' => $request->repair_description,
            'cost' => $request->cost,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:service_details,id',
        ]);

        $serviceDetail = ServiceDetail::findOrFail($request->id);
        $serviceDetail->delete();

        return Redirect::back();
    }

    public function print($service_detail_code)
    {
        $serviceDetail = ServiceDetail::where('service_detail_code', $service_detail_code)
            ->with('user', 'service')
            ->firstOrFail();

        return inertia('ServiceDetail/ServiceDetailPrint', [
            'serviceDetail' => $serviceDetail
        ]);
    }
}
