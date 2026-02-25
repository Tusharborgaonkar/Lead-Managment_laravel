<?php

return [

    'app' => [
        'name'        => 'CRM Admin',
        'version'     => '1.0.0',
        'admin_email' => 'admin@crm-industries.com',
        'currency'    => '$',
    ],

    'dashboard_stats' => [
        ['icon' => 'target',      'color' => 'indigo', 'value' => '2,847',  'label' => 'Total Leads',    'change' => '+12.5%', 'changeColor' => 'emerald'],
        ['icon' => 'users',       'color' => 'emerald','value' => '1,245',  'label' => 'Customers',      'change' => '+8.3%',  'changeColor' => 'emerald'],
        ['icon' => 'dollar-sign', 'color' => 'amber',  'value' => '$482K',  'label' => 'Revenue',        'change' => '+23.1%', 'changeColor' => 'emerald'],
        ['icon' => 'handshake',   'color' => 'sky',    'value' => '156',    'label' => 'Active Deals',   'change' => '-3.2%',  'changeColor' => 'rose'],
    ],

    'recent_notifications' => [
        ['title' => 'New Lead Assigned',   'desc' => 'James Wilson was assigned to you',          'time' => '2 min ago',   'icon' => 'user-plus',     'color' => 'indigo'],
        ['title' => 'Task Overdue',        'desc' => 'Review contract for Stellar Marketing',     'time' => '1 hour ago',  'icon' => 'alert-circle',  'color' => 'rose'],
        ['title' => 'Deal Stage Updated',  'desc' => 'TechCorp deal moved to Negotiation',       'time' => '3 hours ago', 'icon' => 'bar-chart-2',   'color' => 'emerald'],
        ['title' => 'New Comment',         'desc' => 'Sarah replied to your note',               'time' => '5 hours ago', 'icon' => 'message-square','color' => 'sky'],
        ['title' => 'System Update',       'desc' => 'System maintenance scheduled for tonight', 'time' => '1 day ago',   'icon' => 'settings',      'color' => 'slate'],
    ],

    'recent_messages' => [
        ['user' => 'Sarah Johnson', 'desc' => 'Can we discuss the enterprise plan?', 'time' => '15 min ago', 'avatar' => 'SJ', 'color' => 'indigo'],
        ['user' => 'Michael Chen',  'desc' => 'The contract has been signed.',        'time' => '1 hour ago', 'avatar' => 'MC', 'color' => 'emerald'],
        ['user' => 'Emma Wilson',   'desc' => 'I sent the portfolio samples.',        'time' => '3 hours ago','avatar' => 'EW', 'color' => 'sky'],
    ],

    'lead_statuses' => ['new', 'followup', 'pending', 'confirm', 'not interested'],

    'lead_sources' => ['Website', 'Referral', 'Cold Call', 'LinkedIn', 'Email', 'Trade Show', 'Other'],

    'deal_stages' => ['Prospect', 'Qualified', 'Proposal', 'Negotiation', 'Won', 'Lost'],

    'customer_groups' => [
        ['id' => 1, 'name' => 'Millennials',   'color' => 'indigo'],
        ['id' => 2, 'name' => 'Generation Z',  'color' => 'purple'],
        ['id' => 3, 'name' => 'Alpha',         'color' => 'pink'],
        ['id' => 4, 'name' => 'Baby Boomers',  'color' => 'slate'],
    ],

    'notification_settings' => [
        ['label' => 'Email Notifications', 'desc' => 'Receive emails for important updates',      'checked' => true],
        ['label' => 'New Lead Alerts',      'desc' => 'Get notified when new leads are added',    'checked' => true],
        ['label' => 'Deal Updates',         'desc' => 'Notifications on deal stage changes',      'checked' => false],
        ['label' => 'Task Reminders',       'desc' => 'Reminders for upcoming & overdue tasks',   'checked' => true],
        ['label' => 'Weekly Summary',       'desc' => 'Receive a weekly performance digest',      'checked' => true],
    ],

];
