<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari pengguna dengan peran 'user' dan berikan peran tersebut ke pengguna
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $users = User::where('email', 'user@example.com')->get();
            foreach ($users as $user) {
                $user->roles()->syncWithoutDetaching([$userRole->id => ['created_at' => now(), 'updated_at' => now()]]);
            }
        }

        // Cari pengguna dengan peran 'admin' dan berikan peran tersebut ke pengguna
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admins = User::where('email', 'admin@example.com')->get();
            foreach ($admins as $user) {
                $user->roles()->syncWithoutDetaching([$adminRole->id => ['created_at' => now(), 'updated_at' => now()]]);
            }
        }

        // Cari pengguna dengan peran 'super-admin' dan berikan peran tersebut ke pengguna
        $superAdminRole = Role::where('name', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdmins = User::where('email', 'superadmin@example.com')->get();
            foreach ($superAdmins as $user) {
                $user->roles()->syncWithoutDetaching([$superAdminRole->id => ['created_at' => now(), 'updated_at' => now()]]);
                $user->roles()->syncWithoutDetaching([$adminRole->id => ['created_at' => now(), 'updated_at' => now()]]);
                $user->roles()->syncWithoutDetaching([$userRole->id => ['created_at' => now(), 'updated_at' => now()]]);
            }
        }
    }
}
