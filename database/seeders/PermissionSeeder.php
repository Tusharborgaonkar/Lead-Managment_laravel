<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Lead Permissions
            [
                'name' => 'View Leads',
                'slug' => 'view-leads',
                'description' => 'Can view leads',
                'group' => 'leads'
            ],
            [
                'name' => 'Create Leads',
                'slug' => 'create-leads',
                'description' => 'Can create new leads',
                'group' => 'leads'
            ],
            [
                'name' => 'Edit Leads',
                'slug' => 'edit-leads',
                'description' => 'Can edit existing leads',
                'group' => 'leads'
            ],
            [
                'name' => 'Delete Leads',
                'slug' => 'delete-leads',
                'description' => 'Can delete leads',
                'group' => 'leads'
            ],

            // Customer Permissions
            [
                'name' => 'View Customers',
                'slug' => 'view-customers',
                'description' => 'Can view customers',
                'group' => 'customers'
            ],
            [
                'name' => 'Create Customers',
                'slug' => 'create-customers',
                'description' => 'Can create new customers',
                'group' => 'customers'
            ],
            [
                'name' => 'Edit Customers',
                'slug' => 'edit-customers',
                'description' => 'Can edit existing customers',
                'group' => 'customers'
            ],
            [
                'name' => 'Delete Customers',
                'slug' => 'delete-customers',
                'description' => 'Can delete customers',
                'group' => 'customers'
            ],

            // Deal Permissions
            [
                'name' => 'View Deals',
                'slug' => 'view-deals',
                'description' => 'Can view deals',
                'group' => 'deals'
            ],
            [
                'name' => 'Create Deals',
                'slug' => 'create-deals',
                'description' => 'Can create new deals',
                'group' => 'deals'
            ],
            [
                'name' => 'Edit Deals',
                'slug' => 'edit-deals',
                'description' => 'Can edit existing deals',
                'group' => 'deals'
            ],
            [
                'name' => 'Delete Deals',
                'slug' => 'delete-deals',
                'description' => 'Can delete deals',
                'group' => 'deals'
            ],

            // Follow-up Permissions
            [
                'name' => 'View Followups',
                'slug' => 'view-followups',
                'description' => 'Can view follow-ups',
                'group' => 'followups'
            ],
            [
                'name' => 'Create Followups',
                'slug' => 'create-followups',
                'description' => 'Can create follow-ups',
                'group' => 'followups'
            ],
            [
                'name' => 'Edit Followups',
                'slug' => 'edit-followups',
                'description' => 'Can edit follow-ups',
                'group' => 'followups'
            ],
            [
                'name' => 'Delete Followups',
                'slug' => 'delete-followups',
                'description' => 'Can delete follow-ups',
                'group' => 'followups'
            ],

            // Activity Log Permissions
            [
                'name' => 'View Activity Logs',
                'slug' => 'view-activity-logs',
                'description' => 'Can view activity logs',
                'group' => 'activity'
            ],

            // Notification Permissions
            [
                'name' => 'View Notifications',
                'slug' => 'view-notifications',
                'description' => 'Can view notifications',
                'group' => 'notifications'
            ],
            [
                'name' => 'Manage Notifications',
                'slug' => 'manage-notifications',
                'description' => 'Can manage notifications',
                'group' => 'notifications'
            ],

            // Dashboard Permissions
            [
                'name' => 'View Dashboard',
                'slug' => 'view-dashboard',
                'description' => 'Can view dashboard',
                'group' => 'dashboard'
            ],

            // Settings Permissions
            [
                'name' => 'View Settings',
                'slug' => 'view-settings',
                'description' => 'Can view settings',
                'group' => 'settings'
            ],
            [
                'name' => 'Edit Settings',
                'slug' => 'edit-settings',
                'description' => 'Can edit settings',
                'group' => 'settings'
            ],

            // User Management Permissions
            [
                'name' => 'View Users',
                'slug' => 'view-users',
                'description' => 'Can view users',
                'group' => 'users'
            ],
            [
                'name' => 'Create Users',
                'slug' => 'create-users',
                'description' => 'Can create new users',
                'group' => 'users'
            ],
            [
                'name' => 'Edit Users',
                'slug' => 'edit-users',
                'description' => 'Can edit users',
                'group' => 'users'
            ],
            [
                'name' => 'Delete Users',
                'slug' => 'delete-users',
                'description' => 'Can delete users',
                'group' => 'users'
            ],
            [
                'name' => 'Manage Roles',
                'slug' => 'manage-roles',
                'description' => 'Can manage roles and permissions',
                'group' => 'users'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
    }
}
