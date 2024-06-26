<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 1,
                'device_id' => 1,
                'status_warranty' => 'Out Warranty',
                'date_received' => '2024-05-28',
                'problem_description' => 'Lemot',
                'estimated_completion' => '2024-05-28',
                'items_brought' => 'None',
                'status' => 'Completed',

            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 2,
                'device_id' => 2,
                'status_warranty' => 'Out Warranty',
                'date_received' => '2024-06-10',
                'problem_description' => 'OverHeat',
                'estimated_completion' => '2024-06-11',
                'items_brought' => 'Bag, Charger',
                'status' => 'Completed',
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 3,
                'device_id' => 3,
                'status_warranty' => 'Out Warranty',
                'date_received' => '2024-06-14',
                'problem_description' => 'Lemot dan Keyboard Error',
                'estimated_completion' => '2024-06-15',
                'items_brought' => 'Bag, Charger',
                'status' => 'Completed',
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
