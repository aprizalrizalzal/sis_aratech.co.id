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
        SparePart::create([
            'name' => 'Maxtor CTG8 thermal paste 2g',
            'image_path' => 'null',
            'price' => 43000
        ]);
        SparePart::create([
            'name' => 'SSD 2.5 Inch VenomRX 128Gb',
            'image_path' => 'null',
            'price' => 200000
        ]);
    }
}