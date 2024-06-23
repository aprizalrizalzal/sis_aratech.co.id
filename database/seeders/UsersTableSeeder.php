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
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Nurhaliza Rusnia',
                'email' => 'nurhalizarusnia@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Suhartini',
                'email' => 'suhartini@example.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
