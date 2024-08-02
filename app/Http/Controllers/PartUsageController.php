<?php

namespace App\Http\Controllers;

use App\Models\PartUsage;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\SparePart;
use App\Models\StatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PartUsageController extends Controller
{
    public function show()
    {
        $spareParts = SparePart::all();
        $statusServices = StatusService::all();
        $serviceDetails = ServiceDetail::with('user', 'user.customer', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusService')->get();
        $partUsages = PartUsage::with('serviceDetail', 'serviceDetail.user', 'serviceDetail.service', 'serviceDetail.service.customer.user', 'sparePart')->get();

        return Inertia::render('PartUsage/PartUsages', [
            'partUsages' => $partUsages,
            'serviceDetails' => $serviceDetails,
            'statusServices' => $statusServices,
            'spareParts' => $spareParts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_detail_id' => 'required|exists:service_details,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'status_service_id' => 'required|exists:status_services,id',
            'quantity' => 'required|integer|min:1',
        ]);

        PartUsage::create([
            'service_detail_id' => $request->service_detail_id,
            'spare_part_id' => $request->spare_part_id,
            'quantity' => $request->quantity,
        ]);

        $serviceDetail = ServiceDetail::findOrFail($request->service_detail_id);
        $serviceId = $serviceDetail->service_id;

        $service = Service::findOrFail($serviceId);
        $service->update([
            'status_service_id' => $request->status_service_id,
        ]);

        return Redirect::back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:part_usages,id',
            'service_detail_id' => 'required|exists:service_details,id',
            'status_service_id' => 'required|exists:status_services,id',
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $partUsage = PartUsage::findOrFail($request->id);

        $partUsage->update([
            'service_detail_id' => $request->service_detail_id,
            'spare_part_id' => $request->spare_part_id,
            'quantity' => $request->quantity,
        ]);

        $serviceDetail = ServiceDetail::findOrFail($request->service_detail_id);
        $serviceId = $serviceDetail->service_id;

        $service = Service::findOrFail($serviceId);
        $service->update([
            'status_service_id' => $request->status_service_id,
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
