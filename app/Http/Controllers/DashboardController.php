<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Customer;
use App\Models\DeviceType;
use Illuminate\Support\Str;
use App\Models\Device;
use App\Models\PartUsage;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\SparePart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show()
    {
        $users = User::all();
        $customers = Customer::all();
        $deviceTypes = DeviceType::all();
        $devices = Device::all();
        $services = Service::all();
        $serviceDetails = ServiceDetail::all();
        $spareParts = SparePart::all();
        $partUsages = PartUsage::all();

        return Inertia::render('Dashboard', [
            'users' => $users,
            'customers' => $customers,
            'deviceTypes' => $deviceTypes,
            'devices' => $devices,
            'services' => $services,
            'serviceDetails' => $serviceDetails,
            'spareParts' => $spareParts,
            'partUsages' => $partUsages,
        ]);
    }

    public function store_carousel(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'alt' => 'required|string|max:255',
        ]);

        $originalName = $request->file('image')->getClientOriginalName();
        $uniqueName = time() . '_' . $originalName;
        $path = $request->file('image')->storeAs('images', $uniqueName);

        Carousel::create([
            'alt' => $request->alt,
            'image_path' => 'storage/' . $path,
        ]);

        return Redirect::back();
    }

    public function store_customer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . Customer::class,
        ]);

        Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return Redirect::back();
    }

    public function store_device_type(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:device_types,type_name',
        ]);

        DeviceType::create([
            'type_name' => $request->type_name,
        ]);

        return Redirect::back();
    }

    public function store_device(Request $request)
    {
        $request->validate([
            'device_type_id' => 'required|exists:device_types,id',
            'model' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255|unique:devices,serial_number',
        ]);

        Device::create([
            'device_type_id' => $request->device_type_id,
            'model' => $request->model,
            'serial_number' => $request->serial_number,
        ]);

        return Redirect::back();
    }

    public function store_service(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'device_id' => 'required|exists:devices,id',
            'date_received' => 'date',
            'items_brought' => 'required|string|max:255',
            'estimated_completion' => 'date',
            'status' => 'required|string|max:255',
        ]);


        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => $request->customer_id,
            'device_id' => $request->device_id,
            'date_received' => $request->date_received,
            'items_brought' => $request->items_brought,
            'estimated_completion' => $request->estimated_completion,
            'status' => $request->status,
        ]);

        return Redirect::back();
    }

    public function store_service_detail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'problem_description' => 'required|string|max:255',
            'repair_description' => 'required|string|max:255',
            'cost' => 'required|integer',
        ]);

        ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(8)),
            'user_id' => $request->user_id,
            'service_id' => $request->service_id,
            'problem_description' => $request->problem_description,
            'repair_description' => $request->repair_description,
            'cost' => $request->cost,
        ]);

        return Redirect::back();
    }

    public function store_spare_part(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);

        SparePart::create([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return Redirect::back();
    }

    public function store_part_usage(Request $request)
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
}
