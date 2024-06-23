<?php

namespace Database\Seeders;

use App\Models\Carousel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarouselsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carousels = [
            [
                'image_path' => 'storage/images/carousels/1.png',
                'alt' => 'Satu',
            ],
            [
                'image_path' => 'storage/images/Carousels/2.png',
                'alt' => 'Dua',
            ],
            [
                'image_path' => 'storage/images/Carousels/3.png',
                'alt' => 'Tiga'
            ],
            [
                'image_path' => 'storage/images/Carousels/4.png',
                'alt' => 'Empat'
            ]
        ];

        foreach ($carousels as $carousel) {
            Carousel::create($carousel);
        }
    }
}
