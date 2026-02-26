# Database Setup & Installation Guide

## 🚀 Complete Database Setup

This guide walks through setting up the entire database for the Lead Management CRM from scratch.

---

## Step 1️⃣: Verify Environment

### Check Prerequisites

```bash
# Verify PHP version (need 8.2+)
php -v

# Verify Laravel installation
php artisan --version

# Check .env file exists
ls -la | grep .env
```

### Configure .env Database

Edit `.env` file:

```env
# SQLite (Development - Default)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# MySQL (Production)
#DB_CONNECTION=mysql
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=lead_management
#DB_USERNAME=root
#DB_PASSWORD=
```

---

## Step 2️⃣: Create Database

### For SQLite (Default)

```bash
# Database file is created automatically by migrations
# Just ensure the directory exists
mkdir -p database
```

### For MySQL

```bash
# Create database manually
mysql -u root -p
> CREATE DATABASE lead_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> EXIT;
```

---

## Step 3️⃣: Run Migrations

### Execute All Migrations

```bash
# Run fresh migrations
php artisan migrate

# Expected output:
# Creating: roles
# Created:  roles
# Creating: permissions
# ...
# 12 tables created
```

### Verify Migrations

```bash
# Check migration status
php artisan migrate:status

# Should show all migrations as "Ran"
```

### Check Tables Created

```bash
# Using Tinker
php artisan tinker

# Check if tables exist
>>> Schema::hasTable('users')
=> true

>>> Schema::hasTable('leads')
=> true

>>> Schema::getTableListing()
=> [
     "cache",
     "sessions",
     "users",
     "roles",
     "permissions",
     "role_has_permissions",
     "customers",
     "leads",
     "deals",
     "followups",
     "notes",
     "activity_logs",
     "notifications",
     "settings"
   ]

>>> exit
```

---

## Step 4️⃣: Seed Data

### Seed in Order

```bash
# Seed all data (includes roles, permissions, users)
php artisan db:seed

# Expected output:
# Seeding: PermissionSeeder
# Seeding: RoleSeeder
# Seeding: RolePermissionSeeder
# Seeding: UserSeeder
```

### Seed Individual Tables

```bash
# Just permissions
php artisan db:seed --class=PermissionSeeder

# Just roles
php artisan db:seed --class=RoleSeeder

# Just users
php artisan db:seed --class=UserSeeder
```

### Verify Seeded Data

```bash
php artisan tinker

# Check users created
>>> App\Models\User::count()
=> 6

>>> App\Models\User::all()
=> Collection with 6 items

# Check roles
>>> App\Models\Role::count()
=> 4

# Check permissions
>>> App\Models\Permission::count()
=> 25

# Check assignments
>>> App\Models\Role::with('permissions')->get()

# Exit
>>> exit
```

---

## Step 5️⃣: Login Credentials

### Default Test Users

After seeding, these users are available:

#### Admin Account
- **Email**: `admin@leadmanagement.com`
- **Password**: `password`
- **Role**: Admin
- **Access**: Full system access

#### Manager Account
- **Email**: `manager@leadmanagement.com`
- **Password**: `password`
- **Role**: Manager
- **Access**: Team oversight, reporting

#### Sales Representatives
- **Email**: `john.doe@leadmanagement.com`
- **Password**: `password`
- **Role**: Sales Rep

- **Email**: `jane.smith@leadmanagement.com`
- **Password**: `password`
- **Role**: Sales Rep

- **Email**: `bob.wilson@leadmanagement.com`
- **Password**: `password`
- **Role**: Sales Rep

#### Support Account
- **Email**: `support@leadmanagement.com`
- **Password**: `password`
- **Role**: Support

---

## Step 6️⃣: Start Development Server

### Run Application

```bash
# Start Laravel server
php artisan serve

# Output:
# Laravel development server started: http://127.0.0.1:8000

# In another terminal, start Vite:
npm run dev
```

### Access Application

- **URL**: http://localhost:8000
- **Test Login**: Use any credentials from Step 5
- **Default**: admin@leadmanagement.com / password

---

## 📋 Database Operations

### View Database Contents

```bash
php artisan tinker

# Count records in each table
>>> echo "Users: " . App\Models\User::count();
Users: 6

>>> echo "Roles: " . App\Models\Role::count();
Roles: 4

>>> echo "Permissions: " . App\Models\Permission::count();
Permissions: 25

>>> echo "Customers: " . App\Models\Customer::count();
Customers: 0

>>> echo "Leads: " . App\Models\Lead::count();
Leads: 0

# View user details
>>> App\Models\User::first()
=> User {
  id: 1,
  name: "Admin User",
  email: "admin@leadmanagement.com",
  role_id: 1,
  is_active: true,
}

# View roles and permissions
>>> App\Models\Role::with('permissions')->first()

>>> exit
```

### Reset Database

```bash
# WARNING: This deletes all data!

# Option 1: Rollback all migrations and reseed
php artisan migrate:reset
php artisan migrate --seed

# Option 2: Refresh (rollback + migrate + seed)
php artisan migrate:refresh --seed

# Option 3: Fresh (drop all + migrate + seed)
php artisan migrate:fresh --seed
```

---

## 🔐 Security Setup

### Change Default Passwords

After first login, change the default password:

```bash
# Using Tinker
php artisan tinker

# Change admin password
>>> $user = App\Models\User::where('email', 'admin@leadmanagement.com')->first();
>>> $user->password = bcrypt('your_new_password');
>>> $user->save();

# Change all passwords
>>> App\Models\User::each(function($user) {
    $user->password = bcrypt('new_password_' . $user->id);
    $user->save();
});

>>> exit
```

### Update .env for Production

```env
# Change these for production
APP_NAME="Lead Management"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:xxxxx (generate with: php artisan key:generate)

# Database
DB_CONNECTION=mysql
DB_HOST=your_host
DB_DATABASE=lead_management
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Mail configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

---

## 🔄 Regular Maintenance

### Backup Database

```bash
# SQLite backup
cp database/database.sqlite database/database.sqlite.backup.$(date +%Y%m%d)

# MySQL backup
mysqldump -u root -p lead_management > backup_$(date +%Y%m%d).sql
```

### Optimize Database

```bash
# Clear old activity logs (older than 1 year)
php artisan tinker
>>> use App\Models\ActivityLog;
>>> ActivityLog::where('created_at', '<', now()->subYear())->delete();
>>> exit

# Clear old notifications (older than 6 months)
>>> use App\Models\Notification;
>>> Notification::where('created_at', '<', now()->subMonths(6))->delete();
>>> exit
```

### Monitor Database

```bash
# Check database size
ls -lh database/database.sqlite

# Count records
php artisan tinker
>>> DB::table('activity_logs')->count()
>>> DB::table('notifications')->count()
>>> exit
```

---

## 🆘 Troubleshooting

### Issue: Migration Failed

```
SQLSTATE[HY000]: General error: 1 cannot open shared object file
```

**Solution**:
```bash
# Check database file permissions
chmod 644 database/database.sqlite
chmod 755 database

# Or reset database
php artisan migrate:reset
php artisan migrate
```

### Issue: Foreign Key Constraint Fails

```
SQLSTATE[HY000]: General error: 1030 Got error 1 from storage engine
```

**Solution**:
```bash
# Enable foreign keys (SQLite)
php artisan tinker
>>> DB::statement('PRAGMA foreign_keys=ON');
>>> exit

# Or disable for testing
>>> DB::statement('PRAGMA foreign_keys=OFF');
```

### Issue: Seeder Not Working

```
Class does not exist: Database\Seeders\PermissionSeeder
```

**Solution**:
```bash
# Regenerate autoloader
composer dump-autoload

# Then try seeding again
php artisan db:seed
```

### Issue: User Cannot Login

**Solution**:
```bash
# Reset admin password
php artisan tinker
>>> $user = App\Models\User::where('email', 'admin@leadmanagement.com')->first();
>>> $user->update(['password' => bcrypt('password')]);
>>> exit

# Try login again with: admin@leadmanagement.com / password
```

---

## 📊 Database Schema Validation

### Check All Tables Exist

```bash
php artisan tinker

>>> $tables = [
    'users', 'roles', 'permissions', 'role_has_permissions',
    'customers', 'leads', 'deals', 'followups', 'notes',
    'activity_logs', 'notifications', 'settings'
];

>>> foreach ($tables as $table) {
    echo $table . ": " . (Schema::hasTable($table) ? "✓" : "✗") . "\n";
}

>>> exit
```

### Export Database Schema

```bash
# SQLite
sqlite3 database/database.sqlite ".schema" > schema.sql

# MySQL
mysqldump --no-data -u root -p lead_management > schema.sql
```

---

## 🚀 Production Deployment

### Pre-Deployment Checklist

```bash
# 1. Update .env for production
nano .env  # Set APP_ENV=production, APP_DEBUG=false

# 2. Run migrations
php artisan migrate --force

# 3. Seeds (if needed for production data)
php artisan db:seed --class=RoleSeeder --class=PermissionSeeder

# 4. Cache configuration
php artisan config:cache

# 5. Cache routes
php artisan route:cache

# 6. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 7. Backup database before going live
cp database/database.sqlite database/database.sqlite.pre-launch
```

### Monitor After Deployment

```bash
# Check application logs
tail -f storage/logs/laravel.log

# Monitor database
php artisan tinker
>>> DB::connection()->getDatabaseName()
>>> DB::table('users')->count()
```

---

## 📈 Performance Tips

1. **Index Optimization**: Frequently queried columns are indexed
2. **Query Optimization**: Use eager loading with `with()`
3. **Data Archival**: Move old activity logs to archive table
4. **Caching**: Cache user roles and permissions
5. **Connection Pooling**: Use connection pool for high traffic

---

## 📚 Related Documentation

- [Database Schema](DATABASE_SCHEMA.md) - Complete schema details
- [Implementation Guide](DATABASE_IMPLEMENTATION.md) - Code examples
- [Quick Reference](DATABASE_REFERENCE.md) - Fast lookup guide
- [Main Documentation](DOCUMENTATION.md) - Project overview

---

## ✅ Setup Completion Checklist

- [ ] Environment configured (.env)
- [ ] Database created and connected
- [ ] All migrations run successfully
- [ ] All seeders executed
- [ ] 6 users created with different roles
- [ ] Login credentials verified
- [ ] Application starting without errors
- [ ] Database backup created
- [ ] Ready for development

---

**Setup Date**: February 26, 2026
**Laravel Version**: 12.x
**Database**: SQLite (Development) / MySQL (Production)
**Total Tables**: 12
**Default Users**: 6
