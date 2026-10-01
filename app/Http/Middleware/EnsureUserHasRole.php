<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Ensure the authenticated user matches the required role or user_type.
     * 1 = Admin, 2 = Customer, 3 = Technician.
     * Guest users are sent to the login page; wrong-role users are
     * redirected to their own portal home.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->guest(route('login'))
                ->with('info', 'Please sign in or create an account to book a service or diagnose your problem.');
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
            return redirect($user->dashboardRoute());
        }

        return $next($request);
    }
}