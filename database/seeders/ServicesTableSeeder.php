<?php

namespace Database\Seeders;

use App\Models\Service;
use Carbon\Carbon;
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
            'service_code' => '12345678',
            'customer_id' => 1,
            'device_id' => 1,
            'date_received' => date(2024),
            'items_brought' => 'None',
            'estimated_completion' => date(2024),
            'status' => 'Completed',
        ]);

        Service::create([
            'service_code' => '12345678',
            'customer_id' => 2,
            'device_id' => 2,
            'date_received' => date(2024),
            'items_brought' => 'Bag, Charger',
            'estimated_completion' =>date(2024),
            'status' => 'Completed',
        ]);

        Service::create([
            'service_code' => '12345678',
            'customer_id' => 3,
            'device_id' => 3,
            'date_received' => date(2024),
            'items_brought' => 'Bag, Charger',
            'estimated_completion' => date(2024),
            'status' => 'Completed',
        ]);
    }
}