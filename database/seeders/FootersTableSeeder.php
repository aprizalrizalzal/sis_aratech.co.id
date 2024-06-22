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
        Footer::create([
            'image_path' => 'storage/images/footers/email.png',
            'type' => 'Contact',
            'platform' => 'Email',
            'url' => 'amitechpt@gmail.com',
            'username' => '',
            'value' => 'amitechpt@gmail.com',
        ]);
        Footer::create([
            'image_path' => 'storage/images/footers/phone.png',
            'type' => 'Contact',
            'platform' => 'Phone',
            'url' => '+6282247912220',
            'username' => '',
            'value' => '+6282247912220',
        ]);

        Footer::create([
            'image_path' => 'storage/images/footers/facebook.png',
            'type' => 'Social Media',
            'platform' => 'Facebook',
            'url' => 'https://www.facebook.com/profile.php?id=100087543156002',
            'username' => '',
            'value' => 'Aslı Mandiri',
        ]);
        Footer::create([
            'image_path' => 'storage/images/footers/instagram.png',
            'type' => 'Social Media',
            'platform' => 'Instagram',
            'url' => 'https://www.instagram.com/asli_mandiri_com/',
            'username' => '',
            'value' => 'Aslı Mandiri(@asli_mandiri_com)',
        ]);
        Footer::create([
            'image_path' => 'storage/images/footers/whatsapp.png',
            'type' => 'Social Media',
            'platform' => 'WhatsApp',
            'url' => 'https://wa.me/6282247912220',
            'username' => '',
            'value' => 'AMITECH Official',
        ]);

        Footer::create([
            'image_path' => 'storage/images/footers/playstore.png',
            'type' => 'App Download',
            'platform' => 'Google',
            'url' => 'https://play.google.com/store/',
            'username' => '',
            'value' => 'PlayStore',
        ]);
        Footer::create([
            'image_path' => 'storage/images/footers/appstore.png',
            'type' => 'App Download',
            'platform' => 'Apple',
            'url' => 'https://www.apple.com/id/app-store/',
            'username' => '',
            'value' => 'AppStore',
        ]);
    }
}
