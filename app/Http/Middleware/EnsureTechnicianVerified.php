<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTechnicianVerified
{
    /**
     * Handle an incoming request.
     *
     * Ensure that the technician has been verified and approved by the admin.
     * When verification documents are sent to admin (or not yet approved),
     * other technician pages are locked and inaccessible until admin approval.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Only enforce this check for technicians
        if (! $user || (int) $user->user_type !== 3) {
            return $next($request);
        }

        $pro = $user->professional;
        $isVerified = (bool) ($user->is_verified || $pro?->is_verified || $pro?->verification_status === 'verified');

        // Whitelisted routes that must remain accessible:
        // - Viewing the KYC verification status and document upload form
        // - Submitting KYC documents
        // - Logging out
        if ($request->routeIs('technician.verification') ||
            $request->routeIs('technician.verification.submit') ||
            $request->routeIs('logout')) {
            return $next($request);
        }

        // If the technician is already approved and verified, grant full access
        if ($isVerified && $user->is_active !== false && $pro?->verification_status !== 'rejected') {
            return $next($request);
        }

        // Determine verification status
        $status = $pro?->verification_status ?? 'pending';
        $isSentToAdmin = ($status === 'under_review');

        if (! $isSentToAdmin) {
            // Also check linked application in KYC pipeline
            $app = \App\Models\TechnicianApplication::where('user_id', $user->id)
                ->orWhere('email', $user->email)
                ->latest()
                ->first();
            if ($app && $app->status === 'under_review') {
                $isSentToAdmin = true;
            }
        }

        // When verification documents have been sent to admin, other pages must not show without admin approval!
        if ($isSentToAdmin && ! $isVerified) {
            $message = 'Your verification documents have been submitted to the admin and are currently under review. Other technician portal pages are locked until an admin approves your profile.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'verification_status' => 'under_review',
                    'redirect' => route('technician.verification'),
                ], 403);
            }

            return redirect()->route('technician.verification')->with('warning', $message);
        }

        return $next($request);
    }
}
