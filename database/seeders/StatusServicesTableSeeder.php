<?php

namespace Database\Seeders;

use App\Models\StatusService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusServices = [
            [
                'status' => 'Completed',
                'description' => '-'

            ],
            [
                'status' => 'Failed',
                'description' => '-'
            ],
            [
                'status' => 'In Progress',
                'description' => '-'
            ],
            [
                'status' => 'Received',
                'description' => '-'
            ]
        ];

        foreach ($statusServices as $statusService) {
            StatusService::create($statusService);
        }
    }
}
