<?php

namespace Database\Seeders;

use App\Models\CategorySparePart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySparePartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorySpareParts = [
            [
                'name' => 'Thermal Paste',
                'description' => '-'

            ],
            [
                'name' => 'SSD',
                'description' => '-'
            ]
        ];

        foreach ($categorySpareParts as $categorySparePart) {
            CategorySparePart::create($categorySparePart);
        }
    }
}
