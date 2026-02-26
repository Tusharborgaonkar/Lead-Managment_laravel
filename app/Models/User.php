<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'department',
        'role_id',
        'is_active',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function createdLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'created_by');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class, 'owner_id');
    }

    public function createdDeals(): HasMany
    {
        return $this->hasMany(Deal::class, 'created_by');
    }

    public function followups(): HasMany
    {
        return $this->hasMany(Followup::class, 'assigned_to');
    }

    public function createdFollowups(): HasMany
    {
        return $this->hasMany(Followup::class, 'created_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    /**
     * Helper Methods
     */
    public function hasRole(string $role): bool
    {
        return $this->role && $this->role->slug === $role;
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        return $this->role && $this->role->hasPermission($permission);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }

    public function getUnreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at')
            ->orderByDesc('created_at')
            ->get();
    }

    public function getUnreadNotificationsCount(): int
    {
        return $this->notifications()
            ->whereNull('read_at')
            ->count();
    }

    public function markAllNotificationsAsRead(): void
    {
        $this->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
