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
        $carousels = Carousel::all();
        $deviceTypes = DeviceType::all();
        $customers = Customer::all();
        $devices = Device::all();
        $services = Service::all();
        $serviceDetails = ServiceDetail::all();
        $spareParts = SparePart::all();
        $partUsages = PartUsage::all();

        return Inertia::render('Dashboard', [
            'users' => $users,
            'customers' => $customers,
            'carousels' => $carousels,
            'deviceTypes' => $deviceTypes,
            'devices' => $devices,
            'services' => $services,
            'serviceDetails' => $serviceDetails,
            'spareParts' => $spareParts,
            'partUsages' => $partUsages,
        ]);
    }
}
