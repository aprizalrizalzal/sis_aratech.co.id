<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'aprizal',
            'address' => 'Pegesangan-Mataram',
            'phone' => '087765543321',
            'email' => 'aprizal@example.com',
        ]);

        Customer::create([
            'name' => 'rizal',
            'address' => 'Karang Pule-Mataram',
            'phone' => '087765543322',
            'email' => 'rizal@example.com',
        ]);

        Customer::create([
            'name' => 'zal',
            'address' => 'Jempong Baru-Mataram',
            'phone' => '087765543323',
            'email' => 'zal@example.com',
        ]);
    }
}
