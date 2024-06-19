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
        $deviceTypes = DeviceType::all();
        $customers = Customer::all();
        $devices = Device::all();
        $services = Service::with('customer', 'customer.user', 'device')->get();
        $serviceDetails = ServiceDetail::with('user', 'service')->get();

        $carouselCount = Carousel::count();
        $customerCount = Customer::count();
        $deviceCount = Device::count();
        $deviceTypeCount = DeviceType::count();
        $partUsageCount = PartUsage::count();
        $sparePartCount = SparePart::count();
        $userCount = User::count();

        $carouselCreatedAt = Carousel::latest()->first()->created_at ?? null;
        $customerCreatedAt = Customer::latest()->first()->created_at ?? null;
        $deviceCreatedAt = Device::latest()->first()->created_at ?? null;
        $deviceTypeCreatedAt = DeviceType::latest()->first()->created_at ?? null;
        $partUsageCreatedAt = PartUsage::latest()->first()->created_at ?? null;
        $sparePartCreatedAt = SparePart::latest()->first()->created_at ?? null;
        $userCreatedAt = User::latest()->first()->created_at ?? null;

        $printService = session('printService');
        $printServiceDetail = session('printServiceDetail');

        return Inertia::render('Dashboard', [
            'userCount' => $userCount,
            'customerCount' => $customerCount,
            'carouselCount' => $carouselCount,
            'deviceTypeCount' => $deviceTypeCount,
            'deviceCount' => $deviceCount,
            'partUsageCount' => $partUsageCount,
            'sparePartCount' => $sparePartCount,

            'userCreatedAt' => $userCreatedAt,
            'customerCreatedAt' => $customerCreatedAt,
            'carouselCreatedAt' => $carouselCreatedAt,
            'deviceTypeCreatedAt' => $deviceTypeCreatedAt,
            'deviceCreatedAt' => $deviceCreatedAt,
            'partUsageCreatedAt' => $partUsageCreatedAt,
            'sparePartCreatedAt' => $sparePartCreatedAt,

            'deviceTypes' => $deviceTypes,
            'customers' => $customers,
            'devices' => $devices,
            'services' => $services,
            'serviceDetails' => $serviceDetails,

            'printService' => $printService,
            'printServiceDetail' => $printServiceDetail,
        ]);
    }
}
