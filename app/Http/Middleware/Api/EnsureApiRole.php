<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API variant of the role guard. Returns JSON 401/403 instead of redirects.
 */
class EnsureApiRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please sign in to continue.',
                'data' => null,
            ], 401);
        }

        $typeMap = [
            '1' => 1,
            'admin' => 1,
            '2' => 2,
            'customer' => 2,
            '3' => 3,
            'technician' => 3,
            'provider' => 3,
        ];

        // Flatten roles by splitting commas or pipes
        $allowedTypes = [];
        foreach ($roles as $roleGroup) {
            $splitRoles = preg_split('/[,|]/', $roleGroup);
            foreach ($splitRoles as $r) {
                $r = trim(strtolower($r));
                if ($r !== '') {
                    $allowedTypes[] = $typeMap[$r] ?? (int) $r;
                }
            }
        }

        if (! empty($allowedTypes) && ! in_array((int) $user->user_type, $allowedTypes, true)) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource.',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
