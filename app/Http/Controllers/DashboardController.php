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
        $users = User::all();
        $deviceTypes = DeviceType::all();
        $spareParts = SparePart::all();

        $customers = Customer::all();
        $devices = Device::all();
        $services = Service::with('customer', 'customer.user', 'device', 'device.deviceType')->get();

        $serviceDetails = ServiceDetail::with('user', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType')->get();
        $partUsages = PartUsage::with('sparePart')->get();

        $printService = session('printService');
        $printServiceDetail = session('printServiceDetail');

        return Inertia::render('Dashboard', [
            'users' => $users,
            'deviceTypes' => $deviceTypes,
            'spareParts' => $spareParts,

            'customers' => $customers,
            'devices' => $devices,
            'services' => $services,

            'serviceDetails' => $serviceDetails,
            'partUsages' => $partUsages,

            'printService' => $printService,
            'printServiceDetail' => $printServiceDetail,




        ]);
    }
}
