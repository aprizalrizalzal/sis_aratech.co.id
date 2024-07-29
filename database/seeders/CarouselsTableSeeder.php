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
                'image_path' => 'storage/images/carousels/1-baner-24x....jpg',
                'alt' => 'Satu',
            ],
            [
                'image_path' => 'storage/images/Carousels/2-baner-24x....jpg',
                'alt' => 'Dua',
            ],
            [
                'image_path' => 'storage/images/Carousels/3-baner-24x....jpg',
                'alt' => 'Tiga'
            ],
            [
                'image_path' => 'storage/images/Carousels/4-baner-24x....jpg',
                'alt' => 'Empat'
            ]
        ];

        foreach ($carousels as $carousel) {
            Carousel::create($carousel);
        }
    }
}
