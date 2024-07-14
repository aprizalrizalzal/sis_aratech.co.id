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
            ['platform' => 'Twitter', 'description' => '-'],
            ['platform' => 'LinkedIn', 'description' => '-'],
            ['platform' => 'YouTube', 'description' => '-'],
            ['platform' => 'Pinterest', 'description' => '-'],
            ['platform' => 'Snapchat', 'description' => '-'],
            ['platform' => 'TikTok', 'description' => '-'],

            // Platform Lainnya
            ['platform' => 'Google', 'description' => '-'],
            ['platform' => 'Apple', 'description' => '-'],
            ['platform' => 'Microsoft', 'description' => '-'],
            ['platform' => 'Amazon', 'description' => '-'],
            ['platform' => 'Reddit', 'description' => '-'],
            ['platform' => 'GitHub', 'description' => '-'],

            // Platform Bisnis
            ['platform' => 'Yelp', 'description' => '-'],
            ['platform' => 'Glassdoor', 'description' => '-'],
            ['platform' => 'AngelList', 'description' => '-'],

            // Messaging Apps
            ['platform' => 'Telegram', 'description' => '-'],
            ['platform' => 'Messenger', 'description' => '-'],
            ['platform' => 'Line', 'description' => '-'],
            ['platform' => 'Viber', 'description' => '-'],
            ['platform' => 'Signal', 'description' => '-'],

            // Forum dan Komunitas
            ['platform' => 'Quora', 'description' => '-'],
            ['platform' => 'Stack Overflow', 'description' => '-'],
            ['platform' => 'Discord', 'description' => '-'],
            ['platform' => 'Twitch', 'description' => '-'],
            ['platform' => 'Slack', 'description' => '-'],
        ];

        foreach ($platformFooters as $platformFooter) {
            PlatformFooter::create($platformFooter);
        }
    }
}
