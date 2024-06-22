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
        Carousel::create([
            'image_path' => 'storage/images/carousels/1',
            'alt' => 'Satu',
        ]);
        Carousel::create([
            'image_path' => 'storage/images/Carousels/2',
            'alt' => 'Dua',
        ]);
        Carousel::create([
            'image_path' => 'storage/images/Carousels/3',
            'alt' => 'Tiga',
        ]);
        Carousel::create([
            'image_path' => 'storage/images/Carousels/4',
            'alt' => 'Empat',
        ]);
    }
}
