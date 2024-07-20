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
                'email' => 'widiyanur231200@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Aprizal',
                'email' => 'aprizalrizalzal@gmail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
