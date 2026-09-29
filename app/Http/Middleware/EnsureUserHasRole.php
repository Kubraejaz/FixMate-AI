<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Ensure the authenticated user matches the required role.
     * Guest users are sent to the login page; wrong-role users are
     * redirected to their own portal home.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ((string) $user->role !== $role) {
            return redirect($user->dashboardRoute());
        }

        return $next($request);
    }
}