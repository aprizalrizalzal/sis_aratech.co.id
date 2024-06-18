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
            'model' => 'Lenovo',
            'serial_number' => 'MP1T9QA5',
        ]);

        Device::create([
            'device_type_id' => 2,
            'model' => 'ASUS E402YA-GA202T',
            'serial_number' => 'LBN0CV08485846C',
        ]);

        Device::create([
            'device_type_id' => 1,
            'model' => 'Lenovo',
            'serial_number' => '',
        ]);
    }
}