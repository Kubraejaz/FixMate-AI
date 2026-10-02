<?php

namespace App\Http\Controllers;

use App\Models\CommunityIssue;
use App\Models\CommunityIssueUpvote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommunityController extends Controller
{
    /**
     * Display public community maintenance feed.
     */
    public function index(Request $request): View
    {
        $selectedCity = $request->query('city');
        $selectedCategory = $request->query('category');
        $selectedStatus = $request->query('status');
        $searchTerm = $request->query('search');
        $sortBy = $request->query('sort', 'upvotes');

        $query = CommunityIssue::approved();

        if ($selectedCity && $selectedCity !== 'all') {
            $query->where('city', $selectedCity);
        }

        if ($selectedCategory && array_key_exists($selectedCategory, CommunityIssue::CATEGORIES)) {
            $query->where('category', $selectedCategory);
        }

        if ($selectedStatus) {
            if ($selectedStatus === 'resolved') {
                $query->where('status', 'resolved');
            } elseif ($selectedStatus === 'active') {
                $query->where('status', '!=', 'resolved');
            } else {
                $query->where('status', $selectedStatus);
            }
        }

        if ($searchTerm) {
            $term = '%' . trim($searchTerm) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                  ->orWhere('location', 'like', $term)
                  ->orWhere('description', 'like', $term)
                  ->orWhere('reference_no', 'like', $term);
            });
        }

        if ($sortBy === 'latest') {
            $query->latest();
        } else {
            // Default sort: highest upvotes first, then newest
            $query->orderByDesc('upvotes_count')->latest();
        }

        $issues = $query->paginate(10)->withQueryString();

        // City counts for the filter tabs
        $cityCounts = CommunityIssue::approved()
            ->selectRaw('city, count(*) as count')
            ->groupBy('city')
            ->pluck('count', 'city')
            ->toArray();

        $totalApprovedCount = CommunityIssue::approved()->count();

        // Identify which issues the current visitor / user has upvoted
        $user = $request->user();
        $ip = $request->ip();

        $userUpvotedIssueIds = CommunityIssueUpvote::query()
            ->where(function ($q) use ($user, $ip) {
                if ($user) {
                    $q->where('user_id', $user->id);
                }
                if ($ip) {
                    $q->orWhere('ip_address', $ip);
                }
            })
            ->pluck('community_issue_id')
            ->toArray();

        return view('Frontend.public.community', [
            'issues' => $issues,
            'cities' => CommunityIssue::CITIES,
            'categories' => CommunityIssue::CATEGORIES,
            'selectedCity' => $selectedCity,
            'selectedCategory' => $selectedCategory,
            'selectedStatus' => $selectedStatus,
            'searchTerm' => $searchTerm,
            'sortBy' => $sortBy,
            'cityCounts' => $cityCounts,
            'totalApprovedCount' => $totalApprovedCount,
            'userUpvotedIssueIds' => $userUpvotedIssueIds,
        ]);
    }

    /**
     * Submit a new civic hazard report.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:3000'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(CommunityIssue::CATEGORIES))],
            'city' => ['required', 'string', 'in:' . implode(',', CommunityIssue::CITIES)],
            'location' => ['required', 'string', 'max:255'],
            'reporter_name' => ['required', 'string', 'max:150'],
            'reporter_role' => ['nullable', 'string', 'max:50'],
            'reporter_phone' => ['nullable', 'string', 'max:30'],
            'priority' => ['nullable', 'string', 'in:normal,high,critical'],
        ]);

        do {
            $ref = 'FM-CIV-' . rand(1000, 9999);
        } while (CommunityIssue::where('reference_no', $ref)->exists());

        $user = $request->user();
        $ip = $request->ip();

        $issue = CommunityIssue::create([
            'reference_no' => $ref,
            'user_id' => $user?->id,
            'reporter_name' => trim($validated['reporter_name']),
            'reporter_role' => trim($validated['reporter_role'] ?? 'Resident'),
            'reporter_phone' => !empty($validated['reporter_phone']) ? trim($validated['reporter_phone']) : null,
            'title' => trim($validated['title']),
            'description' => trim($validated['description']),
            'category' => $validated['category'],
            'city' => $validated['city'],
            'location' => trim($validated['location']),
            'status' => ($validated['priority'] ?? 'normal') === 'critical' ? 'alert_active' : 'reported',
            'status_update' => ($validated['priority'] ?? 'normal') === 'critical'
                ? 'High Urgency Alert Logged — Reviewing for Squad Dispatch'
                : 'Report Received & Queued for Community Upvoting',
            'priority' => $validated['priority'] ?? 'normal',
            'upvotes_count' => 1,
            'is_approved' => true,
        ]);

        // Auto-register initial upvote by reporter
        CommunityIssueUpvote::create([
            'community_issue_id' => $issue->id,
            'user_id' => $user?->id,
            'ip_address' => $ip ?? '127.0.0.1',
        ]);

        return redirect()->route('community', ['city' => $issue->city])
            ->with('success_hazard_report', "Hazard report #{$ref} submitted successfully and added to the neighborhood feed!");
    }

    /**
     * Upvote or un-upvote a community issue.
     */
    public function upvote(Request $request, CommunityIssue $issue): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $ip = $request->ip() ?? '127.0.0.1';

        $existingVote = CommunityIssueUpvote::where('community_issue_id', $issue->id)
            ->where(function ($q) use ($user, $ip) {
                if ($user) {
                    $q->where('user_id', $user->id);
                }
                $q->orWhere('ip_address', $ip);
            })
            ->first();

        if ($existingVote) {
            // Unvote
            $existingVote->delete();
            $issue->decrement('upvotes_count');
            $upvoted = false;
        } else {
            // Vote
            CommunityIssueUpvote::create([
                'community_issue_id' => $issue->id,
                'user_id' => $user?->id,
                'ip_address' => $ip,
            ]);
            $issue->increment('upvotes_count');
            $upvoted = true;

            // Escalate if threshold reached (25+ upvotes)
            if ($issue->upvotes_count >= 25 && $issue->status === 'reported') {
                $issue->update([
                    'status' => 'in_progress',
                    'status_update' => 'Civic Threshold Reached (25+ votes) — Dispatch Squad Mobilized',
                    'priority' => 'high',
                ]);
            }
        }

        $freshCount = $issue->fresh()->upvotes_count;

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'upvoted' => $upvoted,
                'count' => $freshCount,
                'message' => $upvoted ? 'Upvote registered! Thank you for supporting your neighborhood.' : 'Upvote removed.',
            ]);
        }

        return redirect()->back();
    }
}
