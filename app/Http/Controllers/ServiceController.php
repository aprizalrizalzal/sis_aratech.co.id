<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class ServiceController extends Controller
{
    public function show()
    {
        $services = Service::with('customer', 'customer.user', 'device', 'device.deviceType')->get();

        return Inertia::render('Service/Services', [
            'services' => $services
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'status_warranty' => 'required|string|max:255',
            'date_received' => 'date',
            'problem_description' => 'required|string|max:255',
            'estimated_completion' => 'date',
            'items_brought' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);


        $service = Service::create([
            'service_code' => Str::upper(Str::random(6)),
            'customer_id' => $request->customer_id,
            'device_id' => $request->device_id,
            'status_warranty' => $request->status_warranty,
            'date_received' => $request->date_received,
            'problem_description' => $request->problem_description,
            'estimated_completion' => $request->estimated_completion,
            'items_brought' => $request->items_brought,
            'status' => $request->status,
        ]);

        $printService = route('service.print', $service->service_code);

        return Redirect::back()->with([
            'printService' => $printService
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id',
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'status_warranty' => 'required|string|max:255',
            'date_received' => 'date',
            'problem_description' => 'required|string|max:255',
            'estimated_completion' => 'date',
            'items_brought' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $service = Service::findOrFail($request->id);

        $service->update([
            'customer_id' => $request->customer_id,
            'device_id' => $request->device_id,
            'status_warranty' => $request->status_warranty,
            'date_received' => $request->date_received,
            'problem_description' => $request->problem_description,
            'estimated_completion' => $request->estimated_completion,
            'items_brought' => $request->items_brought,
            'status' => $request->status,
        ]);

        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:services,id',
        ]);

        $service = Service::findOrFail($request->id);
        $service->delete();

        return Redirect::back();
    }

    public function print($service_code)
    {
        $service = Service::where('service_code', $service_code)
            ->with('customer', 'customer.user', 'device', 'device.deviceType')
            ->firstOrFail();

        $data = [
            'title' => "Service Code $service->service_code",
            'body' => 'Di bawah ini adalah rincian service Anda.',
            'email' => $service->customer->user->email,
            'service' => $service,
        ];

        // Send the email
        Mail::to($data['email'])->send(new SendEmail($data));

        return inertia('Service/ServicePrint', [
            'service' => $service
        ]);
    }
}
