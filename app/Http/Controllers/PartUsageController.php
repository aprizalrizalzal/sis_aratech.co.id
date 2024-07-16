<?php

namespace App\Http\Controllers;

use App\Models\PartUsage;
use App\Models\ServiceDetail;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PartUsageController extends Controller
{
    public function show()
    {
        $spareParts = SparePart::all();
        $serviceDetails = ServiceDetail::with('user', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusService')->get();
        $partUsages = PartUsage::with('serviceDetail', 'serviceDetail.user', 'serviceDetail.service', 'serviceDetail.service.customer.user', 'sparePart')->get();

        return Inertia::render('PartUsage/PartUsages', [
            'partUsages' => $partUsages,
            'serviceDetails' => $serviceDetails,
            'spareParts' => $spareParts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_detail_id' => 'required|exists:service_details,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        PartUsage::create([
            'service_detail_id' => $request->service_detail_id,
            'spare_part_id' => $request->spare_part_id,
            'quantity' => $request->quantity,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:part_usages,id',
            'service_detail_id' => 'required|exists:service_details,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $partUsage = PartUsage::findOrFail($request->id);

        $partUsage->update([
            'service_detail_id' => $request->service_detail_id,
            'spare_part_id' => $request->spare_part_id,
            'quantity' => $request->quantity,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:part_usages,id',
        ]);

        $partUsage = PartUsage::findOrFail($request->id);
        $partUsage->delete();

        return Redirect::back();
    }
}
