<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super-admin',
                'description' => 'super-administrator'

            ],
            [
                'name' => 'admin',
                'description' => 'Administrator'
            ],
            [
                'name' => 'user',
                'description' => 'Regular User'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
