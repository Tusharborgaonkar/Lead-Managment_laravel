# Database Implementation Guide

## 🚀 Quick Start

### Step 1: Run Migrations

```bash
# Generate all tables
php artisan migrate

# See migration status
php artisan migrate:status
```

### Step 2: Seed Sample Data

```bash
# Seed roles, permissions, and users
php artisan db:seed

# Or run specific seeder
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=RolePermissionSeeder
php artisan db:seed --class=UserSeeder
```

### Step 3: Verify Installation

```bash
# Check tables created
php artisan tinker
>>> DB::table('users')->count();    # Should return 6
>>> DB::table('roles')->count();    # Should return 4
>>> DB::table('permissions')->count(); # Should return 25+
```

---

## 📋 Database Models (Eloquent ORM)

Each table has a corresponding Eloquent Model in `app/Models/`:

### Available Models

```php
// User Management
User::class              // app/Models/User.php
Role::class              // app/Models/Role.php
Permission::class        // app/Models/Permission.php

// Core Business
Customer::class          // app/Models/Customer.php
Lead::class              // app/Models/Lead.php
Deal::class              // app/Models/Deal.php
Followup::class          // app/Models/Followup.php

// Supporting
Note::class              // app/Models/Note.php
ActivityLog::class       // app/Models/ActivityLog.php
Notification::class      // app/Models/Notification.php
Setting::class           // app/Models/Setting.php
```

---

## 💻 Using Models in Code

### Basic Queries

```php
use App\Models\Lead;
use App\Models\Customer;

// Find by ID
$lead = Lead::find(1);

// All records
$leads = Lead::all();

// With conditions
$activeLeads = Lead::where('category', 'Confirm')->get();

// Paginated results
$leads = Lead::paginate(15);

// Find by column
$customer = Customer::where('email', 'john@example.com')->first();
```

### Relationships

```php
// Get all leads for a customer
$customer = Customer::find(1);
$leads = $customer->leads;

// Get customer for a lead
$lead = Lead::find(1);
$customer = $lead->customer;

// Get assigned sales rep for a lead
$assignedTo = $lead->assignedTo;

// Get all deals for a user
$user = User::find(1);
$deals = $user->deals;

// Get notes for a lead
$notes = $lead->notes;
$lead->notes()->create(['content' => 'New note...']);

// Get activity log for a customer
$logs = $customer->activityLogs;
```

### Creating Records

```php
// Create new customer
$customer = Customer::create([
    'name' => 'Acme Corp',
    'email' => 'contact@acme.com',
    'company' => 'Acme',
    'phone' => '+1-555-1234',
    'group' => 'Enterprise',
    'status' => 'active',
]);

// Create new lead
$lead = Lead::create([
    'name' => 'John Smith',
    'email' => 'john@example.com',
    'company' => 'Acme Corp',
    'source' => 'Website',
    'category' => 'Pending',
    'value' => 15000,
    'customer_id' => $customer->id,
    'assigned_to' => auth()->id(),
]);

// Create deal
$deal = Deal::create([
    'title' => 'Enterprise Package Deal',
    'value' => 50000,
    'stage' => 'Open',
    'probability' => 75,
    'lead_id' => $lead->id,
    'customer_id' => $customer->id,
    'owner_id' => auth()->id(),
]);
```

### Updating Records

```php
$lead = Lead::find(1);

// Update multiple fields
$lead->update([
    'category' => 'Confirm',
    'followup_date' => now()->addDays(3),
]);

// Or set individually
$lead->category = 'Confirm';
$lead->save();

// Increment counter
$lead->increment('notes_count');
```

### Deleting Records

```php
$lead = Lead::find(1);

// Soft delete (still in DB)
$lead->delete();

// Restore soft-deleted record
$lead->restore();

// Hard delete (permanent)
$lead->forceDelete();

// Get only soft-deleted
$deletedLeads = Lead::onlyTrashed()->get();

// Get all including deleted
$allLeads = Lead::withTrashed()->get();
```

---

## 🔐 Authorization & Permissions

### Check User Permissions

```php
$user = auth()->user();

// Check single permission
if ($user->hasPermission('create-leads')) {
    // Allow lead creation
}

// Check role
if ($user->hasRole('admin')) {
    // Admin only actions
}

// Check is active
if ($user->isActive()) {
    // User can perform actions
}

// Get user role
$role = $user->role; // Returns Role model
$roleName = $user->role->name;
```

### Role-Based Access

```php
// Admin - all access
if (auth()->user()->isAdmin()) {
    // Full access
}

// Sales Rep - lead/deal access
if (auth()->user()->hasRole('sales-rep')) {
    // Lead and deal operations
}

// Manager - view and report
if (auth()->user()->hasRole('manager')) {
    // View all, limited edit
}

// Support - customer only
if (auth()->user()->hasRole('support')) {
    // Customer operations only
}
```

### Permission Groups

```php
// Get all permissions in a group
$leadPermissions = Permission::where('group', 'leads')->get();

// Get role permissions
$adminPermissions = Role::where('slug', 'admin')
    ->first()
    ->permissions;

// Assign permission to role
$role = Role::find(1);
$permission = Permission::find(5);
$role->permissions()->attach($permission);

// Remove permission
$role->permissions()->detach($permission);

// Sync permissions (replace all)
$role->permissions()->sync([1, 2, 3, 4]);
```

---

## 📊 Data Queries & Aggregations

### Lead Statistics

```php
use App\Models\Lead;

// Count by category
$categories = Lead::select('category')
    ->selectRaw('COUNT(*) as count')
    ->groupBy('category')
    ->get();

// Count by source
$bySources = Lead::selectRaw("source, COUNT(*) as count")
    ->groupBy('source')
    ->get();

// Total lead value
$totalValue = Lead::sum('value');

// Average lead value
$avgValue = Lead::avg('value');

// Count with notes
$withNotes = Lead::where('has_notes', true)->count();

// Today's notes added
$todayNotes = Lead::whereDate('created_at', today())
    ->where('has_notes', true)
    ->count();
```

### Deal Statistics

```php
use App\Models\Deal;

// Total by stage
$dealsByStage = Deal::select('stage')
    ->selectRaw('COUNT(*) as count, SUM(value) as total')
    ->groupBy('stage')
    ->get();

// Won deals
$wonDeals = Deal::where('stage', 'Won')->count();
$wonValue = Deal::where('stage', 'Won')->sum('value');

// Open deals
$openDeals = Deal::where('stage', 'Open')->count();

// Deal funnel
$funnel = [
    'Total Leads' => Lead::count(),
    'Qualified' => Lead::where('category', 'Confirm')->count(),
    'In Deals' => Deal::count(),
    'Won' => Deal::where('stage', 'Won')->count(),
];
```

### Follow-up Scheduling

```php
use App\Models\Followup;

// Upcoming follow-ups
$upcoming = Followup::where('status', 'Pending')
    ->where('scheduled_at', '>=', now())
    ->orderBy('scheduled_at')
    ->get();

// Today's follow-ups
$today = Followup::whereDate('scheduled_at', today())
    ->where('status', 'Pending')
    ->get();

// Overdue follow-ups
$overdue = Followup::where('status', 'Pending')
    ->where('scheduled_at', '<', now())
    ->get();

// Completed today
$completedToday = Followup::whereDate('completed_at', today())
    ->count();
```

### User Activity

```php
use App\Models\ActivityLog;

// User activity timeline
$logs = ActivityLog::where('user_id', auth()->id())
    ->orderByDesc('created_at')
    ->limit(50)
    ->get();

// Entity change history
$leadHistory = ActivityLog::where('entity_type', Lead::class)
    ->where('entity_id', 1)
    ->orderByDesc('created_at')
    ->get();

// Find who made a change
foreach ($logs as $log) {
    echo "{$log->user->name} {$log->action}d {$log->entity_type}";
}

// Changes in date range
$monthlyActivity = ActivityLog::whereBetween('created_at', [
    now()->startOfMonth(),
    now()->endOfMonth()
])->count();
```

---

## 🔔 Notification Management

### Create Notifications

```php
use App\Models\Notification;
use App\Models\User;

$user = User::find(1);

// Create notification
Notification::create([
    'user_id' => $user->id,
    'title' => 'New Lead Assigned',
    'message' => 'A new lead has been assigned to you',
    'type' => 'info',
    'entity_type' => 'Lead',
    'entity_id' => 1,
    'action_url' => '/leads/1',
]);

// Mark as read
$notification = Notification::find(1);
$notification->markAsRead();

// Mark as unread
$notification->markAsUnread();

// Check if read
if ($notification->isRead()) {
    // Already read
}
```

### Query Notifications

```php
// Get user's unread notifications
$unread = auth()->user()->getUnreadNotifications();

// Count unread
$count = auth()->user()->getUnreadNotificationsCount();

// Mark all as read
auth()->user()->markAllNotificationsAsRead();

// Get recent notifications
$recent = auth()->user()->notifications()
    ->orderByDesc('created_at')
    ->limit(10)
    ->get();

// By type
$warnings = auth()->user()->notifications()
    ->where('type', 'warning')
    ->get();
```

---

## ⚙️ Settings Management

### Get/Set User Settings

```php
use App\Models\Setting;

// Get a setting
$theme = Setting::get(auth()->id(), 'theme', 'light');

// Set a setting
Setting::set(auth()->id(), 'theme', 'dark');

// Boolean setting
Setting::set(auth()->id(), 'notifications_enabled', true, 'boolean');

// JSON setting
Setting::set(auth()->id(), 'preferences', [
    'timezone' => 'UTC',
    'language' => 'en',
], 'json');

// Get JSON setting
$prefs = Setting::get(auth()->id(), 'preferences', []);
```

---

## 📝 Activity Logging

### Log Activities

```php
use App\Models\ActivityLog;

// Log a creation
ActivityLog::create([
    'action' => 'created',
    'entity_type' => Lead::class,
    'entity_id' => $lead->id,
    'description' => "Created lead: {$lead->name}",
    'new_values' => $lead->toArray(),
    'user_id' => auth()->id(),
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);

// Log an update with changes
$oldValues = $lead->getOriginal();
ActivityLog::create([
    'action' => 'updated',
    'entity_type' => Lead::class,
    'entity_id' => $lead->id,
    'description' => "Updated lead category from {$oldValues['category']} to {$lead->category}",
    'old_values' => $oldValues,
    'new_values' => $lead->toArray(),
    'user_id' => auth()->id(),
]);

// Log a deletion
ActivityLog::create([
    'action' => 'deleted',
    'entity_type' => Customer::class,
    'entity_id' => $customer->id,
    'description' => "Deleted customer: {$customer->name}",
    'old_values' => $customer->toArray(),
    'user_id' => auth()->id(),
]);
```

---

## 🔄 Eager Loading & Performance

### Prevent N+1 Queries

```php
// BAD - N+1 query problem
$leads = Lead::all();
foreach ($leads as $lead) {
    echo $lead->customer->name; // Extra query per lead!
}

// GOOD - Eager load relationships
$leads = Lead::with('customer', 'assignedTo', 'notes')->get();
foreach ($leads as $lead) {
    echo $lead->customer->name; // No extra queries
}

// Nested relationships
$leads = Lead::with([
    'customer',
    'deals.customer',
    'followups.assignedTo',
    'notes.createdBy'
])->get();

// Conditional loading
$leads = Lead::with([
    'customer' => function ($query) {
        $query->where('status', 'active');
    }
])->get();
```

### Lazy Loading

```php
// Load later if needed
$lead = Lead::find(1);
$customer = $lead->customer; // Loads on access

// Check if already loaded
if ($lead->relationLoaded('customer')) {
    // Already loaded
}

// Load only if not loaded
$lead->loadMissing('customer', 'notes');
```

---

## 🐛 Debugging

### Check Query

```php
// See raw SQL
$query = Lead::where('category', 'Confirm');
echo $query->toSql();
// SELECT * FROM leads WHERE category = ?

// Get query bindings
echo json_encode($query->getBindings());
// ["Confirm"]

// Execute and debug
DB::listen(function ($query) {
    echo $query->sql;
    echo $query->time;
});
```

### Count Records

```bash
php artisan tinker

# Quick stats
>>> Lead::count()           // Total leads
>>> Customer::count()       # Total customers
>>> Deal::count()           # Total deals
>>> User::count()           # Total users
>>> Role::count()           # Total roles
>>> Permission::count()     # Total permissions
```

---

## 🔄 Migrations Workflow

### Creating Migrations

```bash
# Create new migration
php artisan make:migration add_status_to_leads

# Create with model
php artisan make:model Invoice -m

# View status
php artisan migrate:status
```

### Rollback

```bash
# Undo last batch
php artisan migrate:rollback

# Undo specific number of steps
php artisan migrate:rollback --step=3

# Rollback all
php artisan migrate:reset

# Refresh (reset + migrate)
php artisan migrate:refresh

# Refresh with seed
php artisan migrate:refresh --seed
```

---

## 📈 Database Optimization

### Add Indexes for Frequently Queried Columns

```php
// In migration, after column definition:
$table->index('email');
$table->index(['customer_id', 'created_at']);
$table->unique('email');
$table->fullText('description'); // Full-text search
```

### Archive Old Data

```php
// Move old activity logs to archive
ActivityLog::where('created_at', '<', now()->subMonths(12))
    ->delete(); // Or move to archive table

// Same for notifications
Notification::where('created_at', '<', now()->subMonths(6))
    ->delete();
```

---

**Last Updated**: February 26, 2026
**Laravel Version**: 12.x
**ORM**: Eloquent
