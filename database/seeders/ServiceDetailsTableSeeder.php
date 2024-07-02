<?php

namespace Database\Seeders;

use App\Models\ServiceDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceDetails = [
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 1,
                'repair_description' => 'Install Ulang Win 11',
                'cost' => 50000,
                'notes' => '',
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 2,
                'repair_description' => 'Cleaning processor Dan Upgrade HDD to SSD 128GB',
                'cost' => 100000,
                'notes' => 'Rekomendasi beli portable HDD external',
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 3,
                'repair_description' => 'Bongkar Keyboard (Cleaned) dan Upgrade HDD to SSD 128GB',
                'cost' => 75000,
                'notes' => 'Rekomendasi beli portable HDD external',
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 4,
                'repair_description' => 'Bongkar full Laptop (Cleaned) dan perbaikan Engsel',
                'cost' => 100000,
                'notes' => 'Rekomendasi ganti HDD ke SSD',
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 5,
                'repair_description' => 'Cleaned keyboard',
                'cost' => 50000,
                'notes' => 'Selagi masih bisa dibersihkan tidak perlu diganti keyboard aslinya',
                'created_at' => '2024-06-27 12:00:00'
            ],
            [
                'service_detail_code' => Str::upper(Str::random(6)),
                'user_id' => 3,
                'service_id' => 6,
                'repair_description' => 'Cleaned keyboard',
                'cost' => 20000,
                'notes' => 'Selagi masih bisa dibersihkan tidak perlu diganti keyboard aslinya',
                'created_at' => '2024-06-29 12:00:00'
            ]
        ];

        foreach ($serviceDetails as $serviceDetail) {
            ServiceDetail::create($serviceDetail);
        }
    }
}
