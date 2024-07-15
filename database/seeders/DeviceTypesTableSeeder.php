<?php

namespace Database\Seeders;

use App\Models\DeviceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deviceTypes = [
            [
                'type_name' => 'PC Desktop',
                'description' => '-'
            ],
            [
                'type_name' => 'Printer',
                'description' => '-'
            ],
            [
                'type_name' => 'PC All In One',
                'description' => '-'
            ],
            [
                'type_name' => 'Laptop',
                'description' => '-'
            ],
            [
                'type_name' => 'LCD Projector',
                'description' => '-'
            ],
            [
                'type_name' => 'Others',
                'description' => '-'
            ]
        ];

        foreach ($deviceTypes as $deviceType) {
            DeviceType::create($deviceType);
        }
    }
}
