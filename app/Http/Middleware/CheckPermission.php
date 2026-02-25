<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Checks if the authenticated user's role has the required permission.
     *
     * Usage in routes: ->middleware('permission:manage-leads')
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            abort(403, 'Unauthorized — no role assigned.');
        }

        $permissions = config('permissions.' . $user->role->name, []);

        if (! in_array($permission, $permissions) && ! in_array('*', $permissions)) {
            abort(403, 'Unauthorized — insufficient permissions.');
        }

        return $next($request);
    }
}
