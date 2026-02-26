<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'optional_phone',
        'company',
        'website',
        'source',
        'category',
        'value',
        'customer_id',
        'has_notes',
        'notes_count',
        'description',
        'followup_methods',
        'followup_date',
        'avatar_color',
        'assigned_to',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'has_notes' => 'boolean',
        'followup_methods' => 'array',
        'followup_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    public function getColorAttribute()
    {
        return $this->avatar_color ?: 'indigo';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function followups(): HasMany
    {
        return $this->hasMany(Followup::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class , 'assigned_to');
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
        return $query->where('category', 'Pending');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    public function scopeFilterByCategory($query, $category)
    {
        if ($category === 'notes') {
            return $query->where('has_notes', true);
        }
        return $query->where('category', $category);
    }

    public function scopeFilterBySource($query, $source)
    {
        return $query->where('source', $source);
    }
}
