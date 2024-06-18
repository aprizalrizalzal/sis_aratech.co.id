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
            'user_id' => 4,
            'address' => 'Jl.Sunan Kalijaga 3',
            'phone' => '08175763389',
        ]);

        Customer::create([
            'user_id' => 5,
            'address' => 'Tandek, Ds.Labulia, Kec.Jonggat, Kab.Lombok Tengah',
            'phone' => '082236882796',
        ]);

        Customer::create([
            'user_id' => 6,
            'address' => 'Dasan Sebelek, Lombok Tengah',
            'phone' => '082340285252',
        ]);
    }
}