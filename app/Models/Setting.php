<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function get(int $userId, string $key, $default = null)
    {
        $setting = self::where('user_id', $userId)
            ->where('key', $key)
            ->first();

        if (!$setting) {
            return $default;
        }

        return $setting->getValue();
    }

    public static function set(int $userId, string $key, $value, string $type = 'string'): void
    {
        self::updateOrCreate(
            ['user_id' => $userId, 'key' => $key],
            ['value' => is_array($value) ? json_encode($value) : $value, 'type' => $type]
        );
    }

    public function getValue()
    {
        return match($this->type) {
            'boolean' => (bool) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}
