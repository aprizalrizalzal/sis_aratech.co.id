<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailServiceDetail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'SIService-AMITech Detail',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->html($this->buildEmailContent());
    }

    /**
     * Calculate the total cost for the service detail.
     *
     * @param object $serviceDetail
     * @param array $partUsages
     * @return float
     */
    private function calculateServiceDetailTotal($serviceDetail, $partUsages): float
    {
        $total = $serviceDetail->cost;
        foreach ($partUsages as $partUsage) {
            $total += $partUsage->sparePart->price;
        }
        return $total;
    }

    /**
     * Format the currency value.
     *
     * @param float $amount
     * @return string
     */
    private function formatCurrency(float $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    /**
     * Build the email content.
     *
     * @return string
     */
    protected function buildEmailContent()
    {
        $serviceDetail = $this->data['serviceDetail'];
        $partUsages = $this->data['partUsages'];
        $serviceDetailTotal = $this->calculateServiceDetailTotal($serviceDetail, $partUsages);

        $content = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>{$this->data['title']}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9fafb;
                    color: #111827;
                    padding: 20px;
                }
                .container {
                    margin: auto;
                    background-color: #ffffff;
                    border-radius: 8px;
                    padding: 20px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .title {
                    font-size: 24px;
                    font-weight: 600;
                    color: #1f2937;
                    margin-bottom: 20px;
                }
                .body-text {
                    font-size: 16px;
                    margin-bottom: 10px;
                }
                table {
                    table-layout: auto;
                    width: 100%;
                    margin: 8px 0;
                }
                th, td {
                    width: auto;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
                tr:hover {
                    background-color: #f5f5f5;
                }
                .list {
                    font-size: 16px;
                    color: #374151;
                    margin: 0;
                    padding: 0;
                    list-style: none;
                }
                .list-item {
                    margin-top: 10px;
                    margin-bottom: 10px;
                }
                .border {
                    border: 0.5px solid #A9A9A9A9;
                    border-radius: 8px;
                    padding: 10px;
                }
                .font-bold {
                    font-weight: bold;
                }
                .bg-green-50 {
                    background-color: #f0fdf4;
                }
                .text-green-900 {
                    color: #0f4d0f;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1 class='title'>{$this->data['title']}</h1>
                <p class='body-text'>{$this->data['body']}</p>
                <hr>
                <table>
                    <tbody>
                        <tr class='font-bold bg-green-50'>
                            <td class='text-green-900'> Service Detail Code </td>
                            <td>{$serviceDetail->service_detail_code}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Email Technician </td>
                            <td>{$serviceDetail->user->email}</td>
                        </tr>
                        <tr class='font-bold bg-green-50'>
                            <td class='text-green-900'>Service Code </td>
                            <td>{$serviceDetail->service->service_code}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Name</td>
                            <td>{$serviceDetail->service->customer->user->name}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Email / Phone</td>
                            <td>{$serviceDetail->service->customer->user->email}<span> / </span>{$serviceDetail->service->customer->phone}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Address </td>
                            <td>{$serviceDetail->service->customer->address}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Device Type / Model</td>
                            <td>{$serviceDetail->service->device->deviceType->type_name}<span> / </span>{$serviceDetail->service->device->model}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Serial Number / Warranty Status </td>
                            <td>{$serviceDetail->service->device->serial_number}<span> / </span>{$serviceDetail->service->statusWarrantyService->status}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Date Received / Estimated Completion </td>
                            <td>{$serviceDetail->service->date_received}<span> / </span>{$serviceDetail->service->estimated_completion}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Problem Description </td>
                            <td>{$serviceDetail->service->problem_description}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'>Items Brought </td>
                            <td>{$serviceDetail->service->items_brought}</td>
                        </tr>
                        <tr class='font-bold bg-green-50'>
                            <td class='text-green-900'>Status </td>
                            <td>{$serviceDetail->service->statusService->status}</td>
                        </tr>
                        <tr>
                            <td class='text-green-900'> Repair Description </td>
                            <td>{$serviceDetail->repair_description}</td>
                        </tr>
                        <tr class='font-bold bg-green-50'>
                            <td class='text-green-900'> Spare Part</td>
                            <td class='text-green-900'> Price</td>
                        ";
        foreach ($partUsages as $index => $partUsage) {
            $content .= "
                        <tr>
                            <td class='text-green-900'> " . ($index + 1) . ". {$partUsage->sparePart->name}</td>
                            <td class='text-green-900'>" . $this->formatCurrency($partUsage->sparePart->price) . " </td>
                        </tr>
                                    ";
        }
        $content .= "
                        </tr>
                        <tr class='font-bold bg-green-50'>
                            <td class='text-green-900'> Cost </td>
                            <td> " . $this->formatCurrency($serviceDetail->cost) . " </td>
                        </tr>
                        <tr class='font-bold'>
                            <td class='text-green-900'> Total </td>
                            <td> " . $this->formatCurrency($serviceDetailTotal) . " </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class='border'>
                <ul class='list'>
                <li class='list-item font-bold text-green-900'>Notes!</li>
                <li class='list-item'>{$serviceDetail->notes}</li>
                </ul>
                </div>
                <p><span class='font-bold text-green-900'>Cost</span> adalah biaya jasa service. <span class='font-bold text-green-900'>Total</span> mencakup biaya jasa dan biaya tambahan untuk Spare Part yang diganti jika ada.</p>
                <hr>
                <p>Info status terbaru akan kami kirim lewat email ya. Terima kasih sudah pilih layanan kami. Salam hangat dari Technician SIService-AMITech!</p>
            </div>
        </body>
        </html>
        ";

        return $content;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
