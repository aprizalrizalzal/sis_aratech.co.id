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
                'name' => 'Maxtor CTG8 thermal paste 2g',
                'image_path' => 'storage/images/spareParts/maxtor-ctg8-prosesor-thermal.jpg',
                'category_spare_part_id' => 14,
                'pieces' => 3,
                'price' => 43000,
                'description' => '-',

            ],
            [
                'name' => 'SSD 2.5 Inch VenomRX 128GB',
                'image_path' => 'storage/images/spareParts/ssd-venomrx-128gb.jpg',
                'category_spare_part_id' => 6,
                'pieces' => 3,
                'price' => 200000,
                'description' => '-',
            ]
        ];

        foreach ($spareParts as $sparePart) {
            SparePart::create($sparePart);
        }
    }
}
