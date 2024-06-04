<?php

namespace Database\Seeders;

use App\Models\PartUsage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartUsagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PartUsage::create([
            'service_detail_id' => 1,
            'spare_part_id' => 1,
            'quantity' => 1
        ]);

        PartUsage::create([
            'service_detail_id' => 2,
            'spare_part_id' => 2,
            'quantity' => 1
        ]);

        PartUsage::create([
            'service_detail_id' => 3,
            'spare_part_id' => 1,
            'quantity' => 1
        ]);
    }
}
