<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Full system access'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Team oversight and reporting'
            ],
            [
                'name' => 'Sales Representative',
                'slug' => 'sales-rep',
                'description' => 'Lead and deal management'
            ],
            [
                'name' => 'Support',
                'slug' => 'support',
                'description' => 'Customer service support'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}
