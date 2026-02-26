<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        $adminRole = Role::where('slug', 'admin')->first();
        User::updateOrCreate(
            ['email' => 'admin@leadmanagement.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0100',
                'department' => 'Management',
                'role_id' => $adminRole?->id,
                'is_active' => true,
            ]
        );

        // Manager User
        $managerRole = Role::where('slug', 'manager')->first();
        User::updateOrCreate(
            ['email' => 'manager@leadmanagement.com'],
            [
                'name' => 'Sales Manager',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0101',
                'department' => 'Sales',
                'role_id' => $managerRole?->id,
                'is_active' => true,
            ]
        );

        // Sales Representative Users
        $salesRole = Role::where('slug', 'sales-rep')->first();
        
        User::updateOrCreate(
            ['email' => 'john.doe@leadmanagement.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0102',
                'department' => 'Sales',
                'role_id' => $salesRole?->id,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'jane.smith@leadmanagement.com'],
            [
                'name' => 'Jane Smith',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0103',
                'department' => 'Sales',
                'role_id' => $salesRole?->id,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'bob.wilson@leadmanagement.com'],
            [
                'name' => 'Bob Wilson',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0104',
                'department' => 'Sales',
                'role_id' => $salesRole?->id,
                'is_active' => true,
            ]
        );

        // Support User
        $supportRole = Role::where('slug', 'support')->first();
        User::updateOrCreate(
            ['email' => 'support@leadmanagement.com'],
            [
                'name' => 'Support Team',
                'password' => bcrypt('password'),
                'phone' => '+1-555-0105',
                'department' => 'Support',
                'role_id' => $supportRole?->id,
                'is_active' => true,
            ]
        );
    }
}
