<?php

namespace App\Http\Controllers;

use App\Models\CategorySparePart;
use App\Models\Customer;
use App\Models\DeviceType;
use App\Models\Device;
use App\Models\PartUsage;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\SparePart;
use App\Models\StatusService;
use App\Models\StatusWarrantyService;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function show()
    {
        $users = User::all();
        $deviceTypes = DeviceType::all();
        $categorySpareParts = CategorySparePart::all();
        $spareParts = SparePart::with('categorySparePart')->get();

        $customers = Customer::with('user')->get();
        $devices = Device::all();

        $statusWarrantyServices = StatusWarrantyService::all();
        $statusServices = StatusService::all();

        $services = Service::with('customer', 'customer.user', 'statusWarrantyService', 'statusService', 'device', 'device.deviceType')->get();

        $serviceDetails = ServiceDetail::with('user', 'user.customer', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusWarrantyService', 'service.statusService')->get();
        $partUsages = PartUsage::with('serviceDetail', 'sparePart')->get();

        $printService = session('printService');
        $printServiceDetail = session('printServiceDetail');

        return Inertia::render('Dashboard', [
            'users' => $users,
            'deviceTypes' => $deviceTypes,
            'categorySpareParts' => $categorySpareParts,
            'spareParts' => $spareParts,

            'customers' => $customers,
            'devices' => $devices,

            'statusWarrantyServices' => $statusWarrantyServices,
            'statusServices' => $statusServices,

            'services' => $services,

            'serviceDetails' => $serviceDetails,
            'partUsages' => $partUsages,

            'printService' => $printService,
            'printServiceDetail' => $printServiceDetail,
        ]);
    }
}
