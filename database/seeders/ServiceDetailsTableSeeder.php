<?php

namespace Database\Seeders;

use App\Models\ServiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(8)),
            'user_id' => 2,
            'service_id' => 1,
            'problem_description' => 'OverHeat',
            'repair_description' => 'Replaced display cable',
            'cost' => 50000,
        ]);

        ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(8)),
            'user_id' => 2,
            'service_id' => 2,
            'problem_description' => 'Paper jam',
            'repair_description' => 'Cleared paper jam and cleaned rollers',
            'cost' => 100000,
        ]);

        ServiceDetail::create([
            'service_detail_code' => Str::upper(Str::random(8)),
            'user_id' => 2,
            'service_id' => 3,
            'problem_description' => 'Screen flickering',
            'repair_description' => 'Replaced display cable',
            'cost' => 75000,
        ]);
    }
}