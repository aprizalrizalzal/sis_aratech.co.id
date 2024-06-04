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
            'name' => 'Display Cable',
            'price' => 50.00
        ]);
        SparePart::create([
            'name' => 'Printer Roller',
            'price' => 20.00
        ]);
    }
}
