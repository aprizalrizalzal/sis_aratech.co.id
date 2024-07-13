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
                'status_warranty_service_id' => 2,
                'date_received' => '2024-05-28',
                'problem_description' => 'Lemot',
                'estimated_completion' => '2024-05-28',
                'items_brought' => 'None',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 2,
                'device_id' => 2,
                'status_warranty_service_id' => 2,
                'date_received' => '2024-06-10',
                'problem_description' => 'OverHeat',
                'estimated_completion' => '2024-06-11',
                'items_brought' => 'Bag, Charger',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 3,
                'device_id' => 3,
                'status_warranty_service_id' => 2,
                'date_received' => '2024-06-14',
                'problem_description' => 'Lemot dan Keyboard Error',
                'estimated_completion' => '2024-06-15',
                'items_brought' => 'Bag, Charger',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 4,
                'device_id' => 4,
                'status_warranty_service_id' => 2,
                'date_received' => '2024-06-24',
                'problem_description' => 'Lemot dan Engsel rusak',
                'estimated_completion' => '2024-06-25',
                'items_brought' => 'Charger',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 5,
                'device_id' => 5,
                'status_warranty_service_id' => 2,
                'date_received' => '2024-06-27',
                'problem_description' => 'Keyboard Error',
                'estimated_completion' => '2024-06-28',
                'items_brought' => '-',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-06-27 12:00:00'
            ],
            [
                'service_code' => Str::upper(Str::random(6)),
                'customer_id' => 6,
                'device_id' => 6,
                'status_warranty_service_id' => 2,
                'date_received' => '2024-06-29',
                'problem_description' => 'Keyboard Error',
                'estimated_completion' => '2024-06-29',
                'items_brought' => '-',
                'status_service_id' => 1,
                'notes' => '-',
                'created_at' => '2024-06-29 12:00:00'
            ]

        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
