<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\ProfessionResource;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Profession::withCount('professionals');

        if ($request->filled('search')) {
            $term = '%'.$request->input('search').'%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('slug', 'like', $term)
                    ->orWhere('description', 'like', $term);
            });
        }

        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        $services = $query->orderBy('name')->get();

        return $this->ok(ProfessionResource::collection($services), 'Services retrieved.', [
            'stats' => [
                'total' => Profession::count(),
                'active' => Profession::where('is_active', true)->count(),
                'inactive' => Profession::where('is_active', false)->count(),
                'total_technicians' => Professional::count(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatePayload($request, null);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Profession::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $service = Profession::create([
            'name' => trim($validated['name']),
            'slug' => $slug,
            'icon' => $validated['icon'] ?? '🔧',
            'base_price' => $validated['base_price'] ?? 650,
            'price_unit' => $validated['price_unit'] ?? 'base',
            'estimated_duration' => $validated['estimated_duration'] ?? '30 – 60 mins',
            'headline' => $validated['headline'] ?? trim($validated['name']).' Repair & Maintenance',
            'image' => $this->resolveImage($request, $validated['image'] ?? 'assets/images/image_3.png'),
            'warranty_text' => $validated['warranty_text'] ?? '60-Day Re-work Free',
            'sub_categories' => $this->parseList($request->input('sub_categories')),
            'feature_points' => $this->parseList($request->input('feature_points')),
            'included_items' => $this->parseList($request->input('included_items')),
            'excluded_items' => $this->parseList($request->input('excluded_items')),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return $this->created(new ProfessionResource($service), "Service category '{$service->name}' created successfully!");
    }

    public function update(Request $request, Profession $service): JsonResponse
    {
        $validated = $this->validatePayload($request, $service);

        $service->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['slug']),
            'icon' => $validated['icon'] ?? $service->icon,
            'base_price' => isset($validated['base_price']) ? (int) $validated['base_price'] : $service->base_price,
            'price_unit' => $validated['price_unit'] ?? ($service->price_unit ?? 'base'),
            'estimated_duration' => $validated['estimated_duration'] ?? ($service->estimated_duration ?? '30 – 60 mins'),
            'headline' => $validated['headline'] ?? ($service->headline ?? $validated['name']),
            'image' => $this->resolveImage($request, $validated['image'] ?? $service->image),
            'warranty_text' => $validated['warranty_text'] ?? ($service->warranty_text ?? '60-Day Re-work Free'),
            'sub_categories' => $request->has('sub_categories') ? $this->parseList($request->input('sub_categories')) : $service->sub_categories,
            'feature_points' => $request->has('feature_points') ? $this->parseList($request->input('feature_points')) : $service->feature_points,
            'included_items' => $request->has('included_items') ? $this->parseList($request->input('included_items')) : $service->included_items,
            'excluded_items' => $request->has('excluded_items') ? $this->parseList($request->input('excluded_items')) : $service->excluded_items,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return $this->ok(new ProfessionResource($service->fresh()), "Service category '{$service->name}' updated successfully!");
    }

    public function destroy(Profession $service): JsonResponse
    {
        $techCount = $service->professionals()->count();

        if ($techCount > 0) {
            return $this->error("Cannot delete '{$service->name}' because {$techCount} technician(s) are linked to it. Deactivate the service instead.", 422);
        }

        $name = $service->name;
        $service->delete();

        return $this->ok(null, "Service category '{$name}' has been deleted.");
    }

    public function toggle(Profession $service): JsonResponse
    {
        $service->update(['is_active' => ! $service->is_active]);
        $statusText = $service->is_active ? 'activated' : 'deactivated';

        return $this->ok(new ProfessionResource($service->fresh()), "Service '{$service->name}' is now {$statusText}.");
    }

    private function validatePayload(Request $request, ?Profession $service): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:professions,slug'.($service ? ','.$service->id : '')],
            'icon' => ['nullable', 'string', 'max:50'],
            'base_price' => ['nullable', 'integer', 'min:0', 'max:500000'],
            'price_unit' => ['nullable', 'string', 'max:50'],
            'estimated_duration' => ['nullable', 'string', 'max:100'],
            'headline' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'warranty_text' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'sub_categories' => ['nullable'],
            'feature_points' => ['nullable'],
            'included_items' => ['nullable'],
            'excluded_items' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'name.min' => 'Category name must be at least 2 characters long.',
            'base_price.min' => 'Base price cannot be negative.',
            'image_file.max' => 'Service image must not exceed 5MB.',
        ]);
    }

    private function resolveImage(Request $request, ?string $fallback): ?string
    {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'service_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);

            return 'assets/images/'.$fileName;
        }

        return $fallback;
    }

    private function parseList(mixed $input): ?array
    {
        if (is_array($input)) {
            return array_values(array_filter(array_map('trim', $input)));
        }

        if (is_string($input)) {
            $lines = (str_contains($input, "\n") || str_contains($input, "\r"))
                ? preg_split('/\r\n|\r|\n/', $input)
                : explode(',', $input);

            return array_values(array_filter(array_map('trim', $lines)));
        }

        return null;
    }
}
