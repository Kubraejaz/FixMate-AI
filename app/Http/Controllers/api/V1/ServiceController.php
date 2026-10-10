<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProfessionResource;
use App\Http\Resources\ProfessionalResource;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->input('search', ''));

        $query = Profession::where('is_active', true)->withCount('professionals');

        if ($request->filled('category') && $request->input('category') !== 'all') {
            $query->where('slug', $request->input('category'));
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('headline', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sub_categories', 'like', "%{$search}%");
            });
        }

        $professions = $query->orderBy('name')->get();

        return $this->ok(
            ProfessionResource::collection($professions),
            'Services retrieved.',
            ['total' => $professions->count()]
        );
    }

    public function show(string $slug): JsonResponse
    {
        $profession = Profession::where('slug', $slug)
            ->orWhere('slug', 'like', "%{$slug}%")
            ->first();

        if (! $profession) {
            return $this->error('Service not found.', 404);
        }

        $profession->load(['professionals.user', 'professionals.profession']);

        $otherProfessions = Profession::where('is_active', true)
            ->where('id', '!=', $profession->id)
            ->take(6)
            ->get();

        return $this->ok(
            new ProfessionResource($profession),
            'Service details retrieved.',
            ['other_services' => ProfessionResource::collection($otherProfessions)->resolve()]
        );
    }
}
