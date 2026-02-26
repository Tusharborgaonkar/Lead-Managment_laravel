<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin: All permissions
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->sync(Permission::pluck('id'));
        }

        // Manager: Most permissions except user management
        $managerRole = Role::where('slug', 'manager')->first();
        if ($managerRole) {
            $managerPermissions = Permission::whereNotIn('slug', [
                'create-users',
                'edit-users',
                'delete-users',
                'manage-roles',
            ])->pluck('id');
            $managerRole->permissions()->sync($managerPermissions);
        }

        // Sales Rep: Lead, Customer, Deal, Follow-up permissions
        $salesRole = Role::where('slug', 'sales-rep')->first();
        if ($salesRole) {
            $salesPermissions = Permission::whereIn('group', [
                'leads',
                'customers',
                'deals',
                'followups',
                'notifications',
                'dashboard',
                'activity'
            ])->pluck('id');
            $salesRole->permissions()->sync($salesPermissions);
        }

        // Support: View-only and customer management
        $supportRole = Role::where('slug', 'support')->first();
        if ($supportRole) {
            $supportPermissions = Permission::whereIn('slug', [
                'view-leads',
                'view-customers',
                'create-customers',
                'edit-customers',
                'view-deals',
                'view-followups',
                'create-followups',
                'edit-followups',
                'view-activity-logs',
                'view-notifications',
                'view-dashboard',
                'view-settings',
                'edit-settings',
            ])->pluck('id');
            $supportRole->permissions()->sync($supportPermissions);
        }
    }
}
