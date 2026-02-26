# Database Entity-Relationship Diagram (ERD)

## 🗺️ Complete Database Map

```
┌─────────────────────────────────────────────────────────────────────────┐
│                      LEAD MANAGEMENT CRM DATABASE                        │
└─────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│                         ACCESS CONTROL LAYER                              │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                            │
│  ┌──────────────┐                                    ┌──────────────┐    │
│  │    roles     │ ◄────────── has many ─────────────►│   users      │    │
│  ├──────────────┤ (1)                            (many)├──────────────┤    │
│  │ • id (PK)    │                                    │ • id (PK)    │    │
│  │ • name       │                                    │ • email      │    │
│  │ • slug       │                                    │ • password   │    │
│  │ • description│                                    │ • role_id    │    │
│  │ • created_at │                                    │ • is_active  │    │
│  │ • updated_at │                                    │ • created_at │    │
│  └──────────────┘                                    └──────────────┘    │
│         ▲                                                     ▲            │
│         │                                                     │            │
│         │ (many)                                              │            │
│         │                                                     │ (created_by)
│  ┌──────────────────────────┐                                │            │
│  │ role_has_permissions     │                                │            │
│  ├──────────────────────────┤                                │            │
│  │ • role_id (FK/PK)        │                                │            │
│  │ • permission_id (FK/PK)  │                                │            │
│  └──────────────────────────┘                                │            │
│         ▲                                                     │            │
│         │                                                     │            │
│         │ (many)                                              │            │
│  ┌──────────────┐                                    ┌────────────────┐  │
│  │ permissions  │                                    │ activity_logs  │  │
│  ├──────────────┤                                    ├────────────────┤  │
│  │ • id (PK)    │                                    │ • id (PK)      │  │
│  │ • name       │                                    │ • action       │  │
│  │ • slug       │                                    │ • entity_type  │  │
│  │ • description│                                    │ • entity_id    │  │
│  │ • group      │                                    │ • old_values   │  │
│  │ • created_at │                                    │ • new_values   │  │
│  │ • updated_at │                                    │ • user_id (FK) │  │
│  └──────────────┘                                    │ • created_at   │  │
│                                                      └────────────────┘  │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│                    NOTIFICATION & SETTINGS LAYER                          │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                            │
│  ┌────────────────┐                    ┌────────────────┐                │
│  │ notifications  │                    │   settings     │                │
│  ├────────────────┤                    ├────────────────┤                │
│  │ • id (PK)      │                    │ • id (PK)      │                │
│  │ • title        │                    │ • user_id (FK) │                │
│  │ • message      │                    │ • key          │                │
│  │ • type         │                    │ • value        │                │
│  │ • entity_type  │                    │ • type         │                │
│  │ • entity_id    │                    │ • created_at   │                │
│  │ • user_id (FK) │                    │ • updated_at   │                │
│  │ • read_at      │                    └────────────────┘                │
│  │ • created_at   │                            ▲                         │
│  └────────────────┘                            │                         │
│         ▲                                       │ (many)                  │
│         │                                       │                         │
│         │ (many)                                │                         │
│         │                                   users                         │
│         └────────────── has many ────────────────┘                       │
│                                                                            │
└──────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────┐
│                     CORE BUSINESS ENTITIES LAYER                           │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                            │
│  ┌──────────────┐              ┌──────────────┐                          │
│  │  customers   │ ◄─ (1:many)─►│entities      │                          │
│  ├──────────────┤              │              │                          │
│  │ • id (PK)    │              │ ┌─ leads ─┐  │                          │
│  │ • email      │              │ │ • id    │  │                          │
│  │ • name       │              │ │ • source│  │                          │
│  │ • company    │              │ │ • categ │  │                          │
│  │ • phone      │              │ │ • value │  │                          │
│  │ • status     │              │ └─────────┘  │                          │
│  │ • total_spent│              │              │                          │
│  │ • rating     │              │ ┌─ deals ─┐  │                          │
│  │ • notes      │              │ │ • stage │  │                          │
│  │ • created_by │              │ │ • value │  │                          │
│  │ • updated_by │              │ │ • probab│  │                          │
│  │ • created_at │              │ └─────────┘  │                          │
│  │ • deleted_at │              │              │                          │
│  └──────────────┘              │ ┌followups─┐ │                          │
│         ▲                       │ │ • schedu│ │                          │
│         │                       │ │ • status│ │                          │
│         │                       │ │ • type  │ │                          │
│         │                       │ └─────────┘ │                          │
│    (created_by)                │              │                          │
│         │                       │ ┌─ notes ──┐│                          │
│         ├──────────────────────►│ │ • content││                          │
│         │                       │ │ • categ  ││                          │
│         │                       │ └──────────┘│                          │
│         │                       │              │                          │
│         │                       └──────────────┘                          │
│         │                              ▲ ▲ ▲ ▲                           │
│         │                              │ │ │ │                           │
│         │                              │ │ │ └── (1:many)               │
│         │                              │ │ │       (entity relations)    │
│         │                              │ │ └────── (1:many)             │
│         │                              │ └────────  (1:many)            │
│         │                              └──────────  (1:many)            │
│         │                                                                │
│         │                                                                │
│  ┌──────────────┐         ASSIGNMENT & TRACKING        ┌────────────┐  │
│  │     users    │                                       │  followups │  │
│  │              │ ◄─ assigned to / owner ─────────────►│            │  │
│  │(assigned_to) │  ─ created_by ─────────────────      │            │  │
│  │(owner_id)    │         ▲         ▲         ▲         │            │  │
│  │(created_by)  │         │         │         │         └────────────┘  │
│  │(updated_by)  │         │         │         │              ▲          │
│  └──────────────┘         │         │         │              │          │
│         ▲                  │         │         │              │ (1:many) │
│         │                  │         │         │              │          │
│         │                  │         │         └──────... notes ...      │
│         │                  │         │                       │           │
│         │                  │         │                       ├─► notes   │
│         │                  │         │                       │           │
│    (assigned_to)       (created_by)  │                       │           │
│         │                  │        (updated_by)             │           │
│         │                  │         │                       │ (created) │
│         │                  │         │                       │           │
│  ┌──────────────┐    ┌──────────────┐      ┌──────────────┐ │          │
│  │     leads    │◄───┤     deals    │◄─────┤   followups  │ │          │
│  ├──────────────┤(1) │ (1)         ├──────►│             │ │          │
│  │ • id (PK)    │    └──────────────┘ (many)│             │ │          │
│  │ • email      │    │ • id (PK)    │      │             │ │          │
│  │ • name       │    │ • title      │      │ • title     │ │          │
│  │ • company    │    │ • value      │      │ • type      │ │          │
│  │ • phone      │    │ • stage      │      │ • scheduled │ │          │
│  │ • source     │    │ • probability│      │ • status    │ │          │
│  │ • category   │    │ • lead_id(FK)│      │ • lead_id(FK)│ │          │
│  │ • value      │    │ • customer(FK)      │ • deal_id(FK)│ │          │
│  │ • customer(FK)    │ • owner_id(FK)      │ • assgnd(FK)│ │          │
│  │ • notes_count│    │ • created_by │      │ • created_at│ │          │
│  │ • follow_date│    │ • updated_by │      │ • deleted_at│ └───────┐  │
│  │ • assigned_to│    │ • created_at │      │             │         │  │
│  │ • created_by │    │ • deleted_at │      └──────────────┘         │  │
│  │ • updated_by │    └──────────────┘                                │  │
│  │ • created_at │         ▲ ▲                                        │  │
│  │ • deleted_at │         │ │                                        │  │
│  └──────────────┘         │ └─── (1:many) relationships             │  │
│                           │      for notes & followups              │  │
│                           │                                         │  │
│                      (1:many)                                       │  │
│                           │                                         │  │
│                    ┌──────────────┐                          ┌──────┴──┐
│                    │    notes     │                          │ activity│
│                    ├──────────────┤                          │  _logs  │
│                    │ • id (PK)    │                          │(via_PK) │
│                    │ • content    │                          └─────────┘
│                    │ • category   │
│                    │ • lead_id    │
│                    │ • customer_id│
│                    │ • deal_id    │
│                    │ • followup_id│
│                    │ • created_by │
│                    │ • created_at │
│                    │ • deleted_at │
│                    └──────────────┘
│
└──────────────────────────────────────────────────────────────────────────┘

Legend:
─────
PK   = Primary Key
FK   = Foreign Key
(1)  = One-to-one
(1:many) = One-to-many relationship
►    = Relationship direction
◄►   = Bidirectional relationship
```

---

## 🔄 Relationship Flow

### User → Leads
```
User (1) ─── assigned_to ──► Leads (many)
User (1) ─── created_by ───► Leads (many)
User (1) ─── updated_by ───► Leads (many)
```

### User → Deals
```
User (1) ─── owner_id ──────► Deals (many)
User (1) ─── created_by ───► Deals (many)
User (1) ─── updated_by ───► Deals (many)
```

### Customer → Entities
```
Customer (1) ──► Leads (many)
            ──► Deals (many)
            ──► Followups (many)
            ──► Notes (many)
```

### Lead → Related
```
Lead (1) ──► Customer (1) [optional]
        ──► Deals (many)
        ──► Followups (many)
        ──► Notes (many)
        ──► ActivityLogs (many)
        ──► Assignee: User (1)
```

### Deal → Related
```
Deal (1) ──► Lead (1) [optional]
        ──► Customer (1) [optional]
        ──► Owner: User (1) [optional]
        ──► Followups (many)
        ──► Notes (many)
        ──► ActivityLogs (many)
```

### Followup → Related
```
Followup (1) ──► Lead (1) [optional]
            ──► Customer (1) [optional]
            ──► Deal (1) [optional]
            ──► AssignedTo: User (1)
            ──► Notes (many)
```

---

## 🎯 Data Cardinality

| Relationship | Type | Cascade |
|---|---|---|
| User → Role | 1:1 | SET NULL |
| User → Leads (assigned) | 1:many | SET NULL |
| User → Deals (owner) | 1:many | SET NULL |
| User → Followups | 1:many | SET NULL |
| User → Notifications | 1:many | CASCADE |
| User → Settings | 1:many | CASCADE |
| Customer → Leads | 1:many | SET NULL |
| Customer → Deals | 1:many | SET NULL |
| Customer → Followups | 1:many | CASCADE |
| Customer → Notes | 1:many | CASCADE |
| Lead → Deals | 1:many | SET NULL |
| Lead → Followups | 1:many | CASCADE |
| Lead → Notes | 1:many | CASCADE |
| Deal → Followups | 1:many | CASCADE |
| Deal → Notes | 1:many | CASCADE |
| Followup → Notes | 1:many | CASCADE |
| Role → Permissions | many:many | CASCADE |

---

## 📊 Table Statistics

### Record Counts by Role
```
Admin Users:        1
Managers:          1
Sales Reps:        3
Support Staff:     1
─────────────────────
Total Users:       6

Roles:             4
Permissions:      25+
Role Assignments: 100+ (via junction)
```

### Expected Data Growth
```
Users:           10-50
Customers:       100-5,000
Leads:          1,000-100,000
Deals:            500-50,000
Followups:      5,000-500,000
Notes:         10,000-1,000,000
Activity Logs: 1,000,000+
Notifications: 100,000-10,000,000
```

---

## 🔐 Data Dependencies

### Hard Dependencies (Cannot Delete)
- Cannot delete role if users assigned
- Cannot delete customer if leads exist
- Cannot delete lead if deals exist
- Cannot delete user if they created records

### Soft Dependencies (Can Delete - Cascade)
- Delete customer → Delete related followups
- Delete lead → Delete related followups
- Delete deal → Delete related followups
- Delete followup → Delete related notes
- Delete user → Delete notifications & settings

---

## 🎓 Example Data Flows

### New Lead Flow
```
1. Create Customer
   ├─ customer_id
   ├─ created_by: User.id
   └─ created_at

2. Create Lead
   ├─ customer_id: Customer.id
   ├─ assigned_to: User.id
   ├─ created_by: User.id
   └─ created_at

3. Add Notes
   ├─ lead_id: Lead.id
   ├─ created_by: User.id
   └─ created_at

4. Create Deal
   ├─ lead_id: Lead.id
   ├─ customer_id: Customer.id
   ├─ owner_id: User.id
   ├─ created_by: User.id
   └─ created_at

5. Schedule Followup
   ├─ lead_id: Lead.id
   ├─ customer_id: Customer.id
   ├─ deal_id: Deal.id
   ├─ assigned_to: User.id
   └─ scheduled_at

6. Log Activity
   ├─ action: 'created'
   ├─ entity_type: Lead::class
   ├─ entity_id: Lead.id
   ├─ user_id: User.id
   └─ created_at

7. Send Notification
   ├─ user_id: User.id
   ├─ entity_type: 'Lead'
   ├─ entity_id: Lead.id
   └─ created_at
```

---

## 🔍 Querying Pattern Examples

### Get User's Workload
```
User.id ──► Leads (assigned_to) ──► Count
         ──► Deals (owner_id) ──────► Count
         ──► Followups (assigned_to) ► Count (Pending)
         ──► Notifications ──────────► Count (Unread)
```

### Get Customer's History
```
Customer.id ──► Leads ──────────► Count
           ──► Deals ──────────► Count & Value
           ──► Followups ──────► Count & Status
           ──► Notes ──────────► All notes
           ──► ActivityLogs ───► Complete history
```

### Get Company Pipeline
```
Company ──► Customers (many)
       ├──► Leads (via customers)
       │    ├─► Deals
       │    └─► Followups
       └──► Total potential revenue
           └─► Open opportunities
```

---

## 📈 Index Strategy

### Primary Indexes
- `users.email` - Fast authentication
- `customers.email` - Customer lookup
- `leads.customer_id` - Customer relations
- `deals.stage` - Pipeline filtering
- `followups.scheduled_at` - Calendar views
- `notifications.user_id` - User's notifications
- `activity_logs.created_at` - Timeline queries

### Composite Indexes
- `(leads.customer_id, leads.created_at)` - Recent customer leads
- `(deals.stage, deals.owner_id)` - User's deals by stage
- `(followups.assigned_to, followups.status)` - User's tasks
- `(activity_logs.entity_type, activity_logs.entity_id)` - Entity history

---

**Last Updated**: February 26, 2026
**Database Version**: 1.0
**Total Entities**: 12 tables
**Total Relationships**: 30+ relationships
