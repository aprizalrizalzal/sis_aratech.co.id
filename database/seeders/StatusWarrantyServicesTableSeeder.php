<?php

namespace Database\Seeders;

use App\Models\StatusWarrantyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusWarrantyServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusWarrantyServices = [
            [
                'status' => 'In Warranty',
                'description' => '-'

            ],
            [
                'status' => 'Out Warranty',
                'description' => '-'
            ]
        ];

        foreach ($statusWarrantyServices as $statusWarrantyService) {
            StatusWarrantyService::create($statusWarrantyService);
        }
    }
}
