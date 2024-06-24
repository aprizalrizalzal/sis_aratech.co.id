<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FootersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $footers = [
            [
                'image_path' => 'storage/images/footers/email.png',
                'type' => 'Contact',
                'platform' => 'Email',
                'url' => 'amitechpt@gmail.com',
                'username' => '',
                'value' => 'amitechpt@gmail.com',
            ],
            [
                'image_path' => 'storage/images/footers/call.png',
                'type' => 'Contact',
                'platform' => 'Phone',
                'url' => '+6282247912220',
                'username' => '',
                'value' => '+6282247912220',
            ],
            [
                'image_path' => 'storage/images/footers/facebook.png',
                'type' => 'Social Media',
                'platform' => 'Facebook',
                'url' => 'https://www.facebook.com/profile.php?id=100087543156002',
                'username' => '',
                'value' => 'Aslı Mandiri',
            ],
            [
                'image_path' => 'storage/images/footers/instagram.png',
                'type' => 'Social Media',
                'platform' => 'Instagram',
                'url' => 'https://www.instagram.com/asli_mandiri_com/',
                'username' => '',
                'value' => 'Aslı Mandiri(@asli_mandiri_com)',
            ],
            [
                'image_path' => 'storage/images/footers/whatsapp.png',
                'type' => 'Social Media',
                'platform' => 'WhatsApp',
                'url' => 'https://wa.me/6282247912220',
                'username' => '',
                'value' => 'AMITECH Official',
            ],
            [
                'image_path' => 'storage/images/footers/shopping-bag.png',
                'type' => 'Service',
                'platform' => '',
                'url' => 'https://www.aslimandiri.com',
                'username' => '',
                'value' => 'Asli Mandiri',
            ],
            [
                'image_path' => 'storage/images/footers/laptop.png',
                'type' => 'Service',
                'platform' => '',
                'url' => '#',
                'username' => '',
                'value' => 'Service Laptop/PC',
            ],
            [
                'image_path' => 'storage/images/footers/printer.png',
                'type' => 'Service',
                'platform' => '',
                'url' => '#',
                'username' => '',
                'value' => 'Service Printer',
            ],
            [
                'image_path' => 'storage/images/footers/playstore.png',
                'type' => 'App Download',
                'platform' => 'Google',
                'url' => 'https://play.google.com/store/',
                'username' => '',
                'value' => 'PlayStore',
            ],
            [
                'image_path' => 'storage/images/footers/appstore.png',
                'type' => 'App Download',
                'platform' => 'Apple',
                'url' => 'https://www.apple.com/id/app-store/',
                'username' => '',
                'value' => 'AppStore',
            ]
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
