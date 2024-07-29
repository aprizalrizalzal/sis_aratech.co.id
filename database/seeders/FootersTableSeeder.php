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
                'image_path' => 'storage/images/footers/1-icon-1x1.jpg',
                'url' => 'perusahaan@email.com',
                'username' => '-',
                'value' => 'perusahaan@email.com',
            ],
            [
                'type_footer_id' => 1,
                'platform_footer_id' => 2,
                'image_path' => 'storage/images/footers/2-icon-1x1.jpg',
                'url' => '+62(Nomor Kantor)',
                'username' => '-',
                'value' => '+62(Nomor Kantor)',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 4,
                'image_path' => 'storage/images/footers/3-icon-1x1.jpg',
                'url' => 'https://www.facebook.com/...',
                'username' => '-',
                'value' => 'Akun Perusahaan',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 5,
                'image_path' => 'storage/images/footers/4-icon-1x1.jpg',
                'url' => 'https://www.instagram.com/...',
                'username' => '-',
                'value' => 'Akun Perusahaan',
            ],
            [
                'type_footer_id' => 2,
                'platform_footer_id' => 3,
                'image_path' => 'storage/images/footers/5-icon-1x1.jpg',
                'url' => 'https://wa.me/62(Nomor Admin)',
                'username' => '-',
                'value' => 'Akun Perusahaan',
            ],
            [
                'type_footer_id' => 4,
                'platform_footer_id' => 6,
                'image_path' => 'storage/images/footers/6-icon-1x1.jpg',
                'url' => 'https://play.google.com/store/...',
                'username' => '-',
                'value' => 'PlayStore',
            ],
            [
                'type_footer_id' => 4,
                'platform_footer_id' => 7,
                'image_path' => 'storage/images/footers/7-icon-1x1.jpg',
                'url' => 'https://www.apple.com/id/app-store/...',
                'username' => '-',
                'value' => 'AppStore',
            ],
        ];

        foreach ($footers as $footer) {
            Footer::create($footer);
        }
    }
}
