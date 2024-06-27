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
        $customers = [
            [
                'user_id' => 4,
                'address' => 'Jl.Sunan Kalijaga 3',
                'phone' => '08175763389',
            ],
            [
                'user_id' => 5,
                'address' => 'Tandek, Ds.Labulia, Kec.Jonggat, Kab.Lombok Tengah',
                'phone' => '082236882796',
            ],
            [
                'user_id' => 6,
                'address' => 'Dasan Sebelek, Lombok Tengah',
                'phone' => '082340285252',
            ],
            [
                'user_id' => 7,
                'address' => 'Jl. Patin Raya No.48',
                'phone' => '087874996997',
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
