<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'user_id' => 1,
                'phone' => '087765889202',
                'address' => 'Beber, Batukliang, Lombok Tengah, NTB'

            ],
            [
                'user_id' => 2,
                'phone' => '087765543321',
                'address' => 'Address'
            ],
            [
                'user_id' => 3,
                'phone' => '081123345567',
                'address' => 'Address'
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
