<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\PartUsageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// WelcomeController
Route::get('/', [WelcomeController::class, 'show_carousel'])->name('welcome.show.carousel');
Route::post('/', [WelcomeController::class, 'store_service_code'])->name('welcome.store.service.code');

Route::middleware(['auth', 'verified'])->group(function () {

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::middleware(['role:super admin'])->group(function () {
        // UserController
        Route::get('/users', [UserController::class, 'show'])->name('show.users');
        Route::delete('/user', [UserController::class, 'destroy'])->name('destroy.user');
        Route::post('/dashboard/device/type', [DashboardController::class, 'store_device_type'])->name('store.device.type');
        // DeviceTypeController
        Route::get('/device/types', [DeviceTypeController::class, 'show'])->name('show.device.types');
        Route::put('/device/type', [DeviceTypeController::class, 'update'])->name('update.device.type');
        Route::delete('/device/type', [DeviceTypeController::class, 'destroy'])->name('destroy.device.type');

        Route::post('/dashboard/spare/part', [DashboardController::class, 'store_spare_part'])->name('store.spare.part');
        // SparePartController
        Route::get('/spare/parts', [SparePartController::class, 'show'])->name('show.spare.parts');
        Route::put('/spare/part', [SparePartController::class, 'update'])->name('update.spare.part');
        Route::delete('/spare/part', [SparePartController::class, 'destroy'])->name('destroy.spare.part');

        Route::post('/dashboard/carousel', [DashboardController::class, 'store_carousel'])->name('store.carousel');
        // CarouselController
        Route::get('/carousels', [CarouselController::class, 'show'])->name('show.carousels');
        Route::delete('/carousel', [CarouselController::class, 'destroy'])->name('destroy.carousel');
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::post('/dashboard/customer', [DashboardController::class, 'store_customer'])->name('store.customer');
        // CustomerController
        Route::get('/customers', [CustomerController::class, 'show'])->name('show.customers');
        Route::put('/customer', [CustomerController::class, 'update'])->name('update.customer');
        Route::delete('/customer', [CustomerController::class, 'destroy'])->name('destroy.customer');

        Route::post('/dashboard/device', [DashboardController::class, 'store_device'])->name('store.device');
        // DeviceController
        Route::get('/devices', [DeviceController::class, 'show'])->name('show.devices');
        Route::put('/device', [DeviceController::class, 'update'])->name('update.device');
        Route::delete('/device', [DeviceController::class, 'destroy'])->name('destroy.device');

        Route::post('/dashboard/service', [DashboardController::class, 'store_service'])->name('store.service');
        // ServiceController
        Route::get('/services', [ServiceController::class, 'show'])->name('show.services');
        Route::put('/service', [ServiceController::class, 'update'])->name('update.service');
        Route::delete('/service', [ServiceController::class, 'destroy'])->name('destroy.service');

        Route::get('service/print/{service_code}', [ServiceController::class, 'print'])->name('service.print');
    });

    Route::middleware(['role:technician'])->group(function () {
        Route::post('/dashboard/service/detail', [DashboardController::class, 'store_service_detail'])->name('store.service.detail');
        // ServiceDetailController
        Route::get('/service/details', [ServiceDetailController::class, 'show'])->name('show.service.details');
        Route::put('/service/detail', [ServiceDetailController::class, 'update'])->name('update.service.detail');
        Route::delete('/service/detail', [ServiceDetailController::class, 'destroy'])->name('destroy.service.detail');

        Route::post('/dashboard/part/usage', [DashboardController::class, 'store_part_usage'])->name('store.part.usage');
        // PartUsageController
        Route::get('/part/usages', [PartUsageController::class, 'show'])->name('show.part.usages');
        Route::put('/part/usage', [PartUsageController::class, 'update'])->name('update.part.usage');
        Route::delete('/part/usage', [PartUsageController::class, 'destroy'])->name('destroy.part.usage');
    });
});

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/unauthorized', function () {
    return Inertia::render('Unauthorized');
})->name('unauthorized');

require __DIR__ . '/auth.php';
