<?php

/**
 * Permissions Matrix
 *
 * Maps each permission/action to the roles that are allowed to perform it.
 * The '*' wildcard grants all permissions.
 *
 * Usage in middleware: ->middleware('permission:manage-leads')
 */

return [

    'Admin' => ['*'],   // Full access

    'Manager' => [
        'dashboard',
        'view-leads',
        'create-leads',
        'edit-leads',
        'view-customers',
        'create-customers',
        'edit-customers',
        'manage-deals',
        'view-reports',
        'export-data',
        'automation-rules',
        'bulk-messaging',
        'view-notifications',
        'view-settings',
    ],

    'Agent' => [
        'dashboard',
        'view-leads',
        'create-leads',
        'edit-leads',
        'view-customers',
        'manage-deals',
        'view-notifications',
    ],

    'Support' => [
        'dashboard',
        'view-leads',
        'view-customers',
        'view-notifications',
    ],

];
