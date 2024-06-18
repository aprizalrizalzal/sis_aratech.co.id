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
            'model' => 'Lenovo ideapad 5-14IIL05 Laptop - Type 81YH',
            'serial_number' => 'MP1T9QA5',
        ]);

        Device::create([
            'device_type_id' => 1,
            'model' => 'ASUS E402YA',
            'serial_number' => 'LBN0CV08485846C',
        ]);

        Device::create([
            'device_type_id' => 1,
            'model' => 'ASUS X425EA',
            'serial_number' => 'SN',
        ]);
    }
}
