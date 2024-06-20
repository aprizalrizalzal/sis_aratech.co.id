<?php

namespace Database\Seeders;

use App\Models\Header;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Header::create([
        //     'image_path' => './',
        //     'company' => 'Asli Mandiri Computer-AMITech',
        //     'description' => 'We are distributors of top brands including Emlink, TP-Link, Mercusys, ZimmLink, Ruijie, Totolink, HSairpo, Mikrotik, Ubiquiti, H3C, Netlink, Interluc, Mylink, Commfiber, Colan, ORBIT Telkomsel, Aukey, Rapoo, 5Star, Innovation, VenomRX, Aratech, Sandisk, Visipro, Hose, as well as laptop parts and various computer accessories.',
        // ]);

        $this->call([
            UsersTableSeeder::class,
            DeviceTypesTableSeeder::class,
            CustomersTableSeeder::class,
            DevicesTableSeeder::class,
            ServicesTableSeeder::class,
            ServiceDetailsTableSeeder::class,
            SparePartsTableSeeder::class,
            PartUsagesTableSeeder::class,
        ]);
    }
}
