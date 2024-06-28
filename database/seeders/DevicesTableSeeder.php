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
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'device_type_id' => 1,
                'model' => 'ASUS E402YA',
                'serial_number' => 'LBN0CV08485846C',
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'device_type_id' => 1,
                'model' => 'ASUS X425EA',
                'serial_number' => 'SN',
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'device_type_id' => 1,
                'model' => 'Lenovo 500-14ACZ Laptop (ideapad) - Type 80K3',
                'serial_number' => 'MP11J6NQ',
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'device_type_id' => 1,
                'model' => 'Mybook Axioo (PNB08P)',
                'serial_number' => '00222030050463006',
                'created_at' => '2024-06-27 12:00:00'
            ]
        ];

        foreach ($devices as $device) {
            Device::create($device);
        }
    }
}
