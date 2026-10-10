<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CommunityIssueResource;
use App\Models\CommunityIssue;
use App\Models\CommunityIssueUpvote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = CommunityIssue::approved();

        $selectedCity = $request->query('city');
        $selectedCategory = $request->query('category');
        $selectedStatus = $request->query('status');

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

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('reference_no', 'like', $term);
            });
        }

        if ($request->query('sort', 'upvotes') === 'latest') {
            $query->latest();
        } else {
            $query->orderByDesc('upvotes_count')->latest();
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $issues = $query->paginate($perPage);

        $cityCounts = CommunityIssue::approved()
            ->selectRaw('city, count(*) as count')
            ->groupBy('city')
            ->pluck('count', 'city')
            ->toArray();

        return $this->ok([
            'issues' => CommunityIssueResource::collection($issues->items()),
            'cities' => CommunityIssue::CITIES,
            'categories' => CommunityIssue::CATEGORIES,
            'city_counts' => $cityCounts,
            'total_approved' => CommunityIssue::approved()->count(),
        ], 'Community issues retrieved.', [
            'current_page' => $issues->currentPage(),
            'per_page' => $issues->perPage(),
            'total' => $issues->total(),
            'last_page' => $issues->lastPage(),
        ]);
    }

    public function show(Request $request, CommunityIssue $issue): JsonResponse
    {
        if (! $issue->is_approved) {
            return $this->error('Issue not found.', 404);
        }

        return $this->ok(new CommunityIssueResource($issue), 'Community issue retrieved.');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'category' => ['required', 'string', 'in:'.implode(',', array_keys(CommunityIssue::CATEGORIES))],
            'city' => ['required', 'string', 'in:'.implode(',', CommunityIssue::CITIES)],
            'location' => ['required', 'string', 'min:3', 'max:255'],
            'reporter_name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\.\'-]+$/u'],
            'reporter_role' => ['nullable', 'string', 'max:50'],
            'reporter_phone' => ['nullable', 'string', 'max:25', 'regex:/^[0-9+\s\-]{10,25}$/'],
            'priority' => ['nullable', 'string', 'in:normal,high,critical'],
        ]);

        do {
            $ref = 'FM-CIV-'.rand(1000, 9999);
        } while (CommunityIssue::where('reference_no', $ref)->exists());

        $user = $request->user();
        $ip = $request->ip();
        $priority = $validated['priority'] ?? 'normal';

        $issue = CommunityIssue::create([
            'reference_no' => $ref,
            'user_id' => $user?->id,
            'reporter_name' => trim($validated['reporter_name']),
            'reporter_role' => trim($validated['reporter_role'] ?? 'Resident'),
            'reporter_phone' => ! empty($validated['reporter_phone']) ? trim($validated['reporter_phone']) : null,
            'title' => trim($validated['title']),
            'description' => trim($validated['description']),
            'category' => $validated['category'],
            'city' => $validated['city'],
            'location' => trim($validated['location']),
            'status' => $priority === 'critical' ? 'alert_active' : 'reported',
            'status_update' => $priority === 'critical'
                ? 'High Urgency Alert Logged — Reviewing for Squad Dispatch'
                : 'Report Received & Queued for Community Upvoting',
            'priority' => $priority,
            'upvotes_count' => 1,
            'is_approved' => true,
        ]);

        CommunityIssueUpvote::create([
            'community_issue_id' => $issue->id,
            'user_id' => $user?->id,
            'ip_address' => $ip ?? '127.0.0.1',
        ]);

        return $this->created(new CommunityIssueResource($issue), 'Hazard report submitted successfully.');
    }

    public function upvote(Request $request, CommunityIssue $issue): JsonResponse
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
            $existingVote->delete();
            $issue->decrement('upvotes_count');
            $upvoted = false;
        } else {
            CommunityIssueUpvote::create([
                'community_issue_id' => $issue->id,
                'user_id' => $user?->id,
                'ip_address' => $ip,
            ]);
            $issue->increment('upvotes_count');
            $upvoted = true;

            if ($issue->upvotes_count >= 25 && $issue->status === 'reported') {
                $issue->update([
                    'status' => 'in_progress',
                    'status_update' => 'Civic Threshold Reached (25+ votes) — Dispatch Squad Mobilized',
                    'priority' => 'high',
                ]);
            }
        }

        return $this->ok([
            'upvoted' => $upvoted,
            'count' => $issue->fresh()->upvotes_count,
        ], $upvoted ? 'Upvote registered!' : 'Upvote removed.');
    }
}
