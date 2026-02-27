<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Followup extends Model
{
    use SoftDeletes;
    
    protected $table = 'followups';
    
    protected $fillable = [
        'lead_id',
        'followup_date',
        'followup_time',
        'status',
    ];
    
    protected $casts = [
        'followup_date' => 'date',
        'followup_time' => 'datetime:H:i',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
