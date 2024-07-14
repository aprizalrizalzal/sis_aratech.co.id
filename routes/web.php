<?php

use App\Http\Controllers\CarouselController;
use App\Http\Controllers\CategorySparePartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\PartUsageController;
use App\Http\Controllers\PlatformFooterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\StatusServiceController;
use App\Http\Controllers\StatusWarrantyServiceController;
use App\Http\Controllers\TypeFooterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// WelcomeController
Route::get('/', [WelcomeController::class, 'show'])->name('show.welcome');
Route::post('/', [WelcomeController::class, 'store'])->name('store.welcome');

// SparePartController
Route::get('/spare-part-detail', [SparePartController::class, 'show_detail'])->name('show.spare.part.detail');

Route::middleware(['auth', 'verified'])->group(function () {

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('show.dashboard');

    Route::middleware(['role:super-admin'])->group(function () {

        // UserController
        Route::get('/users', [UserController::class, 'show'])->name('show.users');
        Route::delete('/user', [UserController::class, 'destroy'])->name('destroy.user');

        // RoleController
        Route::post('/assign-roles', [RoleController::class, 'assignRoles'])->name('assign.roles');
        Route::delete('/roles/remove', [RoleController::class, 'removeRoles'])->name('remove.roles');

        // DeviceTypeController
        Route::get('/device-types', [DeviceTypeController::class, 'show'])->name('show.device.types');
        Route::post('/device-type', [DeviceTypeController::class, 'store'])->name('store.device.type');
        Route::put('/device-type', [DeviceTypeController::class, 'update'])->name('update.device.type');
        Route::delete('/device-type', [DeviceTypeController::class, 'destroy'])->name('destroy.device.type');

        // CategorySparePartController
        Route::get('/category/spare-parts', [CategorySparePartController::class, 'show'])->name('show.category.spare.parts');
        Route::post('/category/spare-part', [CategorySparePartController::class, 'store'])->name('store.category.spare.part');
        Route::put('/category/spare-part', [CategorySparePartController::class, 'update'])->name('update.category.spare.part');
        Route::delete('/category/spare-part', [CategorySparePartController::class, 'destroy'])->name('destroy.category.spare.part');

        // SparePartController
        Route::get('/spare-parts', [SparePartController::class, 'show'])->name('show.spare.parts');
        Route::post('/spare-part', [SparePartController::class, 'store'])->name('store.spare.part');
        Route::post('/spare-part-image', [SparePartController::class, 'update_image'])->name('update.spare.part.image');
        Route::put('/spare-part', [SparePartController::class, 'update'])->name('update.spare.part');
        Route::delete('/spare-part', [SparePartController::class, 'destroy'])->name('destroy.spare.part');

        // SettingController
        Route::get('/setting', [SettingController::class, 'show'])->name('setting.edit');

        // HeaderController
        Route::post('/setting-header', [HeaderController::class, 'store'])->name('store.header');
        Route::post('/setting-header-image', [HeaderController::class, 'update_image'])->name('update.header.image');
        Route::put('/setting-header', [HeaderController::class, 'update'])->name('update.header');
        Route::delete('/setting-header', [HeaderController::class, 'destroy'])->name('destroy.header');

        // CarouselController
        Route::post('/setting-carousel', [CarouselController::class, 'store'])->name('store.carousel');
        Route::post('/setting-carousel-image', [CarouselController::class, 'update_image'])->name('update.carousel.image');
        Route::put('/setting-carousel', [CarouselController::class, 'update'])->name('update.carousel');
        Route::delete('/setting-carousel', [CarouselController::class, 'destroy'])->name('destroy.carousel');

        // TypeFooterController
        Route::get('/type/setting-footers', [TypeFooterController::class, 'show'])->name('show.type.footer');
        Route::post('/type/setting-footer', [TypeFooterController::class, 'store'])->name('store.type.footer');
        Route::put('/type/setting-footer', [TypeFooterController::class, 'update'])->name('update.type.footer');
        Route::delete('/type/setting-footer', [TypeFooterController::class, 'destroy'])->name('destroy.type.footer');

        // PlatformFooterController
        Route::get('/platform/setting-footers', [PlatformFooterController::class, 'show'])->name('show.platform.footer');
        Route::post('/platform/setting-footer', [PlatformFooterController::class, 'store'])->name('store.platform.footer');
        Route::put('/platform/setting-footer', [PlatformFooterController::class, 'update'])->name('update.platform.footer');
        Route::delete('/platform/setting-footer', [PlatformFooterController::class, 'destroy'])->name('destroy.platform.footer');

        // FooterController
        Route::post('/setting-footer', [FooterController::class, 'store'])->name('store.footer');
        Route::post('/setting-footer-image', [FooterController::class, 'update_image'])->name('update.footer.image');
        Route::put('/setting-footer', [FooterController::class, 'update'])->name('update.footer');
        Route::delete('/setting-footer', [FooterController::class, 'destroy'])->name('destroy.footer');
    });

    Route::middleware(['role:admin'])->group(function () {

        // CustomerController
        Route::get('/customers', [CustomerController::class, 'show'])->name('show.customers');
        Route::post('/customer', [CustomerController::class, 'store'])->name('store.customer');
        Route::put('/customer', [CustomerController::class, 'update'])->name('update.customer');
        Route::delete('/customer', [CustomerController::class, 'destroy'])->name('destroy.customer');

        // DeviceController
        Route::get('/devices', [DeviceController::class, 'show'])->name('show.devices');
        Route::post('/device', [DeviceController::class, 'store'])->name('store.device');
        Route::put('/device', [DeviceController::class, 'update'])->name('update.device');
        Route::delete('/device', [DeviceController::class, 'destroy'])->name('destroy.device');

        // StatusWarrantyServiceController
        Route::get('/status/warranty/services', [StatusWarrantyServiceController::class, 'show'])->name('show.status.warranty.services');
        Route::post('/status/warranty/service', [StatusWarrantyServiceController::class, 'store'])->name('store.status.warranty.service');
        Route::put('/status/warranty/service', [StatusWarrantyServiceController::class, 'update'])->name('update.status.warranty.service');
        Route::delete('/status/warranty/service', [StatusWarrantyServiceController::class, 'destroy'])->name('destroy.status.warranty.service');

        // StatusServiceController
        Route::get('/status/services', [StatusServiceController::class, 'show'])->name('show.status.services');
        Route::post('/status/service', [StatusServiceController::class, 'store'])->name('store.status.service');
        Route::put('/status/service', [StatusServiceController::class, 'update'])->name('update.status.service');
        Route::delete('/status/service', [StatusServiceController::class, 'destroy'])->name('destroy.status.service');

        // ServiceController
        Route::get('/services', [ServiceController::class, 'show'])->name('show.services');
        Route::post('/service', [ServiceController::class, 'store'])->name('store.service');
        Route::put('/service', [ServiceController::class, 'update'])->name('update.service');
        Route::delete('/service', [ServiceController::class, 'destroy'])->name('destroy.service');

        Route::get('service/print/{service_code}', [ServiceController::class, 'print'])->name('service.print');
    });

    Route::middleware(['role:user'])->group(function () {

        // ServiceDetailController
        Route::get('/service-details', [ServiceDetailController::class, 'show'])->name('show.service.details');
        Route::post('/service-detail', [ServiceDetailController::class, 'store'])->name('store.service.detail');
        Route::put('/service-detail', [ServiceDetailController::class, 'update'])->name('update.service.detail');
        Route::delete('/service-detail', [ServiceDetailController::class, 'destroy'])->name('destroy.service.detail');

        Route::get('service/detail/print/{service_detail_code}', [ServiceDetailController::class, 'print'])->name('service.detail.print');

        // PartUsageController
        Route::get('/part-usages', [PartUsageController::class, 'show'])->name('show.part.usages');
        Route::post('/part-usage', [PartUsageController::class, 'store'])->name('store.part.usage');
        Route::put('/part-usage', [PartUsageController::class, 'update'])->name('update.part.usage');
        Route::delete('/part-usage', [PartUsageController::class, 'destroy'])->name('destroy.part.usage');
    });
});

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
