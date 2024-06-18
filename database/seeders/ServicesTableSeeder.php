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
        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 1,
            'device_id' => 1,
            'date_received' => '2024-05-28',
            'items_brought' => 'None',
            'estimated_completion' => '2024-05-28',
            'status' => 'Completed',
        ]);

        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 2,
            'device_id' => 2,
            'date_received' => '2024-06-10',
            'items_brought' => 'Bag, Charger',
            'estimated_completion' => '2024-06-11',
            'status' => 'Completed',
        ]);

        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 3,
            'device_id' => 3,
            'date_received' => '2024-06-14',
            'items_brought' => 'Bag, Charger',
            'estimated_completion' => '2024-06-15',
            'status' => 'Completed',
        ]);
    }
}
