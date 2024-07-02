<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Muhamad Aprizal Hardi',
                'email' => 'zalrizalaprizal@icloud.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')

            ],
            [
                'name' => 'Widiya',
                'email' => 'widiya231200@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Aprizal',
                'email' => 'aparizalrizalzal@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Agung',
                'email' => 'agung@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'name' => 'Nurhaliza Rusnia',
                'email' => 'nurhalizarusnia@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'name' => 'Suhartini',
                'email' => 'suhartini@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'name' => 'Lalu Saladin Jufri',
                'email' => 'lalusaladinjufri@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'name' => 'Ratna Hawati',
                'email' => 'ratnahawati@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-27 12:00:00'
            ],
            [
                'name' => 'Afan Alpian',
                'email' => 'afanalpian@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-29 12:00:00'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
