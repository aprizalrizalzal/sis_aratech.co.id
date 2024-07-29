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
            'company' => 'Nama Perusahaan',
            'url' => 'https://website-perusahaan',
            'description' => 'Alamat Perusahaan.'
        ]);
    }
}
