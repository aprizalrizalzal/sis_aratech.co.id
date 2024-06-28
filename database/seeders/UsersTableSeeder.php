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
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')

            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Agung',
                'email' => 'agung@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-05-28 12:00:00'
            ],
            [
                'name' => 'Nurhaliza Rusnia',
                'email' => 'nurhalizarusnia@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-10 12:00:00'
            ],
            [
                'name' => 'Suhartini',
                'email' => 'suhartini@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-14 12:00:00'
            ],
            [
                'name' => 'Lalu Saladin Jufri',
                'email' => 'lalusaladinjufri@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-24 12:00:00'
            ],
            [
                'name' => 'Ratna Hawati',
                'email' => 'ratnahawati@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password'),
                'created_at' => '2024-06-27 12:00:00'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
