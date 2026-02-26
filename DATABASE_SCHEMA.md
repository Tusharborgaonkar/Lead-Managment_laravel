# Database Schema Design

## 📊 Overview

The Lead Management CRM database is designed to manage customer relationships, sales leads, deals, and business interactions. The schema follows Laravel conventions with Eloquent ORM support.

---

## 🗂️ Core Tables

### 1. **users**
Stores application user accounts with role-based access control.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | User ID |
| `name` | VARCHAR | NOT NULL | User full name |
| `email` | VARCHAR | UNIQUE, NOT NULL | User email |
| `password` | VARCHAR | NOT NULL | Hashed password |
| `phone` | VARCHAR | NULLABLE | Phone number |
| `department` | VARCHAR | NULLABLE | Department/team |
| `role_id` | BIGINT FK | NULLABLE | References roles.id |
| `is_active` | BOOLEAN | DEFAULT true | Account active status |
| `avatar` | VARCHAR | NULLABLE | Avatar/profile image |
| `email_verified_at` | TIMESTAMP | NULLABLE | Email verification date |
| `remember_token` | VARCHAR | NULLABLE | "Remember me" token |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |

**Relationships**:
- Has one `Role`
- Has many `Leads` (assigned_to)
- Has many `Deals` (owner)
- Has many `Followups` (assigned_to)
- Has many `Notifications`
- Has many `ActivityLogs`
- Has many `Settings`

**Sample Data**:
```
Admin User (admin@leadmanagement.com)
Manager (manager@leadmanagement.com)
John Doe (john.doe@leadmanagement.com)
Jane Smith (jane.smith@leadmanagement.com)
Bob Wilson (bob.wilson@leadmanagement.com)
Support Team (support@leadmanagement.com)
```

---

### 2. **roles**
Defines user roles for access control.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Role ID |
| `name` | VARCHAR | UNIQUE, NOT NULL | Role name |
| `slug` | VARCHAR | UNIQUE, NOT NULL | URL-friendly slug |
| `description` | TEXT | NULLABLE | Role description |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |

**Predefined Roles**:
1. **Admin** (`admin`) - Full system access
2. **Manager** (`manager`) - Team oversight and reporting
3. **Sales Representative** (`sales-rep`) - Lead and deal management
4. **Support** (`support`) - Customer service support

**Relationships**:
- Has many `Users`
- Has many `Permissions` (through role_has_permissions)

---

### 3. **permissions**
Defines granular access permissions.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Permission ID |
| `name` | VARCHAR | UNIQUE, NOT NULL | Permission name |
| `slug` | VARCHAR | UNIQUE, NOT NULL | URL-friendly slug |
| `description` | TEXT | NULLABLE | Permission description |
| `group` | VARCHAR | NULLABLE | Permission category |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |

**Permission Groups**:
- `leads` - Lead management
- `customers` - Customer management
- `deals` - Deal management
- `followups` - Follow-up management
- `activity` - Activity logging
- `notifications` - Notification handling
- `dashboard` - Dashboard access
- `settings` - Settings management
- `users` - User management

**Relationships**:
- Has many `Roles` (through role_has_permissions)

---

### 4. **role_has_permissions**
Junction table for role-permission many-to-many relationship.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `role_id` | BIGINT FK | PK | References roles.id |
| `permission_id` | BIGINT FK | PK | References permissions.id |

**Composite Primary Key**: (`role_id`, `permission_id`)

---

## 📋 Core Entity Tables

### 5. **customers**
Stores customer/company information.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Customer ID |
| `name` | VARCHAR | NOT NULL | Customer name |
| `email` | VARCHAR | UNIQUE, NOT NULL | Email address |
| `company` | VARCHAR | NULLABLE | Company name |
| `phone` | VARCHAR | NULLABLE | Primary phone |
| `phone_alt` | VARCHAR | NULLABLE | Alternative phone |
| `group` | VARCHAR | NULLABLE | Customer group (Millennials, Gen Z, Gen X) |
| `status` | ENUM | DEFAULT 'active' | active \| inactive |
| `total_spent` | DECIMAL(12,2) | DEFAULT 0 | Total purchase amount |
| `total_orders` | INT | DEFAULT 0 | Number of orders |
| `rating` | DECIMAL(3,1) | DEFAULT 0 | Customer rating (0-5) |
| `notes` | TEXT | NULLABLE | Internal notes |
| `avatar_color` | VARCHAR | DEFAULT 'indigo' | Avatar color for UI |
| `created_by` | BIGINT FK | NULLABLE | References users.id |
| `updated_by` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes**: email, status, created_at

**Relationships**:
- Has many `Leads`
- Has many `Deals`
- Has many `Followups`
- Has many `Notes`
- Has many `ActivityLogs`
- Created by `User`
- Updated by `User`

---

### 6. **leads**
Stores sales leads and prospects.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Lead ID |
| `name` | VARCHAR | NOT NULL | Lead name/person name |
| `email` | VARCHAR | NULLABLE | Email address |
| `phone` | VARCHAR | NULLABLE | Phone number |
| `company` | VARCHAR | NULLABLE | Company name |
| `source` | ENUM | DEFAULT 'Website' | Website \| Referral \| Social Media \| Cold Call \| WhatsApp \| Events |
| `category` | ENUM | DEFAULT 'Pending' | Not Interested \| Followup \| Pending \| Confirm |
| `value` | DECIMAL(12,2) | NULLABLE | Estimated lead value |
| `customer_id` | BIGINT FK | NULLABLE | References customers.id |
| `has_notes` | BOOLEAN | DEFAULT false | Has associated notes |
| `notes_count` | INT | DEFAULT 0 | Count of notes |
| `description` | TEXT | NULLABLE | Lead description |
| `followup_date` | TIMESTAMP | NULLABLE | Schedule follow-up date/time |
| `avatar_color` | VARCHAR | DEFAULT 'indigo' | Avatar color for UI |
| `assigned_to` | BIGINT FK | NULLABLE | References users.id (sales rep) |
| `created_by` | BIGINT FK | NULLABLE | References users.id |
| `updated_by` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes**: source, category, customer_id, assigned_to, created_at

**Relationships**:
- Belongs to `Customer`
- Belongs to `User` (assigned_to)
- Has many `Deals`
- Has many `Followups`
- Has many `Notes`
- Has many `ActivityLogs`

**Example Data**:
```
Sarah Johnson - Acme Corp - Not Interested - $12,500
Ana Petrova - GreenLeaf Bio - Not Interested - $9,200
Michael Chen - TechCorp Global - Followup - $15,000
Emma Wilson - Stellar Marketing - Pending - $8,800
Zoe Miller - Z-Space Labs - Confirm - $22,400
```

---

### 7. **deals**
Stores sales deals and pipeline stages.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Deal ID |
| `title` | VARCHAR | NOT NULL | Deal title/name |
| `description` | TEXT | NULLABLE | Deal details |
| `value` | DECIMAL(12,2) | DEFAULT 0 | Deal amount |
| `stage` | ENUM | DEFAULT 'Open' | Open \| Won \| Lost |
| `probability` | INT | DEFAULT 0 | Win probability (0-100%) |
| `lead_id` | BIGINT FK | NULLABLE | References leads.id |
| `customer_id` | BIGINT FK | NULLABLE | References customers.id |
| `expected_close_date` | DATE | NULLABLE | Expected close date |
| `actual_close_date` | DATE | NULLABLE | Actual close date |
| `owner_id` | BIGINT FK | NULLABLE | References users.id |
| `created_by` | BIGINT FK | NULLABLE | References users.id |
| `updated_by` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes**: stage, lead_id, customer_id, owner_id, created_at

**Relationships**:
- Belongs to `Lead`
- Belongs to `Customer`
- Belongs to `User` (owner)
- Has many `Followups`
- Has many `Notes`
- Has many `ActivityLogs`

**Dashboard Metrics**:
- Total deals: 42
- Open deals: 15
- Won deals: 20
- Lost deals: 7

---

### 8. **followups**
Manages follow-up tasks and scheduling.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Follow-up ID |
| `title` | VARCHAR | NOT NULL | Follow-up task title |
| `description` | TEXT | NULLABLE | Task details |
| `type` | ENUM | DEFAULT 'Call' | Call \| Email \| Meeting \| WhatsApp \| SMS \| Other |
| `scheduled_at` | TIMESTAMP | NOT NULL | Scheduled date/time |
| `completed_at` | TIMESTAMP | NULLABLE | Completion date/time |
| `status` | ENUM | DEFAULT 'Pending' | Pending \| Completed \| Cancelled |
| `lead_id` | BIGINT FK | NULLABLE | References leads.id |
| `customer_id` | BIGINT FK | NULLABLE | References customers.id |
| `deal_id` | BIGINT FK | NULLABLE | References deals.id |
| `assigned_to` | BIGINT FK | NOT NULL | References users.id |
| `created_by` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes**: scheduled_at, status, assigned_to, created_at

**Relationships**:
- Belongs to `Lead`
- Belongs to `Customer`
- Belongs to `Deal`
- Belongs to `User` (assigned_to)
- Has many `Notes`

**Views**:
- List view (upcoming)
- Calendar view
- All follow-ups (historical)

---

### 9. **notes**
Stores comments and notes on entities.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Note ID |
| `content` | TEXT | NOT NULL | Note text content |
| `category` | VARCHAR | NULLABLE | Note category |
| `lead_id` | BIGINT FK | NULLABLE | References leads.id |
| `customer_id` | BIGINT FK | NULLABLE | References customers.id |
| `deal_id` | BIGINT FK | NULLABLE | References deals.id |
| `followup_id` | BIGINT FK | NULLABLE | References followups.id |
| `created_by` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Last update timestamp |
| `deleted_at` | TIMESTAMP | NULLABLE | Soft delete timestamp |

**Indexes**: lead_id, customer_id, deal_id, followup_id, created_at

**Relationships**:
- Belongs to `Lead`
- Belongs to `Customer`
- Belongs to `Deal`
- Belongs to `Followup`
- Created by `User`

---

## 🔍 Audit & Tracking Tables

### 10. **activity_logs**
Comprehensive audit trail of all system changes.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Log ID |
| `action` | VARCHAR | NOT NULL | created \| updated \| deleted |
| `entity_type` | VARCHAR | NOT NULL | Model class name |
| `entity_id` | BIGINT | NOT NULL | ID of modified entity |
| `description` | TEXT | NULLABLE | Human-readable description |
| `old_values` | JSON | NULLABLE | Previous values |
| `new_values` | JSON | NULLABLE | New values |
| `ip_address` | VARCHAR | NULLABLE | User's IP address |
| `user_agent` | VARCHAR | NULLABLE | Browser/User-Agent |
| `user_id` | BIGINT FK | NULLABLE | References users.id |
| `created_at` | TIMESTAMP | | Log timestamp |
| `updated_at` | TIMESTAMP | | Update timestamp |

**Indexes**: entity_type, entity_id, user_id, created_at

**Use Cases**:
- Track all lead modifications
- Monitor customer updates
- Log deal stage changes
- Record user actions
- Compliance and audit trails

---

### 11. **notifications**
User notifications and alerts.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Notification ID |
| `title` | VARCHAR | NOT NULL | Notification title |
| `message` | TEXT | NOT NULL | Notification message |
| `type` | VARCHAR | DEFAULT 'info' | info \| warning \| success \| error |
| `action_url` | VARCHAR | NULLABLE | clickable URL |
| `entity_type` | VARCHAR | NULLABLE | Related entity type |
| `entity_id` | BIGINT | NULLABLE | Related entity ID |
| `user_id` | BIGINT FK | NOT NULL | References users.id |
| `read_at` | TIMESTAMP | NULLABLE | Read timestamp (null = unread) |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Update timestamp |

**Indexes**: user_id, read_at, created_at

**Types**:
- info - General information
- warning - Warning alerts
- success - Successful operations
- error - Error messages

**Triggers**:
- Follow-up reminders
- Deal stage changes
- Lead assignment
- Completion tasks

---

### 12. **settings**
User-specific preferences and configurations.

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Setting ID |
| `user_id` | BIGINT FK | NOT NULL | References users.id |
| `key` | VARCHAR | NOT NULL | Setting key name |
| `value` | TEXT | NULLABLE | Setting value |
| `type` | VARCHAR | DEFAULT 'string' | string \| boolean \| json |
| `created_at` | TIMESTAMP | | Creation timestamp |
| `updated_at` | TIMESTAMP | | Update timestamp |

**Unique Constraint**: (user_id, key)

**Example Settings**:
- `notification_email` - Email notifications enabled
- `notification_sound` - Sound notifications
- `theme` - UI theme preference
- `language` - Preferred language
- `items_per_page` - Pagination setting
- `timezone` - User timezone

---

## 📊 Database Statistics

### Expected Data Scale

```
Users:           10-50 users
Customers:       100-5,000 customers
Leads:           1,000-100,000 leads
Deals:           500-50,000 deals
Follow-ups:      5,000-500,000 follow-ups
Notes:           10,000-1,000,000 notes
Notifications:   100,000-10,000,000 records
Activity Logs:   1,000,000-100,000,000 records
```

### Index Strategy

**High Priority**:
- `users` (email)
- `customers` (email, status)
- `leads` (customer_id, assigned_to, created_at, source, category)
- `deals` (lead_id, customer_id, stage, created_at)
- `followups` (assigned_to, scheduled_at, status)
- `notifications` (user_id, read_at)
- `activity_logs` (entity_type, entity_id, user_id, created_at)

---

## 🔐 Data Integrity

### Cascade Delete Rules

**Hard Delete**:
- User deletion doesn't cascade (set created_by, updated_by to NULL)

**Soft Delete** (Preserve data):
- `Customers` - has soft deletes
- `Leads` - has soft deletes
- `Deals` - has soft deletes
- `Followups` - cascade delete (if parent deleted)
- `Notes` - cascade delete (if parent deleted)

### Foreign Key Constraints

All foreign keys include:
- `CONSTRAINT` for referential integrity
- `ON DELETE SET NULL` for optional relationships
- `ON DELETE CASCADE` for dependent child records

---

## 🔄 Sample Data

### User Seeding

| Email | Name | Role | Department | Phone |
|-------|------|------|-----------|-------|
| admin@leadmanagement.com | Admin User | Admin | Management | +1-555-0100 |
| manager@leadmanagement.com | Sales Manager | Manager | Sales | +1-555-0101 |
| john.doe@leadmanagement.com | John Doe | Sales Rep | Sales | +1-555-0102 |
| jane.smith@leadmanagement.com | Jane Smith | Sales Rep | Sales | +1-555-0103 |
| bob.wilson@leadmanagement.com | Bob Wilson | Sales Rep | Sales | +1-555-0104 |
| support@leadmanagement.com | Support Team | Support | Support | +1-555-0105 |

**Default Password**: `password` (change on first login in production)

### Role Permissions Matrix

| Role | Leads | Customers | Deals | Follow-ups | Users |
|------|-------|-----------|-------|-----------|-------|
| Admin | All | All | All | All | All |
| Manager | All | All | All | All | View/Create |
| Sales Rep | All | All | All | All | - |
| Support | View | All | View | All | - |

---

## 🚀 Migration & Setup

### Running Migrations

```bash
# Run all migrations
php artisan migrate

# Run with seed data
php artisan migrate --seed

# Only seed
php artisan db:seed
```

### Creating Migrations

```bash
# Create new migration
php artisan make:migration create_table_name

# Create with model
php artisan make:model Entity -m
```

### Resetting Database

```bash
# Hard reset (dangerous in production)
php artisan migrate:reset
php artisan migrate --seed

# Rollback last batch
php artisan migrate:rollback
```

---

## 📜 SQL Reference

### List All Tables
```sql
SELECT name FROM sqlite_master WHERE type='table';
```

### View Table Schema
```sql
PRAGMA table_info(table_name);
```

### Count Records
```sql
SELECT 
    'users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'customers', COUNT(*) FROM customers
UNION ALL
SELECT 'leads', COUNT(*) FROM leads
UNION ALL
SELECT 'deals', COUNT(*) FROM deals
...
```

### Find Orphaned Records
```sql
-- Leads without customers
SELECT id FROM leads WHERE customer_id IS NOT NULL 
  AND customer_id NOT IN (SELECT id FROM customers);
```

---

## 🔗 Entity Relationships Diagram

```
users (1) ──────→ (many) leads
  │                  │
  ├─→ (many) deals   ├─→ (many) followups
  │                  ├─→ (many) notes
  ├─→ (many) followups │
  │                  └─→ (many) activity_logs
  ├─→ (many) notifications
  │
  └─→ (1) roles ──→ (many) permissions

customers (1) ──→ (many) leads
    │                └─→ (many) deals
    ├─→ (many) deals    ├─→ (many) followups
    │                   └─→ (many) notes
    ├─→ (many) followups
    ├─→ (many) notes
    └─→ (many) activity_logs

deals (1) ──→ (many) followups
  └─→ (many) notes

followups (1) ──→ (many) notes
```

---

**Last Updated**: February 26, 2026
**Database System**: SQLite (default) / MySQL (production)
**Laravel Version**: 12.x
