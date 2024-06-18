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
        $carousels = Carousel::count();
        $customers = Customer::count();
        $devices = Device::count();
        $deviceTypes = DeviceType::count();
        $partUsages = PartUsage::count();
        $services = Service::with('customer', 'customer.user', 'device')->get();
        $serviceDetails = ServiceDetail::get();
        $spareParts = SparePart::count();
        $users = User::count();

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
