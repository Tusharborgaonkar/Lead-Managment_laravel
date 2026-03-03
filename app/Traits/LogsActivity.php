<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Record a system activity.
     *
     * @param string $action
     * @param mixed $entity
     * @param string|null $description
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    public function logActivity(string $action, $entity = null, string $description = null, array $oldValues = null, array $newValues = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'entity_type' => $entity ? get_class($entity) : null,
            'entity_id' => $entity ? $entity->id : null,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
