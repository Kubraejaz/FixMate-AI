<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityIssue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommunityIssueController extends Controller
{
    /**
     * Display community civic reports management dashboard.
     */
    public function index(Request $request): View
    {
        $query = CommunityIssue::query();

        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        if ($request->filled('search')) {
            $term = '%' . trim($request->input('search')) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                  ->orWhere('title', 'like', $term)
                  ->orWhere('location', 'like', $term)
                  ->orWhere('reporter_name', 'like', $term)
                  ->orWhere('reporter_phone', 'like', $term);
            });
        }

        $issues = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => CommunityIssue::count(),
            'active_alerts' => CommunityIssue::where('status', 'alert_active')->count(),
            'in_progress' => CommunityIssue::whereIn('status', ['in_progress', 'scheduled'])->count(),
            'resolved' => CommunityIssue::where('status', 'resolved')->count(),
            'total_upvotes' => (int) CommunityIssue::sum('upvotes_count'),
        ];

        return view('Frontend.admin.community', [
            'issues' => $issues,
            'stats' => $stats,
            'categories' => CommunityIssue::CATEGORIES,
            'cities' => CommunityIssue::CITIES,
        ]);
    }

    /**
     * Update an issue's status, dispatch note, and priority.
     */
    public function update(Request $request, CommunityIssue $issue): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:reported,in_progress,alert_active,scheduled,resolved'],
            'status_update' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:normal,high,critical'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(CommunityIssue::CATEGORIES))],
            'city' => ['required', 'string', 'in:' . implode(',', CommunityIssue::CITIES)],
            'location' => ['required', 'string', 'max:255'],
            'is_approved' => ['nullable', 'boolean'],
        ]);

        $resolvedAt = $issue->resolved_at;
        if ($validated['status'] === 'resolved' && ! $resolvedAt) {
            $resolvedAt = now();
        } elseif ($validated['status'] !== 'resolved') {
            $resolvedAt = null;
        }

        $issue->update([
            'status' => $validated['status'],
            'status_update' => $validated['status_update'] ?? null,
            'priority' => $validated['priority'],
            'category' => $validated['category'],
            'city' => $validated['city'],
            'location' => trim($validated['location']),
            'is_approved' => $request->boolean('is_approved', true),
            'resolved_at' => $resolvedAt,
        ]);

        return redirect()->route('admin.community')
            ->with('success', "Community issue #{$issue->reference_no} updated successfully.");
    }

    /**
     * Toggle public approval / visibility.
     */
    public function toggle(Request $request, CommunityIssue $issue): JsonResponse|RedirectResponse
    {
        $issue->is_approved = ! $issue->is_approved;
        $issue->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_approved' => $issue->is_approved,
                'message' => $issue->is_approved ? 'Hazard visible in public community feed.' : 'Hazard hidden from public feed.',
            ]);
        }

        return redirect()->back()->with('success', $issue->is_approved ? 'Hazard approved.' : 'Hazard hidden.');
    }

    /**
     * Delete an issue.
     */
    public function destroy(CommunityIssue $issue): RedirectResponse
    {
        $ref = $issue->reference_no;
        $issue->delete();

        return redirect()->route('admin.community')
            ->with('success', "Civic report #{$ref} permanently deleted.");
    }
}
