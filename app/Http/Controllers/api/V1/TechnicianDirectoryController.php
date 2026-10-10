<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProfessionalResource;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TechnicianDirectoryController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Professional::with(['profession', 'user'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($request->filled('profession')) {
            $query->where('profession_id', $request->input('profession'));
        }

        if ($request->filled('city')) {
            $query->whereHas('user', fn ($q) => $q->where('city', $request->input('city')));
        }

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('experience', 'like', $term)
                    ->orWhereHas('profession', fn ($pq) => $pq->where('name', 'like', $term));
            });
        }

        $perPage = min((int) $request->input('per_page', 12), 50);
        $technicians = $query->latest()->paginate($perPage);

        return $this->paginated($technicians, ProfessionalResource::class, 'Technicians retrieved.');
    }

    public function show(int $id): JsonResponse
    {
        $professional = Professional::with(['profession', 'user'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->find($id);

        if (! $professional) {
            return $this->error('Technician not found.', 404);
        }

        return $this->ok(new ProfessionalResource($professional), 'Technician retrieved.');
    }
}
