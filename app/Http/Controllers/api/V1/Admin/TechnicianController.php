<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ProfessionResource;
use App\Http\Resources\ProfessionalResource;
use App\Models\Profession;
use App\Models\Professional;
use App\Models\TechnicianApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TechnicianController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Professional::with(['profession', 'user'])->withCount('reviews');

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
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

        if ($request->input('status') === 'verified') {
            $query->where('is_verified', true);
        } elseif ($request->input('status') === 'unverified') {
            $query->where('is_verified', false);
        }

        $perPage = min((int) $request->input('per_page', 10), 50);
        $technicians = $query->latest()->paginate($perPage);

        $stats = [
            'total' => Professional::count(),
            'verified' => Professional::where('is_verified', true)->count(),
            'pending_kyc' => TechnicianApplication::where('status', 'pending')->count(),
        ];

        return $this->ok(ProfessionalResource::collection($technicians->items()), 'Technicians retrieved.', [
            'current_page' => $technicians->currentPage(),
            'per_page' => $technicians->perPage(),
            'total' => $technicians->total(),
            'last_page' => $technicians->lastPage(),
            'stats' => $stats,
            'professions' => ProfessionResource::collection(Profession::where('is_active', true)->get()),
        ]);
    }

    public function toggleVerify(Professional $professional): JsonResponse
    {
        $newStatus = ! $professional->is_verified;
        $professional->update(['is_verified' => $newStatus]);

        if ($professional->user) {
            $professional->user->update(['is_verified' => $newStatus]);
        }

        $label = $newStatus ? 'marked as NADRA Verified' : 'verification badge revoked';

        return $this->ok(
            new ProfessionalResource($professional->fresh(['profession', 'user'])),
            "Technician {$professional->name} {$label}."
        );
    }

    public function destroy(Professional $professional): JsonResponse
    {
        $name = $professional->name;
        $user = $professional->user;

        $professional->delete();
        if ($user) {
            $user->delete();
        }

        return $this->ok(null, "Technician {$name} removed from pool.");
    }
}
