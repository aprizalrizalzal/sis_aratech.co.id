<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            [
                'device_type_id' => 1,
                'model' => 'Lenovo ideapad 5-14IIL05 Laptop - Type 81YH',
                'serial_number' => 'MP1T9QA5',
            ],
            [
                'device_type_id' => 1,
                'model' => 'ASUS E402YA',
                'serial_number' => 'LBN0CV08485846C',
            ],
            [
                'device_type_id' => 1,
                'model' => 'ASUS X425EA',
                'serial_number' => 'SN',
            ],
            [
                'device_type_id' => 1,
                'model' => 'Lenovo 500-14ACZ Laptop (ideapad) - Type 80K3',
                'serial_number' => 'MP11J6NQ',
            ]
        ];

        foreach ($devices as $device) {
            Device::create($device);
        }
    }
}
