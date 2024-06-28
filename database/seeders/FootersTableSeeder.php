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
                'type' => 'Contact',
                'platform' => 'Email',
                'image_path' => 'storage/images/footers/email.png',
                'url' => 'amitechpt@gmail.com',
                'username' => '-',
                'value' => 'amitechpt@gmail.com',
            ],
            [
                'type' => 'Contact',
                'platform' => 'Phone',
                'image_path' => 'storage/images/footers/call.png',
                'url' => '+6282247912220',
                'username' => '-',
                'value' => '+6282247912220',
            ],
            [
                'type' => 'Social Media',
                'platform' => 'Facebook',
                'image_path' => 'storage/images/footers/facebook.png',
                'url' => 'https://www.facebook.com/profile.php?id=100087543156002',
                'username' => '-',
                'value' => 'Aslı Mandiri',
            ],
            [
                'type' => 'Social Media',
                'platform' => 'Instagram',
                'image_path' => 'storage/images/footers/instagram.png',
                'url' => 'https://www.instagram.com/asli_mandiri_com/',
                'username' => '-',
                'value' => 'Aslı Mandiri(@asli_mandiri_com)',
            ],
            [
                'type' => 'Social Media',
                'platform' => 'WhatsApp',
                'image_path' => 'storage/images/footers/whatsapp.png',
                'url' => 'https://wa.me/6282247912220',
                'username' => '-',
                'value' => 'AMITECH Official',
            ],
            [
                'type' => 'Service',
                'platform' => '',
                'image_path' => 'storage/images/footers/shopping-bag.png',
                'url' => 'https://www.aslimandiri.com',
                'username' => '-',
                'value' => 'Asli Mandiri',
            ],
            [
                'type' => 'Service',
                'platform' => '',
                'image_path' => 'storage/images/footers/laptop.png',
                'url' => '#',
                'username' => '-',
                'value' => 'Service Laptop/PC',
            ],
            [
                'type' => 'Service',
                'platform' => '',
                'image_path' => 'storage/images/footers/printer.png',
                'url' => '#',
                'username' => '-',
                'value' => 'Service Printer',
            ],
            [
                'type' => 'App Download',
                'platform' => 'Google',
                'image_path' => 'storage/images/footers/playstore.png',
                'url' => 'https://play.google.com/store/',
                'username' => '-',
                'value' => 'PlayStore',
            ],
            [
                'type' => 'App Download',
                'platform' => 'Apple',
                'image_path' => 'storage/images/footers/appstore.png',
                'url' => 'https://www.apple.com/id/app-store/',
                'username' => '-',
                'value' => 'AppStore',
            ]
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
