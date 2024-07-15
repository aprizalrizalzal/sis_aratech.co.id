<?php

namespace Database\Seeders;

use App\Models\Header;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Header::create([
            'image_path' => 'storage/images/header/company_logo.png',
            'company' => 'ASLI MANDIRI COMPUTER',
            'description' => 'Jl. Gajah Mada, Jempong Baru, Sekarbela, Kota Mataram, Nusa Tenggara Barat.'
        ]);
    }
}
