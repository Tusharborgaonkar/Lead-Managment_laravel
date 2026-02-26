<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Followup extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type',
        'scheduled_at',
        'completed_at',
        'status',
        'lead_id',
        'customer_id',
        'deal_id',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class , 'assigned_to');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'Pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'Completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'Cancelled';
    }

    public function markCompleted(): void
    {
        $this->update([
            'status' => 'Completed',
            'completed_at' => now(),
        ]);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'Cancelled');
    }
}
