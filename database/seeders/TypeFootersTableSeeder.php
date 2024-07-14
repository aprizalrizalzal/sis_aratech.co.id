<?php

namespace Database\Seeders;

use App\Models\TypeFooter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeFootersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeFooters = [
            [
                'type' => 'Contact',
                'description' => '-'

            ],
            [
                'type' => 'Social Media',
                'description' => '-'
            ],
            [
                'type' => 'Service',
                'description' => '-'
            ],
            [
                'type' => 'App Download',
                'description' => '-'
            ],
            [
                'type' => 'Platform',
                'description' => '-'
            ],
            [
                'type' => 'Business',
                'description' => '-'
            ],
            [
                'type' => 'Messaging App',
                'description' => '-'
            ],
            [
                'type' => 'Forum',
                'description' => '-'
            ],
        ];

        foreach ($typeFooters as $typeFooter) {
            TypeFooter::create($typeFooter);
        }
    }
}
