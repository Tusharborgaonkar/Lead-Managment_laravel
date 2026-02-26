# Lead Management CRM - Project Documentation

## 📋 Table of Contents

1. [Project Overview](#project-overview)
2. [Technology Stack](#technology-stack)
3. [Project Structure](#project-structure)
4. [Core Features](#core-features)
5. [System Architecture](#system-architecture)
6. [Database Design](#database-design)
7. [API Routes](#api-routes)
8. [Controllers & Logic](#controllers--logic)
9. [Frontend Components](#frontend-components)
10. [Authentication & Authorization](#authentication--authorization)
11. [Configuration & Setup](#configuration--setup)
12. [Development Workflow](#development-workflow)

---

## Project Overview

**Lead Management CRM** is a comprehensive Customer Relationship Management (CRM) system built with Laravel 12. It's designed to help sales teams manage leads, customers, deals, follow-ups, and track customer interactions efficiently.

### Key Objectives
- Centralized lead management and tracking
- Customer relationship monitoring
- Deal pipeline visualization
- Follow-up scheduling and notifications
- Activity logging and audit trails
- User role-based access control
- Real-time notifications

### Target Users
- Sales managers
- Sales representatives
- Business development teams
- Customer success managers

---

## Technology Stack

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **PHP Version**: ^8.2
- **Database**: SQLite (default, configurable)
- **Session/Cache**: File-based storage
- **Mail**: SMTP configured in `config/mail.php`
- **Authentication**: Laravel's built-in auth + Sanctum (API tokens)

### Frontend
- **Build Tool**: Vite
- **CSS Framework**: Tailwind CSS 4.0
- **Template Engine**: Blade (Laravel's templating)
- **JS Framework**: Vanilla JavaScript (Alpine.js compatible)
- **HTTP Client**: Axios
- **Package Manager**: npm

### Development Tools
- **Code Quality**: Laravel Pint (PHP linting)
- **Testing**: PHPUnit 11.5
- **Fake Data**: Faker (for testing)
- **Live Reload**: Vite dev server
- **CLI Tools**: Laravel Tinker, Sail (Docker)
- **Concurrency**: Concurrently (for dev server management)

---

## Project Structure

```
lead-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Business logic controllers
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── ForgotPasswordController.php
│   │   │   ├── LeadController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── DealController.php
│   │   │   ├── FollowupController.php
│   │   │   ├── NotificationController.php
│   │   │   ├── ActivityLogController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SettingsController.php
│   │   │   ├── UserController.php
│   │   │   └── Controller.php (base)
│   │   ├── Middleware/           # Request middleware
│   │   └── Requests/             # Form validation requests
│   └── Providers/
│       ├── AppServiceProvider.php
│       └── AuthServiceProvider.php
├── bootstrap/
│   ├── app.php                   # Bootstrap application
│   ├── providers.php             # Service providers
│   └── cache/                    # Cache files
├── config/
│   ├── app.php                   # Application configuration
│   ├── auth.php                  # Authentication settings
│   ├── cache.php                 # Cache driver config
│   ├── database.php              # Database connections
│   ├── mail.php                  # Mail configuration
│   ├── permissions.php           # Role-based permissions
│   ├── session.php               # Session settings
│   └── ...                       # Other configs
├── database/
│   ├── migrations/               # Schema migrations
│   │   ├── *_create_sessions_table.php
│   │   └── *_create_cache_table.php
│   ├── factories/                # Model factories
│   └── seeders/                  # Database seeders
├── public/
│   ├── index.php                 # Application entry point
│   ├── robots.txt
│   ├── css/
│   │   ├── app.css              # Global styles
│   │   └── crm-table-overrides.css
│   └── js/
│       ├── app.js               # Built JS (from Vite)
│       └── crm-tabulator.js
├── resources/
│   ├── css/
│   │   └── app.css              # Source CSS
│   ├── js/
│   │   ├── app.js               # Main app JS
│   │   └── bootstrap.js          # Bootstrap JS
│   └── views/                    # Blade templates
│       ├── welcome.blade.php
│       ├── auth/                # Authentication views
│       ├── dashboard/           # Dashboard views
│       ├── leads/               # Lead management views
│       ├── customers/           # Customer views
│       ├── deals/               # Deal views
│       ├── followups/           # Follow-up views
│       ├── notifications/       # Notification views
│       ├── activity/            # Activity log views
│       ├── users/               # User management views
│       ├── settings/            # Settings views
│       ├── layouts/             # Layout templates
│       └── partials/            # Reusable components
├── routes/
│   ├── web.php                  # Web routes
│   ├── api.php                  # API routes
│   └── console.php              # Console commands
├── storage/
│   ├── app/                     # Application storage
│   │   ├── public/              # Public files
│   │   └── private/             # Private files
│   ├── framework/               # Framework storage
│   │   ├── cache/
│   │   ├── sessions/
│   │   ├── testing/
│   │   └── views/
│   └── logs/                    # Application logs
├── tests/
│   ├── TestCase.php
│   ├── Feature/                 # Feature tests
│   └── Unit/                    # Unit tests
├── vendor/                      # Composer dependencies
├── artisan                      # Laravel CLI
├── composer.json               # PHP dependencies
├── package.json                # Node.js dependencies
├── phpunit.xml                 # PHPUnit config
├── vite.config.js              # Vite configuration
└── README.md                   # Default readme
```

---

## Core Features

### 1. **Lead Management**
- Create, read, update, delete leads
- Lead categorization (Not Interested, Followup, Pending, Confirm)
- Lead tracking with status and value
- Lead source tracking (Website, Referral, Social Media, Cold Call, WhatsApp, Events)
- Lead notes and history
- Bulk operations

**Stats Tracked**:
- Total leads count
- Leads by category
- Leads with notes
- Lead value estimation

### 2. **Customer Management**
- Customer database with detailed profiles
- Customer contact information
- Company association
- Customer group classification (Millennials, Gen Z, Gen X)
- Order history and spending tracking
- Customer ratings and reviews
- Status management (Active/Inactive)

**Metrics**:
- Total customers
- Active customers count
- Average customer value
- Customer retention rate
- Spending trends

### 3. **Deal Pipeline**
- Deal creation and categorization
- Deal stages (Open, Won, Lost)
- Deal value tracking
- Sales pipeline visualization
- Conversion funnel analytics
- Deal-to-customer linking
- Probability assessment

**Deal Metrics**:
- Total deals
- Open deals
- Won deals
- Lost deals

### 4. **Follow-up Management**
- Schedule follow-ups with leads/customers
- Multiple view modes:
  - List view
  - Calendar view
  - All follow-ups
- Follow-up task tracking
- Due date and time management
- Deletion/completion marking

### 5. **Activity Logging**
- Comprehensive audit trail
- Track all user actions:
  - Lead modifications
  - Customer updates
  - Deal changes
  - Follow-up activities
- Timestamp recording
- User attribution

### 6. **Notifications**
- Real-time notifications
- Follow-up reminders
- Deal stage changes
- New lead assignments
- Mark as read/unread
- Bulk notification management (Mark all as read)
- Notification deletion

### 7. **User & Role Management**
- User account management
- Role-based access control (RBAC)
- User creation, update, deletion
- Role assignment
- Custom role definitions
- Permission management

**User Roles** (configured in `config/permissions.php`):
- Admin (Full access)
- Manager (Team oversight)
- Sales Rep (Lead management)
- Support (Customer service)

### 8. **Dashboard & Analytics**
- Sales target tracking (current vs. goal)
- Revenue overview (12-month chart)
- Leads by source (pie chart)
- Conversion funnel visualization
- Hot leads ranking
- Today's follow-ups
- Recent leads and customers
- Key performance indicators (KPIs)

### 9. **Settings Management**
- User profile settings
- Email notification preferences
- Display preferences
- Account security settings
- Export data options

---

## System Architecture

### Request Flow

```
┌─────────────────────────────────────────────────────────────┐
│                     User Browser                             │
└────────────────────┬────────────────────────────────────────┘
                     │ HTTP Request
                     ▼
┌─────────────────────────────────────────────────────────────┐
│              Laravel Application (./public)                  │
│  ┌────────────────────────────────────────────────────────┐ │
│  │  Router (routes/web.php, routes/api.php)              │ │
│  │  - Matches HTTP method & path to controller action    │ │
│  └────────────────────┬─────────────────────────────────┘ │
│                       │                                     │
│  ┌────────────────────▼─────────────────────────────────┐ │
│  │  Middleware Stack                                    │ │
│  │  - Authentication/Authorization                      │ │
│  │  - CSRF protection                                   │ │
│  │  - Custom middleware                                 │ │
│  └────────────────────┬─────────────────────────────────┘ │
│                       │                                     │
│  ┌────────────────────▼─────────────────────────────────┐ │
│  │  Controller (app/Http/Controllers/)                  │ │
│  │  - Business logic                                    │ │
│  │  - Request validation                                │ │
│  │  - Database queries                                  │ │
│  └────────────────────┬─────────────────────────────────┘ │
│                       │                                     │
│  ┌────────────────────▼─────────────────────────────────┐ │
│  │  Service/Model Layer                                 │ │
│  │  - Database interactions                             │ │
│  │  - Business operations                               │ │
│  └────────────────────┬─────────────────────────────────┘ │
│                       │                                     │
│  ┌────────────────────▼─────────────────────────────────┐ │
│  │  Response                                            │ │
│  │  - HTML (Blade template)                             │ │
│  │  - JSON (API)                                        │ │
│  └────────────────────────────────────────────────────┘ │
└────────────────────┬────────────────────────────────────────┘
                     │ HTTP Response
                     ▼
┌─────────────────────────────────────────────────────────────┐
│                     User Browser                             │
│  - Render HTML/JSON                                         │
│  - Execute JavaScript                                       │
│  - Display to User                                          │
└─────────────────────────────────────────────────────────────┘
```

### Key Components

**Controllers**: Handle HTTP requests and responses
**Blade Templates**: Server-side rendering for HTML
**Routes**: URL mapping to controller actions
**Middleware**: Request/response filtering and processing
**Queries**: Database interactions (Eloquent ORM)

---

## Database Design

### Current Database Structure

The project uses migrations to manage database schema:

```sql
-- Sessions Table (2026_02_26_064416_create_sessions_table.php)
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED,
    ip_address VARCHAR(45),
    user_agent LONGTEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Cache Table (2026_02_26_065005_create_cache_table.php)
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Expected Models (To Be Implemented)

Based on the controllers and views, the following Eloquent models should exist:

```php
// Models to implement:
- User (authentication)
- Lead (lead management)
- Customer (customer database)
- Deal (sales deals)
- Followup (follow-up scheduling)
- Notification (user notifications)
- ActivityLog (audit trail)
- Role (role-based access)
- Permission (role permissions)
```

### Data Relationships

```
User
├── owns → many Leads
├── owns → many Deals
├── owns → many Followups
├── has → many Notifications
├── has → many ActivityLogs
└── has → many Roles

Lead
├── belongs to → Customer (optional)
├── has → many Followups
├── has → many Notes/Comments
├── has → many ActivityLogs
└── has → Deals

Customer
├── has → many Leads
├── has → many Deals
├── has → many Orders
└── has → many ActivityLogs

Deal
├── belongs to → Lead
├── belongs to → Customer
├── has → many Followups
└── has → many ActivityLogs

Followup
├── belongs to → Lead/Customer
├── belongs to → User
└── has → ActivityLog
```

---

## API Routes

### Authentication Routes

```
GET     /login                      - Show login form
POST    /login                      - Process login
GET     /register                   - Show registration form
POST    /register                   - Process registration
GET     /forgot-password            - Show forgot password form
POST    /forgot-password            - Send password reset email
POST    /logout                     - Logout user
```

### Leads Management

```
GET     /leads                      - List all leads
POST    /leads                      - Create new lead
GET     /leads/{id}                 - Show lead details
PUT     /leads/{id}                 - Update lead
DELETE  /leads/{id}                 - Delete lead
GET     /leads/{id}/edit            - Show edit form
```

### Customers Management

```
GET     /customers                  - List all customers
POST    /customers                  - Create new customer
GET     /customers/{id}             - Show customer details
PUT     /customers/{id}             - Update customer
DELETE  /customers/{id}             - Delete customer
GET     /customers/{id}/edit        - Show edit form
GET     /customers/create           - Show creation form
```

### Deals Management

```
GET     /deals                      - List all deals
POST    /deals                      - Create new deal
GET     /deals/{id}                 - Show deal details
PUT     /deals/{id}                 - Update deal
DELETE  /deals/{id}                 - Delete deal
GET     /deals/{id}/edit            - Show edit form
```

### Follow-ups Management

```
GET     /followups                  - List upcoming follow-ups
GET     /followups/all              - List all follow-ups
GET     /followups/calendar         - Calendar view
DELETE  /followups/{id}             - Delete follow-up
```

### Notifications

```
GET     /notifications              - List notifications
POST    /notifications/mark-all     - Mark all as read
POST    /notifications/{id}/mark-read   - Mark single as read
DELETE  /notifications/{id}         - Delete notification
```

### Activity Log

```
GET     /activity                   - View activity log
```

### Settings

```
GET     /settings                   - Show settings page
PUT     /settings                   - Update settings
```

### Users & Roles

```
GET     /users                      - List users
POST    /users                      - Create user
PUT     /users/{id}                 - Update user
DELETE  /users/{id}                 - Delete user
GET     /users/roles                - Show roles page
POST    /users/roles                - Create role
DELETE  /users/roles/{id}           - Delete role
```

### Dashboard

```
GET     /                           - Redirect to dashboard
GET     /dashboard                  - Show dashboard
```

---

## Controllers & Logic

### Controller Overview

#### **LeadController** (`app/Http/Controllers/LeadController.php`)
Manages lead CRUD operations and lead-specific features.

**Methods**:
- `index()` - Displays list of leads with statistics
  - **Returns**: Lead collection with stats (total, by category, with notes)
  - **Data**: 21 sample leads with various statuses
  - **Stats**: Total leads, categorization, notes tracking

- `show(id)` - Display single lead details
- `create()` - Show lead creation form
- `store(Request)` - Save new lead
- `edit(id)` - Show lead edit form
- `update(id, Request)` - Update lead information
- `destroy(id)` - Delete lead

**Lead Object Structure**:
```php
{
    id: int,
    name: string,
    initials: string (2 chars),
    color: string (indigo|purple|emerald|amber|rose),
    company: string,
    email: string,
    source: string (Website|Referral|Social Media|WhatsApp|Cold Call),
    category: string (Not Interested|Followup|Pending|Confirm),
    value: string (formatted $),
    has_notes: boolean,
    created_at: date,
    followup_date: timestamp|null
}
```

---

#### **CustomerController** (`app/Http/Controllers/CustomerController.php`)
Manages customer database and relationships.

**Methods**:
- `index()` - List all customers with metrics
  - **Returns**: Customer collection with statistics
  - **Stats**: Total, active count, avg value, retention rate, trend
  - **Data**: 8 sample customers

- `show(id)` - Display customer profile
- `create()` - Show customer creation form
- `store(Request)` - Create new customer
- `edit(id)` - Show customer edit form
- `update(id, Request)` - Update customer
- `destroy(id)` - Delete customer

**Customer Object Structure**:
```php
{
    id: int,
    name: string,
    email: string,
    company: string,
    group: string (Millennials|Generation Z|Generation X),
    status: string (active|inactive),
    spent: string (formatted),
    spent_raw: int,
    orders: int,
    rating: float (0-5),
    avatar_color: string
}
```

---

#### **DashboardController** (`app/Http/Controllers/DashboardController.php`)
Provides business intelligence and KPI tracking.

**Methods**:
- `index()` - Display comprehensive dashboard

**Dashboard Sections**:
1. **Key Metrics**
   - Total leads: 128
   - Total customers: 84
   - Total deals: 42
   - Open deals: 15
   - Won deals: 20
   - Lost deals: 7

2. **Recent Activity**
   - 3 recent leads
   - 2 recent customers

3. **Sales Target**
   - Current: $84,200
   - Target: $120,000
   - Progress: 70%

4. **Revenue Overview**
   - 12-month history (Apr - Mar)
   - Monthly values in thousands

5. **Leads by Source** (Pie chart)
   - Website: 32%
   - Referral: 25%
   - Social Media: 20%
   - Cold Call: 12%
   - WhatsApp: 8%
   - Events: 3%

6. **Conversion Funnel**
   - Total Leads: 2,847 (100%)
   - Qualified: 1,245 (44%)
   - Proposal: 562 (20%)
   - Won Deals: 156 (5%)

7. **Hot Leads** (Top 3)
   - TechCorp Global: $12,500 (Score: 95)
   - Stellar Systems: $8,200 (Score: 88)
   - Future Works: $15,000 (Score: 82)

8. **Today's Follow-ups**
   - List of upcoming follow-ups
   - Time and task details

---

#### **FollowupController** (`app/Http/Controllers/FollowupController.php`)
Manages follow-up scheduling and reminders.

**Methods**:
- `index()` - List upcoming follow-ups
- `all()` - List all follow-ups (historical)
- `calendar()` - Calendar view of follow-ups
- `destroy(id)` - Delete/complete follow-up

**Features**:
- Date/time scheduling
- Task description
- Lead/customer association
- Status tracking

---

#### **NotificationController** (`app/Http/Controllers/NotificationController.php`)
Handles user notifications and notifications center.

**Methods**:
- `index()` - List user notifications
- `markAllRead()` - Mark all as read
- `markRead(id)` - Mark single notification as read
- `destroy(id)` - Delete notification

---

#### **DealController** (`app/Http/Controllers/DealController.php`)
Manages sales deals and pipeline.

**Methods**:
- `index()` - List deals
- `show(id)` - Deal details
- `create()` - New deal form
- `store()` - Create deal
- `edit(id)` - Edit form
- `update()` - Update deal
- `destroy(id)` - Delete deal

---

#### **ActivityLogController** (`app/Http/Controllers/ActivityLogController.php`)
Audit trail and activity tracking.

**Methods**:
- `index()` - Display activity log

**Tracked Activities**:
- Lead creation/modification
- Customer updates
- Deal changes
- Follow-up completion
- User actions

---

#### **UserController** (`app/Http/Controllers/UserController.php`)
User and role management.

**Methods**:
- `index()` - List all users
- `store()` - Create user
- `update(id)` - Update user
- `destroy(id)` - Delete user
- `roles()` - Show roles management page
- `storeRole()` - Create new role
- `destroyRole(id)` - Delete role

---

#### **SettingsController** (`app/Http/Controllers/SettingsController.php`)
User settings and preferences.

**Methods**:
- `index()` - Show settings page
- `update()` - Save settings

---

#### **Auth Controllers**

**LoginController**:
- `showLoginForm()` - Display login page
- `login()` - authenticate user
- `logout()` - Log out user

**RegisterController**:
- `showRegistrationForm()` - Display registration page
- `register()` - Create new account

**ForgotPasswordController**:
- `showForgotPasswordForm()` - Show forgot password page
- `sendResetLinkEmail()` - Send password reset email

---

## Frontend Components

### Views Structure

#### **Authentication Views** (`resources/views/auth/`)
- `login.blade.php` - Login form
- `register.blade.php` - Registration form
- `forgot-password.blade.php` - Password reset request
- `reset-password.blade.php` - Password reset form

#### **Dashboard Views** (`resources/views/dashboard/`)
- `index.blade.php` - Main dashboard
  - KPI cards
  - Charts (revenue, funnel, source distribution)
  - Data tables (leads, customers, deals, follow-ups)

#### **Lead Views** (`resources/views/leads/`)
- `index.blade.php` - Lead list with filters and stats
- `show.blade.php` - Lead details page
- `create.blade.php` - Create lead form
- `edit.blade.php` - Edit lead form

#### **Customer Views** (`resources/views/customers/`)
- `index.blade.php` - Customer list
- `show.blade.php` - Customer profile
- `create.blade.php` - Create customer form
- `edit.blade.php` - Edit customer form

#### **Deal Views** (`resources/views/deals/`)
- `index.blade.php` - Deal pipeline
- `show.blade.php` - Deal details
- `create.blade.php` - Create deal form
- `edit.blade.php` - Edit deal form

#### **Follow-up Views** (`resources/views/followups/`)
- `index.blade.php` - Upcoming follow-ups list
- `all.blade.php` - All follow-ups (historical)
- `calendar.blade.php` - Calendar view

#### **User Management Views** (`resources/views/users/`)
- `index.blade.php` - User list
- `roles.blade.php` - Role management

#### **Settings Views** (`resources/views/settings/`)
- `index.blade.php` - User settings form

#### **Activity Log Views** (`resources/views/activity/`)
- `index.blade.php` - Activity log display

#### **Notification Views** (`resources/views/notifications/`)
- `index.blade.php` - Notifications center

#### **Layouts** (`resources/views/layouts/`)
- `app.blade.php` - Main application layout
  - Navigation bar
  - Sidebar menu
  - Footer

#### **Partials** (`resources/views/partials/`)
- `header.blade.php` - Page header
- `sidebar.blade.php` - Navigation sidebar
- `footer.blade.php` - Footer
- `form-fields.blade.php` - Reusable form components

### Frontend Assets

**CSS** (`resources/css/`):
- `app.css` - Global styles compiled by Tailwind
- Public overrides in `public/css/`

**JavaScript** (`resources/js/`):
- `app.js` - Main app entry point
- `bootstrap.js` - Initialize JavaScript
- `crm-tabulator.js` - Table library integration

**Public Assets** (`public/`):
- Pre-built CSS and JS
- Static assets

---

## Authentication & Authorization

### Authentication System

**Method**: Laravel's built-in authentication with Sanctum API tokens

**Flow**:
```
1. User submits email & password
2. LoginController validates credentials
3. User session created (file-based storage)
4. Session token stored in browser cookie
5. Subsequent requests validated via middleware
```

### Authorization System

**Configuration**: `config/permissions.php`

**Roles**:
- **Admin**: Full system access
- **Manager**: Team oversight, reporting
- **Sales Rep**: Lead and deal management
- **Support**: Customer service only

**Middleware Checks**:
- `auth` - Require authenticated user
- `auth:sanctum` - API token authentication
- Custom middleware for role-based access

---

## Configuration & Setup

### Environment Variables (`.env`)

Key configurations:
```env
APP_NAME=Lead Management
APP_ENV=local|production
APP_KEY=                    # Generate with: php artisan key:generate
APP_DEBUG=true|false

DB_CONNECTION=sqlite        # Default database
DB_DATABASE=database.sqlite # SQLite file path

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=

SESSION_DRIVER=file         # Session storage
CACHE_DRIVER=file          # Cache storage
QUEUE_CONNECTION=sync      # Job queue
```

### Configuration Files

**app.php** - Application name, timezone, locale, service providers

**auth.php** - Authentication guards and password reset configuration

**database.php** - Database connections (SQLite, MySQL, PostgreSQL)

**cache.php** - Caching driver and TTL settings

**mail.php** - Email configuration

**session.php** - Session lifetime and storage

**queue.php** - Background job configuration

**permissions.php** - Role and permission definitions

---

## Development Workflow

### Installation

```bash
# 1. Clone repository
git clone <repository-url>
cd Lead-Management_laravel

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Run migrations
php artisan migrate

# 7. Build frontend assets
npm run build
```

### Development Server

**Option 1**: Using built-in dev script
```bash
npm run dev  # Starts Vite dev server (frontend hot reload)
php artisan serve  # In another terminal
```

**Option 2**: Using composer script
```bash
composer run dev  # Runs all services: server, queue, logs, vite
```

**What it does**:
- Laravel server on `http://localhost:8000`
- Vite dev server with hot reload (CSS/JS changes instant)
- Queue listener for background jobs
- Log monitoring with Pail

### Available Commands

```bash
# Artisan (Laravel CLI)
php artisan migrate              # Run database migrations
php artisan tinker              # Interactive shell
php artisan make:controller Name # Generate controller
php artisan make:model Name      # Generate model
php artisan make:migration name  # Generate migration
php artisan config:cache        # Cache config for production

# Composer
composer install                # Install dependencies
composer require package/name    # Add new package
composer update                 # Update dependencies

# npm
npm run dev                     # Start dev server
npm run build                   # Build for production
npm install                     # Install packages

# Testing
php artisan test                # Run PHPUnit tests
./vendor/bin/phpunit           # Direct PHPUnit
composer run test              # Via composer script

# Code Quality
./vendor/bin/pint              # Run Laravel Pint (linting)
./vendor/bin/pint --fix        # Auto-fix style issues
```

### Project Structure Notes

- **Controllers**: All logic in `app/Http/Controllers/`
- **Views**: Blade templates in `resources/views/`
- **Routes**: All routes in `routes/web.php` (currently static/demo)
- **Static Data**: Controllers return hardcoded data (no DB yet)
- **Frontend Build**: Vite builds `resources/` → `public/`

### Frontend Development

**Build process**:
```
resources/css/app.css 
  + Tailwind CSS processing 
  + Vite bundling 
  → public/build/assets/app.css
```

**Hot reload** (on `npm run dev`):
- CSS changes reload instantly
- JS changes reload instantly
- No page refresh needed

### Database Development

**Migrations**:
- Create new: `php artisan make:migration create_table_name`
- Run pending: `php artisan migrate`
- Rollback last: `php artisan migrate:rollback`
- Reset all: `php artisan migrate:reset`

**Models** (to implement):
```bash
php artisan make:model Lead -m  # Create model + migration
php artisan make:model Customer -m
php artisan make:model Deal -m
# etc.
```

**Seeders** (for sample data):
```bash
php artisan make:seeder LeadSeeder
php artisan db:seed              # Run seeders
```

---

## Next Steps / Improvements

### Currently Implemented
✅ Route structure and basic controllers
✅ View templates with Tailwind CSS styling
✅ Dashboard with mock data
✅ Static lead/customer/deal listings

### TODO (Recommended)
- [ ] Create Eloquent models (Lead, Customer, Deal, etc.)
- [ ] Create database migrations
- [ ] Implement actual database queries
- [ ] Add form validation using form requests
- [ ] Implement role-based access control middleware
- [ ] Add API endpoints for AJAX operations
- [ ] Create activity logging system
- [ ] Implement notification system
- [ ] Add email configuration and queue jobs
- [ ] Write unit and feature tests
- [ ] Setup automated backups
- [ ] Add advanced search/filtering
- [ ] Implement batch operations
- [ ] Add export functionality (CSV/PDF)
- [ ] Setup production deployment

---

## Troubleshooting

### Common Issues

**Issue**: Vite assets not loading
```bash
# Solution
npm run build   # Rebuild assets
php artisan optimize:clear  # Clear cache
```

**Issue**: Database locked (SQLite)
```bash
# Solution: Ensure only one process writes to SQLite
# Or switch to MySQL: Update .env DB_CONNECTION=mysql
```

**Issue**: 419 Session expired
```bash
# Solution: Clear session files
rm -rf storage/framework/sessions/*
```

**Issue**: Composer/npm installation slow
```bash
# Use specific version
composer install --no-dev      # Skip dev packages
npm ci                         # Use exact versions from lock file
```

---

## File Size Reference

- **Codebase**: ~50-60 KB (excluding vendor/)
- **Node modules**: ~200 MB
- **Composer packages**: ~100 MB
- **Database** (SQLite): ~50 KB initial

---

## Security Notes

- Change `APP_KEY` before production
- Set `APP_DEBUG=false` in production
- Use environment variables for all secrets
- Enable HTTPS in production
- Implement rate limiting on forms
- Use CSRF token on all forms (Blade: `@csrf`)
- Validate all user inputs

---

## Support & Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [Vite Documentation](https://vitejs.dev)
- [Laravel Community](https://laravel.io)

---

**Last Updated**: February 26, 2026
**Project Version**: 1.0 (Foundation)
**Laravel Version**: 12.x
**PHP Version**: 8.2+
