<?php

namespace Database\Seeders;

use App\Models\SparePart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SparePartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $spareParts = [
            [
                'name' => 'Nama Barang',
                'image_path' => 'storage/images/spareParts/1-product-4x4.jpg',
                'category_spare_part_id' => 14,
                'pieces' => 54,
                'price' => 54000,
                'description' => 'Deskripsi dari product',

            ]
        ];

        foreach ($spareParts as $sparePart) {
            SparePart::create($sparePart);
        }
    }
}
