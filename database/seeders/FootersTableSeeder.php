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
                'type_footer_id' => 1,
                'platform_footer_id' => 1,
                'image_path' => 'storage/images/footers/email.png',
                'url' => 'amitechpt@gmail.com',
                'username' => '-',
                'value' => 'amitechpt@gmail.com',
            ],
            [
                'type_footer_id' => 1,
                'platform_footer_id' => 2,
                'image_path' => 'storage/images/footers/call.png',
                'url' => '+6282247912220',
                'username' => '-',
                'value' => '+6282247912220',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 4,
                'image_path' => 'storage/images/footers/facebook.png',
                'url' => 'https://www.facebook.com/profile.php?id=100087543156002',
                'username' => '-',
                'value' => 'Aslı Mandiri',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 5,
                'image_path' => 'storage/images/footers/instagram.png',
                'url' => 'https://www.instagram.com/asli_mandiri_com/',
                'username' => '-',
                'value' => 'Aslı Mandiri(@asli_mandiri_com)',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 3,
                'image_path' => 'storage/images/footers/whatsapp.png',
                'url' => 'https://wa.me/6282247912220',
                'username' => '-',
                'value' => 'AMITECH Official',
            ],
            [
                'type_footer_id' => 4,
                'platform_footer_id' => 6,
                'image_path' => 'storage/images/footers/playstore.png',
                'url' => 'https://play.google.com/store/',
                'username' => '-',
                'value' => 'PlayStore',
            ],
            [
                'type_footer_id' => 4,
                'platform_footer_id' => 7,
                'image_path' => 'storage/images/footers/appstore.png',
                'url' => 'https://www.apple.com/id/app-store/',
                'username' => '-',
                'value' => 'AppStore',
            ],
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
