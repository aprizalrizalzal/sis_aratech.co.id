<?php

namespace Database\Seeders;

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

        $this->call([
            HeadersTableSeeder::class,
            CarouselsTableSeeder::class,
            FootersTableSeeder::class,
            UsersTableSeeder::class,
            RolesTableSeeder::class,
            RoleUserTableSeeder::class,
            DeviceTypesTableSeeder::class,
            CustomersTableSeeder::class,
            DevicesTableSeeder::class,
            StatusWarrantyServicesTableSeeder::class,
            StatusServicesTableSeeder::class,
            ServicesTableSeeder::class,
            ServiceDetailsTableSeeder::class,
            CategorySparePartsTableSeeder::class,
            SparePartsTableSeeder::class,
            PartUsagesTableSeeder::class,
        ]);
    }
}
