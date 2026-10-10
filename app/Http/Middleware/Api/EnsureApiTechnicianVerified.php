<?php

namespace App\Http\Middleware\Api;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API variant of the technician verification guard. Returns JSON 403 instead
 * of redirecting to the technician verification page.
 *
 * Whitelisted routes (verification show/submit) remain accessible so that an
 * unverified technician can complete their KYC from the mobile app.
 */
class EnsureApiTechnicianVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || (int) $user->user_type !== 3) {
            return $next($request);
        }

        $pro = $user->professional;
        $isVerified = (bool) ($user->is_verified || $pro?->is_verified || $pro?->verification_status === 'verified');

        if ($request->routeIs('api.technician.verification.*')) {
            return $next($request);
        }

        if ($isVerified && $user->is_active !== false && $pro?->verification_status !== 'rejected') {
            return $next($request);
        }

        $status = $pro?->verification_status ?? 'pending';
        $isSentToAdmin = ($status === 'under_review');

        if (! $isSentToAdmin) {
            $app = \App\Models\TechnicianApplication::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->latest()
                ->first();
            if ($app && $app->status === 'under_review') {
                $isSentToAdmin = true;
            }
        }

        if ($isSentToAdmin && ! $isVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Your verification documents are under admin review. This section unlocks once your profile is approved.',
                'data' => null,
                'verification_status' => 'under_review',
            ], 403);
        }

        return $next($request);
    }
}
