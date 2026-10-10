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
    public function handle(Request $request, Closure $next, string $role): Response
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
        ];

        $expectedType = $typeMap[$role] ?? (int) $role;

        if ((int) $user->user_type !== $expectedType) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to access this resource.',
                'data' => null,
            ], 403);
        }

        return $next($request);
    }
}
