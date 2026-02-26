<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'company',
        'phone',
        'phone_alt',
        'group',
        'status',
        'total_spent',
        'total_orders',
        'rating',
        'notes',
        'avatar_color',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'total_spent' => 'decimal:2',
        'rating' => 'decimal:1',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class , 'updated_by');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class , 'entity_id')
            ->where('entity_type', self::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }
}
