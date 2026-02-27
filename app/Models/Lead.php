<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'client_name',
        'phone',
        'email',
        'project_name',
        'status',
        'customer_id',
        'next_followup_date',
        'next_followup_time',
        'created_by',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class)->latest();
    }
    
    public function followups(): HasMany
    {
        return $this->hasMany(Followup::class)->orderBy('followup_date')->orderBy('followup_time');
    }
}
