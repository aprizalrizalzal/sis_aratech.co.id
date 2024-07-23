<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
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
            NotesTableSeeder::class,
            TypeFootersTableSeeder::class,
            PlatformFootersTableSeeder::class,
            FootersTableSeeder::class,
            UsersTableSeeder::class,
            CustomersTableSeeder::class,
            RolesTableSeeder::class,
            RoleUserTableSeeder::class,
            DeviceTypesTableSeeder::class,
            StatusWarrantyServicesTableSeeder::class,
            StatusServicesTableSeeder::class,
            CategorySparePartsTableSeeder::class,
            SparePartsTableSeeder::class,
        ]);
    }
}
