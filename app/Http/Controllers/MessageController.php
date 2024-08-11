<?php

namespace App\Http\Controllers;

use App\Models\Header;
use App\Models\Note;
use App\Models\PartUsage;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Service\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    protected $fonnte;

    public function __construct(FonnteService $fonnte)
    {
        $this->fonnte = $fonnte;
    }

    public function send_service($service_code)
    {
        $service = Service::where('service_code', $service_code)
            ->with('customer', 'customer.user', 'device', 'device.deviceType', 'statusWarrantyService', 'statusService')
            ->firstOrFail();

        $headers = Header::all()->pluck('company');
        $headerText = implode("\n", $headers->toArray());

        $notes = Note::all()->pluck('description');
        $noteText = implode("\n", $notes->toArray());

        $to = $service->customer->phone;
        $message = "*SIService – " . $headerText . "*\n\n"
            . "*Service Code: " . $service->service_code . "*\n"
            . "Nama Pelanggan: " . $service->customer->user->name . "\n"
            . "Email Pelanggan / Nomor Telepon: " . $service->customer->user->email . " / " . $service->customer->phone . "\n"
            . "Alamat: " . $service->customer->address . "\n"
            . "Jenis Perangkat / Model: " . $service->device->deviceType->type_name . " / " . $service->device->model . "\n"
            . "Nomor Seri / Status Garansi: " . $service->device->serial_number . " / " . $service->statusWarrantyService->status . "\n"
            . "Tanggal Diterima / Estimasi Selesai: " . $service->date_received . " / " . $service->estimated_completion . "\n"
            . "Deskripsi Masalah: " . $service->problem_description . "\n"
            . "Barang yang Dibawa: " . $service->items_brought . "\n"
            . "*Status: " . $service->statusService->status . "*\n\n"
            . "Catatan:\n"
            . "" . $noteText . "\n\n"
            . "*Silakan kunjungi situs web kami di _" . url('/') . "_ masuk menggunakan email _" . $service->customer->user->email . "_ dan kata sandi _@aratech_ untuk melihat perkembangan perangkat yang sedang diperbaiki.*\n\n"
            . "Info status terbaru akan kami kirim lewat WhatsApp dan Email ya. Terima kasih sudah pilih layanan kami. Salam hangat dari Admin!";

        $response = $this->fonnte->sendMessage($to, $message);

        return Redirect::back()->with($response);
    }

    public function send_service_detail($service_detail_code)
    {
        $serviceDetail = ServiceDetail::where('service_detail_code', $service_detail_code)
            ->with('user', 'service', 'service.customer.user', 'service.device', 'service.device.deviceType', 'service.statusWarrantyService', 'service.statusService')
            ->firstOrFail();

        $headers = Header::all()->pluck('company');
        $headerText = implode("\n", $headers->toArray());

        $partUsages = PartUsage::with('sparePart')->where('service_detail_id', $serviceDetail->id)->get();

        $total = $serviceDetail->cost;
        foreach ($partUsages as $partUsage) {
            $total += $partUsage->sparePart->price;
        }

        $formattedTotal = 'Rp ' . number_format($total, 0, ',', '.');
        $formattedCost = 'Rp ' . number_format($serviceDetail->cost, 0, ',', '.');

        $message = "*SIService – " . $headerText . "*\n\n"
            . "*Service Detail Code: " . $serviceDetail->service_detail_code . "*\n"
            . "Email / Nomor Telepon Teknisi: " . $serviceDetail->user->email . " / " . $serviceDetail->user->customer->phone . "\n"
            . "*Service Code: " . $serviceDetail->service->service_code . "*\n"
            . "Nama Pelanggan: " . $serviceDetail->service->customer->user->name . "\n"
            . "Email Pelanggan / Nomor Telepon: " . $serviceDetail->service->customer->user->email . " / " . $serviceDetail->service->customer->phone . "\n"
            . "Alamat: " . $serviceDetail->service->customer->address . "\n"
            . "Jenis Perangkat / Model: " . $serviceDetail->service->device->deviceType->type_name . " / " . $serviceDetail->service->device->model . "\n"
            . "Nomor Seri / Status Garansi: " . $serviceDetail->service->device->serial_number . " / " . $serviceDetail->service->statusWarrantyService->status . "\n"
            . "Tanggal Diterima / Estimasi Selesai: " . $serviceDetail->service->date_received . " / " . $serviceDetail->service->estimated_completion . "\n"
            . "Deskripsi Masalah: " . $serviceDetail->service->problem_description . "\n"
            . "Barang yang Dibawa: " . $serviceDetail->service->items_brought . "\n"
            . "*Status: " . $serviceDetail->service->statusService->status . "*\n\n"
            . "Deskripsi Perbaikan: " . $serviceDetail->repair_description . "\n\n"
            . "*Spare Part dan Harga*\n";

        foreach ($partUsages as $index => $partUsage) {
            $message .= ($index + 1) . ". " . $partUsage->sparePart->name . " - " . $this->formatCurrency($partUsage->sparePart->price) . "\n";
        }

        $message .= "\n*Cost: " . $formattedCost . "*\n"
            . "*Total: " . $formattedTotal . "*\n\n"
            . "Catatan:\n" . $serviceDetail->notes . "\n\n"
            . "*_Cost_ adalah biaya jasa service. _Total_ mencakup biaya jasa dan biaya tambahan untuk _Spare Part_ yang diganti jika ada.*\n\n"
            . "Info status terbaru akan kami kirim lewat WhatsApp dan Email ya. Terima kasih sudah pilih layanan kami. Salam hangat dari Technician!";

        $response = $this->fonnte->sendMessage($serviceDetail->service->customer->phone, $message);

        return Redirect::back()->with($response);
    }

    private function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
