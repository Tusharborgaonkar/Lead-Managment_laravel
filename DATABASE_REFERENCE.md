# Database Quick Reference & Cheat Sheet

## 📚 Table Summary

| Table | Purpose | Records | Key Fields |
|-------|---------|---------|-----------|
| `users` | User accounts & auth | 1-10K | email, role_id, is_active |
| `roles` | User roles | 4-10 | slug |
| `permissions` | Fine-grained access | 25+ | slug, group |
| `role_has_permissions` | Role-permission mapping | 100+ | role_id, permission_id |
| `customers` | Company/account data | 100-5K | email, status |
| `leads` | Sales prospects | 1K-100K | source, category, assigned_to |
| `deals` | Sales pipeline | 500-50K | stage, owner_id |
| `followups` | Task scheduling | 5K-500K | scheduled_at, assigned_to |
| `notes` | Comments & notes | 10K-1M | lead_id, customer_id |
| `activity_logs` | Audit trail | 1M-100M | entity_type, entity_id, user_id |
| `notifications` | User alerts | 100K-10M | user_id, read_at |
| `settings` | User preferences | 100-10K | user_id, key |

---

## 🔑 Primary Keys & Unique Constraints

| Table | Primary Key | Unique Keys |
|-------|------------|-------------|
| `users` | id | email |
| `roles` | id | name, slug |
| `permissions` | id | name, slug |
| `role_has_permissions` | (role_id, permission_id) | - |
| `customers` | id | email |
| `leads` | id | - |
| `deals` | id | - |
| `followups` | id | - |
| `notes` | id | - |
| `activity_logs` | id | - |
| `notifications` | id | - |
| `settings` | id | (user_id, key) |

---

## 🔗 Foreign Keys

| Table | Field | References | On Delete |
|-------|-------|-----------|-----------|
| `users` | role_id | roles.id | SET NULL |
| `customers` | created_by | users.id | SET NULL |
| `customers` | updated_by | users.id | SET NULL |
| `leads` | customer_id | customers.id | SET NULL |
| `leads` | assigned_to | users.id | SET NULL |
| `leads` | created_by | users.id | SET NULL |
| `leads` | updated_by | users.id | SET NULL |
| `deals` | lead_id | leads.id | SET NULL |
| `deals` | customer_id | customers.id | SET NULL |
| `deals` | owner_id | users.id | SET NULL |
| `deals` | created_by | users.id | SET NULL |
| `deals` | updated_by | users.id | SET NULL |
| `followups` | lead_id | leads.id | CASCADE |
| `followups` | customer_id | customers.id | CASCADE |
| `followups` | deal_id | deals.id | CASCADE |
| `followups` | assigned_to | users.id | CASCADE |
| `followups` | created_by | users.id | SET NULL |
| `notes` | lead_id | leads.id | CASCADE |
| `notes` | customer_id | customers.id | CASCADE |
| `notes` | deal_id | deals.id | CASCADE |
| `notes` | followup_id | followups.id | CASCADE |
| `notes` | created_by | users.id | SET NULL |
| `activity_logs` | user_id | users.id | SET NULL |
| `notifications` | user_id | users.id | CASCADE |
| `settings` | user_id | users.id | CASCADE |
| `role_has_permissions` | role_id | roles.id | CASCADE |
| `role_has_permissions` | permission_id | permissions.id | CASCADE |

---

## 📊 Enumeration Values

### Lead.source
- `Website`
- `Referral`
- `Social Media`
- `Cold Call`
- `WhatsApp`
- `Events`

### Lead.category
- `Not Interested`
- `Followup`
- `Pending`
- `Confirm`

### Deal.stage
- `Open`
- `Won`
- `Lost`

### Followup.type
- `Call`
- `Email`
- `Meeting`
- `WhatsApp`
- `SMS`
- `Other`

### Followup.status
- `Pending`
- `Completed`
- `Cancelled`

### Customer.status
- `active`
- `inactive`

### Notification.type
- `info`
- `warning`
- `success`
- `error`

### Setting.type
- `string` (default)
- `boolean`
- `json`

### ActivityLog.action
- `created`
- `updated`
- `deleted`

---

## 🎯 Common Queries

### Find Records

```sql
-- Get user with role
SELECT u.*, r.name as role_name FROM users u
LEFT JOIN roles r ON u.role_id = r.id
WHERE u.id = 1;

-- Get leads with customer info
SELECT l.*, c.name as customer_name FROM leads l
LEFT JOIN customers c ON l.customer_id = c.id
WHERE l.category = 'Confirm';

-- Get this week's followups
SELECT * FROM followups
WHERE scheduled_at >= datetime('now', '-7 days')
  AND status = 'Pending'
ORDER BY scheduled_at ASC;

-- Get deals by stage with values
SELECT stage, COUNT(*) as count, SUM(value) as total
FROM deals
GROUP BY stage;
```

### Join Queries

```sql
-- Get all leads with customer and assigned user
SELECT 
    l.*,
    c.name as customer_name,
    u.name as assigned_to_name
FROM leads l
LEFT JOIN customers c ON l.customer_id = c.id
LEFT JOIN users u ON l.assigned_to = u.id;

-- Get user with roles and permissions
SELECT 
    u.*,
    r.name as role_name,
    GROUP_CONCAT(p.name) as permissions
FROM users u
LEFT JOIN roles r ON u.role_id = r.id
LEFT JOIN role_has_permissions rhp ON r.id = rhp.role_id
LEFT JOIN permissions p ON rhp.permission_id = p.id
GROUP BY u.id;
```

### Aggregations

```sql
-- Sales metrics
SELECT 
    COUNT(DISTINCT l.id) as total_leads,
    COUNT(DISTINCT c.id) as total_customers,
    COUNT(DISTINCT d.id) as total_deals,
    SUM(CASE WHEN d.stage = 'Won' THEN d.value ELSE 0 END) as revenue,
    SUM(CASE WHEN d.stage = 'Open' THEN d.value ELSE 0 END) as pipeline
FROM leads l
LEFT JOIN customers c ON l.customer_id = c.id
LEFT JOIN deals d ON d.lead_id = l.id OR d.customer_id = c.id;

-- User performance
SELECT 
    u.name,
    COUNT(l.id) as leads_assigned,
    COUNT(d.id) as deals_owned,
    SUM(d.value) as deal_value
FROM users u
LEFT JOIN leads l ON u.id = l.assigned_to
LEFT JOIN deals d ON u.id = d.owner_id
WHERE u.role_id IN (SELECT id FROM roles WHERE slug = 'sales-rep')
GROUP BY u.id
ORDER BY deal_value DESC;
```

---

## 🔍 Index Performance Tips

### Recommended Indexes

```sql
-- User queries
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_role_id ON users(role_id);
CREATE INDEX idx_users_is_active ON users(is_active);

-- Lead queries
CREATE INDEX idx_leads_customer_id ON leads(customer_id);
CREATE INDEX idx_leads_assigned_to ON leads(assigned_to);
CREATE INDEX idx_leads_source ON leads(source);
CREATE INDEX idx_leads_category ON leads(category);
CREATE INDEX idx_leads_created_at ON leads(created_at);

-- Deal queries
CREATE INDEX idx_deals_stage ON deals(stage);
CREATE INDEX idx_deals_lead_id ON deals(lead_id);
CREATE INDEX idx_deals_customer_id ON deals(customer_id);
CREATE INDEX idx_deals_owner_id ON deals(owner_id);

-- Followup queries
CREATE INDEX idx_followups_scheduled_at ON followups(scheduled_at);
CREATE INDEX idx_followups_assigned_to ON followups(assigned_to);
CREATE INDEX idx_followups_status ON followups(status);

-- Activity queries
CREATE INDEX idx_activity_logs_entity ON activity_logs(entity_type, entity_id);
CREATE INDEX idx_activity_logs_user_id ON activity_logs(user_id);
CREATE INDEX idx_activity_logs_created_at ON activity_logs(created_at);

-- Notification queries
CREATE INDEX idx_notifications_user_id ON notifications(user_id);
CREATE INDEX idx_notifications_read_at ON notifications(read_at);
```

---

## 🗂️ Eloquent Model Relationships

### Complete Relationship Map

```
User
  └─ belongsTo(Role)
  ├─ hasMany(Lead, 'assigned_to')
  ├─ hasMany(Lead, 'created_by')
  ├─ hasMany(Deal, 'owner_id')
  ├─ hasMany(Deal, 'created_by')
  ├─ hasMany(Followup, 'assigned_to')
  ├─ hasMany(Followup, 'created_by')
  ├─ hasMany(Notification)
  ├─ hasMany(ActivityLog)
  └─ hasMany(Setting)

Role
  ├─ hasMany(User)
  └─ belongsToMany(Permission, 'role_has_permissions')

Permission
  └─ belongsToMany(Role, 'role_has_permissions')

Customer
  ├─ hasMany(Lead)
  ├─ hasMany(Deal)
  ├─ hasMany(Followup)
  ├─ hasMany(Note)
  └─ hasMany(ActivityLog, 'entity_id')

Lead
  ├─ belongsTo(Customer)
  ├─ belongsTo(User, 'assigned_to')
  ├─ hasMany(Deal)
  ├─ hasMany(Followup)
  ├─ hasMany(Note)
  └─ hasMany(ActivityLog, 'entity_id')

Deal
  ├─ belongsTo(Lead)
  ├─ belongsTo(Customer)
  ├─ belongsTo(User, 'owner_id')
  ├─ hasMany(Followup)
  ├─ hasMany(Note)
  └─ hasMany(ActivityLog, 'entity_id')

Followup
  ├─ belongsTo(Lead)
  ├─ belongsTo(Customer)
  ├─ belongsTo(Deal)
  ├─ belongsTo(User, 'assigned_to')
  └─ hasMany(Note)

Note
  ├─ belongsTo(Lead)
  ├─ belongsTo(Customer)
  ├─ belongsTo(Deal)
  ├─ belongsTo(Followup)
  └─ belongsTo(User, 'created_by')

Notification
  └─ belongsTo(User)

Setting
  └─ belongsTo(User)

ActivityLog
  └─ belongsTo(User)
```

---

## 🎓 Common Code Patterns

### Get Dashboard Statistics

```php
$stats = [
    'total_leads' => Lead::count(),
    'total_customers' => Customer::count(),
    'total_deals' => Deal::count(),
    'open_deals' => Deal::where('stage', 'Open')->count(),
    'won_deals' => Deal::where('stage', 'Won')->count(),
    'lost_deals' => Deal::where('stage', 'Lost')->count(),
    'revenue' => Deal::where('stage', 'Won')->sum('value'),
    'pipeline' => Deal::where('stage', 'Open')->sum('value'),
];
```

### Get User's Workload

```php
$user = auth()->user();
$workload = [
    'assigned_leads' => $user->leads()->count(),
    'deals' => $user->deals()->where('stage', 'Open')->count(),
    'pending_followups' => $user->followups()
        ->where('status', 'Pending')
        ->count(),
    'unread_notifications' => $user->getUnreadNotificationsCount(),
];
```

### Create Complete Lead

```php
// Create customer
$customer = Customer::create([/*...*/]);

// Create lead
$lead = Lead::create([
    'name' => 'John',
    'customer_id' => $customer->id,
    'assigned_to' => auth()->id(),
]);

// Add notes
$lead->notes()->create([
    'content' => 'Initial contact made',
    'created_by' => auth()->id(),
]);

// Create followup
$lead->followups()->create([
    'title' => 'Send proposal',
    'scheduled_at' => now()->addDays(3),
    'assigned_to' => auth()->id(),
]);

// Log activity
ActivityLog::create([
    'action' => 'created',
    'entity_type' => Lead::class,
    'entity_id' => $lead->id,
    'user_id' => auth()->id(),
]);
```

### Update Deal with Validation

```php
$deal = Deal::find(1);

$deal->update([
    'stage' => 'Won',
    'actual_close_date' => now(),
    'probability' => 100,
]);

// Log the change
ActivityLog::create([
    'action' => 'updated',
    'entity_type' => Deal::class,
    'entity_id' => $deal->id,
    'description' => "Deal won with value: {$deal->value}",
    'old_values' => ['stage' => 'Open'],
    'new_values' => ['stage' => 'Won'],
    'user_id' => auth()->id(),
]);

// Notify owner
Notification::create([
    'user_id' => $deal->owner_id,
    'title' => 'Deal Won',
    'message' => "Deal '{$deal->title}' has been marked as won",
    'entity_type' => 'Deal',
    'entity_id' => $deal->id,
]);
```

---

## ⚡ Performance Optimization Checklist

- ✅ Add indexes on frequently queried columns
- ✅ Use eager loading with `with()` to prevent N+1
- ✅ Implement pagination for large result sets
- ✅ Use `select()` to fetch only needed columns
- ✅ Consider caching frequently accessed data
- ✅ Archive very old activity logs (>1 year)
- ✅ Use database connection pooling for high traffic
- ✅ Monitor slow queries with `DB::listen()`
- ✅ Use raw queries for complex aggregations
- ✅ Implement data cleanup jobs for soft deletes

---

## 🐛 Troubleshooting

### Issue: Unknown Column Error

```
SQLSTATE[42S22]: Column not found: 1054 Unknown column
```

**Solution**:
```bash
# Run migrations
php artisan migrate

# Check table structure
php artisan tinker
>>> Schema::getColumnListing('leads');
```

### Issue: Foreign Key Constraint Failed

```
SQLSTATE[HY000]: General error: 1030 Got error
```

**Solution**:
- Ensure parent record exists before creating child
- Check cascade delete flags in migration
- Disable foreign keys temporarily for testing:
```php
DB::statement('PRAGMA foreign_keys=off');
```

### Issue: Soft Delete Not Working

**Solution**:
```php
// Model must have SoftDeletes trait
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model {
    use SoftDeletes;
}

// Then can soft delete
$lead->delete(); // Soft delete
$lead->restore(); // Restore
$lead->forceDelete(); // Hard delete
```

---

## 📖 Additional Resources

- [Laravel Eloquent Docs](https://laravel.com/docs/eloquent)
- [Database Migrations](https://laravel.com/docs/migrations)
- [Query Builder](https://laravel.com/docs/queries)
- [Relationships](https://laravel.com/docs/eloquent-relationships)

---

**Last Updated**: February 26, 2026
**Version**: 1.0
