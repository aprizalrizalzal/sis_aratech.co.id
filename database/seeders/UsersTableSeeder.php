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
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'role' => 'admin',
            'password' => Hash::make('password')
        ]);

        // Technician User
        User::create([
            'name' => 'Technician User',
            'email' => 'technician@example.com',
            'email_verified_at' => Carbon::now(),
            'role' => 'technician',
            'password' => Hash::make('password')
        ]);

        // Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'email_verified_at' => Carbon::now(),
            'role' => 'customer',
            'password' => Hash::make('password')
        ]);
    }
}
