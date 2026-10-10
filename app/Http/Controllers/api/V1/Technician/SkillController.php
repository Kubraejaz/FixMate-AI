<?php

namespace App\Http\Controllers\Api\V1\Technician;

use App\Http\Resources\ProfessionResource;
use App\Http\Resources\ProfessionalResource;
use App\Models\Profession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends TechnicianController
{
    public function index(Request $request): JsonResponse
    {
        $pro = $this->professional();
        $professions = Profession::where('is_active', true)->get();

        return $this->ok([
            'professional' => new ProfessionalResource($pro->load('profession')),
            'professions' => ProfessionResource::collection($professions),
        ], 'Skills retrieved.');
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'profession_id' => ['required', 'exists:professions,id'],
            'experience' => ['required', 'string', 'max:50'],
            'sub_categories' => ['nullable', 'array'],
            'sub_categories.*' => ['string', 'max:150'],
        ]);

        $user = $request->user();
        $pro = $this->professional();

        $user->update([
            'profession_id' => $validated['profession_id'],
            'experience' => $validated['experience'],
        ]);

        $proUpdates = [
            'profession_id' => $validated['profession_id'],
            'experience' => $validated['experience'],
        ];

        if ($request->has('sub_categories')) {
            $proUpdates['sub_categories'] = $validated['sub_categories'];
        }

        $pro->update($proUpdates);

        return $this->ok(new ProfessionalResource($pro->fresh('profession')), 'Skills, trade category, and sub-categories updated successfully.');
    }
}
