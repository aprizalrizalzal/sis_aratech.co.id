<?php

namespace App\Http\Controllers;

use App\Models\PartUsage;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendEmailServiceDetail;
use App\Models\Service;
use App\Models\StatusService;
use App\Models\User;

class ServiceDetailController extends Controller
{
    public function show()
    {
        $services = Service::all();
        $statusServices = StatusService::all();
        $serviceDetails = ServiceDetail::with('user', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusWarrantyService', 'service.statusService')->get();

        return Inertia::render('ServiceDetail/ServiceDetails', [
            'serviceDetails' => $serviceDetails,
            'statusServices' => $statusServices,
            'services' => $services,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'status_service_id' => 'required|exists:status_services,id',
            'repair_description' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'notes' => 'required|string|max:255',
        ]);

        $existingServiceDetail = ServiceDetail::where('service_id', $request->service_id)->first();

        if ($existingServiceDetail) {
            return Redirect::back()->withErrors(['error' => 'A service detail already exists for this service.']);
        }

        $serviceDetail = ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(6)),
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'repair_description' => $request->repair_description,
            'cost' => $request->cost,
            'notes' => $request->notes,
        ]);

        $service = Service::findOrFail($request->service_id);
        $service->update([
            'status_service_id' => $request->status_service_id,
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
            'status_service_id' => 'required|exists:status_services,id',
            'repair_description' => 'required|string|max:255',
            'cost' => 'required|integer',
            'notes' => 'required|string|max:255',
        ]);

        $service = Service::findOrFail($request->service_id);
        $service->update([
            'status_service_id' => $request->status_service_id,
        ]);

        $serviceDetail = ServiceDetail::findOrFail($request->id);
        $serviceDetail->update([
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'repair_description' => $request->repair_description,
            'cost' => $request->cost,
            'notes' => $request->notes,
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
            ->with('user', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusWarrantyService', 'service.statusService')
            ->firstOrFail();

        $partUsages = PartUsage::with('sparePart')->where('service_detail_id', $serviceDetail->id)->get();

        $data = [
            'title' => "Asli Mandiri Computer",
            'body' => 'Rincian Service Details.',
            'email' => $serviceDetail->service->customer->user->email,
            //Data
            'serviceDetail' => $serviceDetail,
            'partUsages' => $partUsages,
        ];

        try {
            // Send the email
            Mail::to($data['email'])->send(new SendEmailServiceDetail($data));
        } catch (\Exception $e) {
            // Log the error message or take any action you need
            Log::error('Failed to send email: ' . $e->getMessage());

            // You can also set a flash message or some indication for the user
            session()->flash('error', 'Gagal mengirim email, silakan coba lagi nanti.');
        }

        return inertia('ServiceDetail/ServiceDetailPrint', [
            'serviceDetail' => $serviceDetail,
            'partUsages' => $partUsages
        ]);
    }
}
