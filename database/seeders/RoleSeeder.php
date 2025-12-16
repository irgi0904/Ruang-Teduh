<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full access to all features and settings',
            ],
            [
                'name' => 'kasir',
                'display_name' => 'Kasir',
                'description' => 'Can manage orders and transactions',
            ],
            [
                'name' => 'pengguna',
                'display_name' => 'Pengguna',
                'description' => 'Regular customer with basic access',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}