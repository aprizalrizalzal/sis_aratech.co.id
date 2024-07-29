<?php

namespace Database\Seeders;

use App\Models\ImageSparePart;
use App\Models\SparePart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSparePartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageSpareParts = [
            [
                'spare_part_id' => 1,
                'image_path' => 'storage/images/spareParts/images/1-product-4x4.jpg',
            ],
            [
                'spare_part_id' => 1,
                'image_path' => 'storage/images/spareParts/images/2-product-4x4.jpg',
            ],
            [
                'spare_part_id' => 1,
                'image_path' => 'storage/images/spareParts/images/3-product-4x4.jpg',
            ],
            [
                'spare_part_id' => 1,
                'image_path' => 'storage/images/spareParts/images/4-product-4x4.jpg',
            ]
        ];

        foreach ($imageSpareParts as $imageSparePart) {
            ImageSparePart::create($imageSparePart);
        }
    }
}
