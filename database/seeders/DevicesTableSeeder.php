<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::create([
            'device_type_id' => 1,
            'model' => 'Dell Inspiron',
            'serial_number' => Str::upper(Str::random(8)),
        ]);

        Device::create([
            'device_type_id' => 2,
            'model' => 'HP LaserJet',
            'serial_number' => Str::upper(Str::random(8)),
        ]);

        Device::create([
            'device_type_id' => 1,
            'model' => 'Lenovo',
            'serial_number' => Str::upper(Str::random(8)),
        ]);
    }
}
