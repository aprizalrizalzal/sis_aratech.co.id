<?php

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');

// WelcomeController
Route::post('/', [WelcomeController::class, 'show'])->name('show');

Route::middleware(['auth', 'verified'])->group(function () {

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');
    Route::post('/dashboard/customer', [DashboardController::class, 'store_customer'])->name('store.customer');
    Route::post('/dashboard/device/type', [DashboardController::class, 'store_device_type'])->name('store.device.type');
    Route::post('/dashboard/device', [DashboardController::class, 'store_device'])->name('store.device');
    Route::post('/dashboard/service', [DashboardController::class, 'store_service'])->name('store.service');
    Route::post('/dashboard/service/detail', [DashboardController::class, 'store_service_detail'])->name('store.service.detail');
    Route::post('/dashboard/spare/part', [DashboardController::class, 'store_spare_part'])->name('store.spare.part');
    Route::post('/dashboard/part/usage', [DashboardController::class, 'store_part_usage'])->name('store.part.usage');

    // UserController
    Route::get('/users', [UserController::class, 'show'])->name('show.users');
    Route::delete('/user', [UserController::class, 'destroy'])->name('destroy.user');

    // CustomerController
    Route::get('/customers', [CustomerController::class, 'show'])->name('show.customers');
    Route::delete('/customer', [CustomerController::class, 'destroy'])->name('destroy.customer');

    // DeviceTypeController
    Route::get('/device/types', [DeviceTypeController::class, 'show'])->name('show.device.types');
    Route::delete('/device/type', [DeviceTypeController::class, 'destroy'])->name('destroy.device.type');

    // DeviceController
    Route::get('/devices', [DeviceController::class, 'show'])->name('show.devices');
    Route::delete('/device', [DeviceController::class, 'destroy'])->name('destroy.device');

    // ServiceController
    Route::get('/services', [ServiceController::class, 'show'])->name('show.services');
    Route::delete('/service', [ServiceController::class, 'destroy'])->name('destroy.service');

    // ServiceDetailController
    Route::get('/service/details', [ServiceDetailController::class, 'show'])->name('show.service.details');
    Route::delete('/service/detail', [ServiceDetailController::class, 'destroy'])->name('destroy.service.detail');

    // SparePartController
    Route::get('/spare/parts', [SparePartController::class, 'show'])->name('show.spare.parts');
    Route::delete('/spare/part', [SparePartController::class, 'destroy'])->name('destroy.spare.part');

    // PartUsageController
    Route::get('/part/usages', [PartUsageController::class, 'show'])->name('show.part.usages');
    Route::delete('/part/usage', [PartUsageController::class, 'destroy'])->name('destroy.part.usage');
});

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
