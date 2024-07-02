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
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'user_id' => 5,
                'address' => 'Tandek, Ds.Labulia, Kec.Jonggat, Kab.Lombok Tengah',
                'phone' => '082236882796',
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'user_id' => 6,
                'address' => 'Dasan Sebelek, Lombok Tengah',
                'phone' => '082340285252',
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'user_id' => 7,
                'address' => 'Jl. Patin Raya No.48',
                'phone' => '087874996997',
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'user_id' => 8,
                'address' => 'Perumahan Griya Permata Blok C No.16',
                'phone' => '081999223721',
                'created_at' => '2024-06-27 12:00:00'
            ],
            [
                'user_id' => 9,
                'address' => 'Jln. Genggos No.10 Karang Sukun',
                'phone' => '081805555257	',
                'created_at' => '2024-06-29 12:00:00'
            ]
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
