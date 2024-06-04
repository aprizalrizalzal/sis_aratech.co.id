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
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 1,
            'device_id' => 1,
            'date_received' => Carbon::now(),
            'items_brought' => 'Charger, Bag',
            'estimated_completion' => Carbon::now()->addDays(3),
            'status' => 'In Progress',
        ]);

        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 2,
            'device_id' => 2,
            'date_received' => Carbon::now(),
            'items_brought' => 'none',
            'estimated_completion' => Carbon::now()->addDays(5),
            'status' => 'Pending',
        ]);

        Service::create([
            'service_code' => Str::upper(Str::random(8)),
            'customer_id' => 2,
            'device_id' => 3,
            'date_received' => Carbon::now(),
            'items_brought' => 'Charger, Bag',
            'estimated_completion' => Carbon::now()->addDays(3),
            'status' => 'In Progress',
        ]);
    }
}
