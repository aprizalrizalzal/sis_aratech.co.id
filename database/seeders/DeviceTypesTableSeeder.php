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
        DeviceType::create([
            'type_name' => 'Laptop'
        ]);
        DeviceType::create([
            'type_name' => 'Printer'
        ]);
    }
}
