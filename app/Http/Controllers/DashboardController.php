<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
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
        // Chart
        $users = User::all();
        $carousels = Carousel::all();
        $deviceTypes = DeviceType::all();
        $customers = Customer::all();
        $devices = Device::all();
        $services = Service::all();
        $serviceDetails = ServiceDetail::all();
        $spareParts = SparePart::all();
        $partUsages = PartUsage::all();

        // Add Service Print
        $printService = session('printService');

        // Add ServiceDetail Print
        $printServiceDetail = session('printServiceDetail');

        return Inertia::render('Dashboard', [
            // Chart
            'users' => $users,
            'customers' => $customers,
            'carousels' => $carousels,
            'deviceTypes' => $deviceTypes,
            'devices' => $devices,
            'services' => $services,
            'serviceDetails' => $serviceDetails,
            'spareParts' => $spareParts,
            'partUsages' => $partUsages,

            // Add Service Print
            'printService' => $printService,

            // Add ServiceDetail Print
            'printServiceDetail' => $printServiceDetail,

        ]);
    }
}
