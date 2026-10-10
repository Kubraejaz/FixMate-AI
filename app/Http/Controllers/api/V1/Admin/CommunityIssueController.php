<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\CommunityIssueResource;
use App\Models\CommunityIssue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityIssueController extends ApiController
{
    public function index(Request $request): JsonResponse
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
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('reference_no', 'like', $term)
                    ->orWhere('title', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('reporter_name', 'like', $term)
                    ->orWhere('reporter_phone', 'like', $term);
            });
        }

        $perPage = min((int) $request->input('per_page', 15), 50);
        $issues = $query->latest()->paginate($perPage);

        return $this->ok(CommunityIssueResource::collection($issues->items()), 'Community issues retrieved.', [
            'current_page' => $issues->currentPage(),
            'per_page' => $issues->perPage(),
            'total' => $issues->total(),
            'last_page' => $issues->lastPage(),
            'stats' => [
                'total' => CommunityIssue::count(),
                'active_alerts' => CommunityIssue::where('status', 'alert_active')->count(),
                'in_progress' => CommunityIssue::whereIn('status', ['in_progress', 'scheduled'])->count(),
                'resolved' => CommunityIssue::where('status', 'resolved')->count(),
                'total_upvotes' => (int) CommunityIssue::sum('upvotes_count'),
            ],
            'categories' => CommunityIssue::CATEGORIES,
            'cities' => CommunityIssue::CITIES,
        ]);
    }

    public function update(Request $request, CommunityIssue $issue): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:reported,in_progress,alert_active,scheduled,resolved'],
            'status_update' => ['nullable', 'string', 'max:255'],
            'priority' => ['required', 'string', 'in:normal,high,critical'],
            'category' => ['required', 'string', 'in:'.implode(',', array_keys(CommunityIssue::CATEGORIES))],
            'city' => ['required', 'string', 'in:'.implode(',', CommunityIssue::CITIES)],
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

        return $this->ok(new CommunityIssueResource($issue->fresh()), "Community issue #{$issue->reference_no} updated successfully.");
    }

    public function toggle(CommunityIssue $issue): JsonResponse
    {
        $issue->update(['is_approved' => ! $issue->is_approved]);

        return $this->ok(new CommunityIssueResource($issue->fresh()), $issue->is_approved ? 'Hazard visible in public community feed.' : 'Hazard hidden from public feed.');
    }

    public function destroy(CommunityIssue $issue): JsonResponse
    {
        $ref = $issue->reference_no;
        $issue->delete();

        return $this->ok(null, "Civic report #{$ref} permanently deleted.");
    }
}
