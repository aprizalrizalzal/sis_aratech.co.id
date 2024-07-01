<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
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
            subject: 'SIService',
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('AsliMandiriComputer')
            ->html($this->buildEmailContent());
    }

    /**
     * Build the email content.
     *
     * @return string
     */
    protected function buildEmailContent()
    {
        $service = $this->data['service'];

        $content = "<!DOCTYPE html>
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
                    max-width: 600px;
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
                    margin-bottom: 20px;
                }
                .list {
                    font-size: 14px;
                    line-height: 1.5;
                    color: #374151;
                    margin: 0;
                    padding: 0;
                    list-style: none;
                }
                .list-item {
                    margin-bottom: 10px;
                }
                .footer-text {
                    font-size: 14px;
                    margin-top: 20px;
                    color: #6b7280;
                }
                .border {
                    border: 0.5px solid #A9A9A9A9;
                    border-radius: 8px;
                    padding: 10px;
                    margin: 10px 0;
                }
                .font-bold {
                    font-weight: bold;
                }
                .text-green-800 {
                    color: #065f46;
                }
                .bg-green-50 {
                    background-color: #f0fdf4;
                }
                .text-green-900 {
                    color: #064e3b;
                }
                .text-lg {
                    font-size: 1.125rem;
                    line-height: 1.75rem;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1 class='title'>{$this->data['title']}</h1>
                <p class='body-text'>{$this->data['body']}</p>
                <ul class='list'>
                    <li class='list-item'><strong>Service Code:</strong> {$service->service_code}</li>
                    <li class='list-item'><strong>Name:</strong> {$service->customer->user->name}</li>
                    <li class='list-item'><strong>Email / Phone:</strong> {$service->customer->user->email} / {$service->customer->phone}</li>
                    <li class='list-item'><strong>Address:</strong> {$service->customer->address}</li>
                    <li class='list-item'><strong>Device Type / Model:</strong> {$service->device->deviceType->type_name} / {$service->device->model}</li>
                    <li class='list-item'><strong>Serial Number / Warranty Status:</strong> {$service->device->serial_number} / {$service->status_warranty}</li>
                    <li class='list-item'><strong>Date Received / Estimated Completion:</strong> {$service->date_received} / {$service->estimated_completion}</li>
                    <li class='list-item'><strong>Problem Description:</strong> {$service->problem_description}</li>
                    <li class='list-item'><strong>Items Brought:</strong> {$service->items_brought}</li>
                    <li class='list-item'><strong>Status:</strong> {$service->status}</li>
                </ul>
                <div class='border'>
                    <p class='font-bold'>Notes!</p>
                    <ul class='list'>
                        <li class='list-item'>Pelayanan service Senin-Sabtu, pukul 08.00-17.00 WITA.</li>
                        <li class='list-item'>Barang yang tidak diambil dalam 7 hari tidak lagi menjadi tanggung jawab kami.</li>
                        <li class='list-item'>Harap menunjukkan nota service ini saat pengambilan barang.</li>
                    </ul>
                </div>
                <p class='footer-text'>Terima kasih telah memilih layanan kami.</p>
            </div>
        </body>
        </html>";

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
