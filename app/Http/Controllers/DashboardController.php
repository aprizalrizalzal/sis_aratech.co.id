<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\Device;
use App\Models\PartUsage;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\SparePart;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show()
    {
        $deviceTypes = DeviceType::all();
        $customers = Customer::all();
        $devices = Device::all();
        $services = Service::with('customer', 'customer.user', 'device')->get();
        $serviceDetails = ServiceDetail::with('user', 'service')->get();
        $spareParts = SparePart::all();

        $customers = Customer::all();
        $devices = Device::all();
        $deviceTypes = DeviceType::all();
        $partUsages = PartUsage::all();
        $users = User::all();

        $printService = session('printService');
        $printServiceDetail = session('printServiceDetail');

        return Inertia::render('Dashboard', [
            'users' => $users,
            'customers' => $customers,
            'deviceTypes' => $deviceTypes,
            'devices' => $devices,
            'partUsages' => $partUsages,

            'deviceTypes' => $deviceTypes,
            'customers' => $customers,
            'devices' => $devices,
            'services' => $services,
            'serviceDetails' => $serviceDetails,
            'spareParts' => $spareParts,

            'printService' => $printService,
            'printServiceDetail' => $printServiceDetail,
        ]);
    }
}
