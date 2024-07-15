<?php

namespace Database\Seeders;

use App\Models\PlatformFooter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlatformFootersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $platformFooters = [
            // Kontak Langsung
            ['platform' => 'Email', 'description' => '-'],
            ['platform' => 'Phone', 'description' => '-'],
            ['platform' => 'WhatsApp', 'description' => '-'],

            // Media Sosial
            ['platform' => 'Facebook', 'description' => '-'],
            ['platform' => 'Instagram', 'description' => '-'],

            // Platform Lainnya
            ['platform' => 'Google', 'description' => '-'],
            ['platform' => 'Apple', 'description' => '-'],

        ];

        foreach ($platformFooters as $platformFooter) {
            PlatformFooter::create($platformFooter);
        }
    }
}
