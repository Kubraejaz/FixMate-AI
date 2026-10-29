<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Ensure the authenticated user matches the required role(s) or user_type(s).
     * 1 = Admin, 2 = Customer, 3 = Technician.
     * Supports single or multiple roles: e.g. 'role:admin', 'role:admin,technician', 'role:admin|technician'.
     * Guest users are sent to the login page; wrong-role users are
     * redirected to their own portal home.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
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
            return redirect($user->dashboardRoute());
        }

        return $next($request);
    }
}