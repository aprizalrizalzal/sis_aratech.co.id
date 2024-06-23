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
        $serviceDetails = [
            [
                'service_detail_code' => Str::upper(Str::random(8)),
                'user_id' => 3,
                'service_id' => 1,
                'problem_description' => 'Lemot',
                'repair_description' => 'Install Ulang Win 11',
                'cost' => 50000,

            ],
            [
                'service_detail_code' => Str::upper(Str::random(8)),
                'user_id' => 3,
                'service_id' => 2,
                'problem_description' => 'OverHeat',
                'repair_description' => 'Cleaning processor Dan Upgrade HDD to SSD 128Gb',
                'cost' => 100000,
            ],
            [
                'service_detail_code' => Str::upper(Str::random(8)),
                'user_id' => 3,
                'service_id' => 3,
                'problem_description' => 'Lemot dan Keyboard Error',
                'repair_description' => 'Bongkar Keyboard (Clean) dan Upgrade HDD to SSD 128Gb',
                'cost' => 75000,
            ]
        ];

        foreach ($serviceDetails as $serviceDetail) {
            ServiceDetail::create($serviceDetail);
        }
    }
}
