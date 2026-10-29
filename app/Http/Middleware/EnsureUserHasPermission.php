<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Ensure the authenticated user has the specified permission(s).
     * Supports single or multiple permissions: e.g. 'permission:services.manage', 'permission:bookings.create,bookings.track'
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = $request->user();

        if (! $user) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please sign in to continue.',
                    'data' => null,
                ], 401);
            }

            return redirect()->guest(route('login'))
                ->with('info', 'Please sign in to perform this action.');
        }

        // Admin has superuser authority over all operations
        if ($user->isAdmin()) {
            return $next($request);
        }

        $requiredPermissions = [];
        foreach ($permissions as $permGroup) {
            $splitPerms = preg_split('/[,|]/', $permGroup);
            foreach ($splitPerms as $p) {
                $p = trim($p);
                if ($p !== '') {
                    $requiredPermissions[] = $p;
                }
            }
        }

        $hasAccess = false;
        foreach ($requiredPermissions as $perm) {
            if ($user->hasPermission($perm)) {
                $hasAccess = true;
                break;
            }
        }

        if (! $hasAccess && ! empty($requiredPermissions)) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. You do not have permission for this action.',
                    'data' => null,
                ], 403);
            }

            abort(403, 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
