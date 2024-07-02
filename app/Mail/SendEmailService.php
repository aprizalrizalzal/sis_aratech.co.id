<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailService extends Mailable
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
            subject: 'SIService-AMITech',
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
     * Build the email content.
     *
     * @return string
     */
    protected function buildEmailContent()
    {
        $service = $this->data['service'];
        $host_url = $this->data['host_url'];

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
                    font-size: 12px;
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
                        <tr class='border bg-green-50 text-green-900 font-bold'>
                            <td>Service Code</td>
                            <td>{$service->service_code}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Name</td>
                            <td>{$service->customer->user->name}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Email / Phone</td>
                            <td>{$service->customer->user->email} / {$service->customer->phone}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Address</td>
                            <td>{$service->customer->address}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Device Type / Model</td>
                            <td>{$service->device->deviceType->type_name} / {$service->device->model}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Serial Number / Warranty Status</td>
                            <td>{$service->device->serial_number} / {$service->status_warranty}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Date Received / Estimated Completion</td>
                            <td>{$service->date_received} / {$service->estimated_completion}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Problem Description</td>
                            <td>{$service->problem_description}</td>
                        </tr>
                        <tr class='border'>
                            <td class='text-green-900'>Items Brought</td>
                            <td>{$service->items_brought}</td>
                        </tr>
                        <tr class='border bg-green-50 text-green-900 font-bold'>
                            <td>Status</td>
                            <td>{$service->status}</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class='border'>
                <ul class='list'>
                        <li class='list-item font-bold'>Notes!</li>
                        <li class='list-item'>Pelayanan service Senin-Sabtu, pukul 08.00-17.00 WITA.</li>
                        <li class='list-item'>Barang yang tidak diambil dalam 7 hari tidak lagi menjadi tanggung jawab kami.</li>
                        <li class='list-item'>Harap menunjukkan nota service ini saat pengambilan barang.</li>
                    </ul>
                </div>
                <p>
                    Silahkan kunjungi situs web kami di <a target='_blank' rel='noopener noreferrer' class='text-green-900 font-bold'
                        href='{$host_url}'>{$host_url}</a> dan masuk menggunakan email
                    <span class='font-bold text-green-900'>{$service->customer->user->email}</span> dan kata sandi <span class='font-bold text-green-900'>password</span>
                        untuk melihat perkembangan perangkat yang sedang diperbaiki.
                </p>
                <hr>
                <p>Info status terbaru akan kami kirim lewat email ya. Terima kasih sudah pilih layanan kami. Salam hangat dari Admin SIService-AMITech!</p>
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
