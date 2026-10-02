<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianManagementController extends Controller
{
    /**
     * Display the technicians pool with dynamic filtering, KYC badge counts, and verification actions.
     */
    public function index(Request $request): View
    {
        $query = Professional::with(['profession', 'user']);

        if ($request->filled('q')) {
            $term = '%' . trim($request->input('q')) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('email', 'like', $term)
                  ->orWhere('phone', 'like', $term)
                  ->orWhere('experience', 'like', $term);
            });
        }

        if ($request->filled('profession_id')) {
            $query->where('profession_id', $request->input('profession_id'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->input('status') === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        $professions = Profession::where('is_active', true)->get();
        $totalCount = Professional::count();
        $verifiedCount = Professional::where('is_verified', true)->count();
        $pendingKycCount = TechnicianApplication::where('status', 'pending')->count();
        $technicians = $query->latest()->paginate(10)->withQueryString();

        return view('Frontend.admin.technicians', compact(
            'technicians',
            'professions',
            'totalCount',
            'verifiedCount',
            'pendingKycCount'
        ));
    }

    /**
     * Toggle technician verified badge status.
     */
    public function toggleVerify(Professional $professional): RedirectResponse
    {
        $newStatus = ! $professional->is_verified;
        $professional->update(['is_verified' => $newStatus]);

        if ($professional->user) {
            $professional->user->update(['is_verified' => $newStatus]);
        }

        $label = $newStatus ? 'marked as NADRA Verified' : 'verification badge revoked';

        return back()->with('success', "Technician {$professional->name} {$label}.");
    }

    /**
     * Delete technician record.
     */
    public function destroy(Professional $professional): RedirectResponse
    {
        $name = $professional->name;
        $user = $professional->user;

        $professional->delete();
        if ($user) {
            $user->delete();
        }

        return back()->with('success', "Technician {$name} removed from pool.");
    }
}
