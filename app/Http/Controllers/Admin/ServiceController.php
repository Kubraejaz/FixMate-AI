<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\Professional;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all service professions with stats and filtering.
     */
    public function index(Request $request): View
    {
        $query = Profession::withCount('professionals');

        if ($request->filled('search')) {
            $term = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                  ->orWhere('slug', 'like', $term)
                  ->orWhere('description', 'like', $term);
            });
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $services = $query->orderBy('name')->get();

        $stats = [
            'total' => Profession::count(),
            'active' => Profession::where('is_active', true)->count(),
            'inactive' => Profession::where('is_active', false)->count(),
            'total_technicians' => Professional::count(),
        ];

        return view('Frontend.admin.categories', compact('services', 'stats'));
    }

    /**
     * Store a newly created service category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:professions,slug'],
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

        $slug = ! empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        // Ensure slug uniqueness if generated from name
        $originalSlug = $slug;
        $counter = 1;
        while (Profession::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagePath = $validated['image'] ?? 'assets/images/image_3.png';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'service_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $imagePath = 'assets/images/' . $fileName;
        }

        $parseList = function ($input) {
            if (is_array($input)) {
                return array_values(array_filter(array_map('trim', $input)));
            }
            if (is_string($input)) {
                // Split by newline or commas if on single line
                if (str_contains($input, "\n") || str_contains($input, "\r")) {
                    $lines = preg_split('/\r\n|\r|\n/', $input);
                } else {
                    $lines = explode(',', $input);
                }
                return array_values(array_filter(array_map('trim', $lines)));
            }
            return null;
        };

        Profession::create([
            'name' => trim($validated['name']),
            'slug' => $slug,
            'icon' => $validated['icon'] ?? '🔧',
            'base_price' => $validated['base_price'] ?? 650,
            'price_unit' => $validated['price_unit'] ?? 'base',
            'estimated_duration' => $validated['estimated_duration'] ?? '30 – 60 mins',
            'headline' => $validated['headline'] ?? trim($validated['name']) . ' Repair & Maintenance',
            'image' => $imagePath,
            'warranty_text' => $validated['warranty_text'] ?? '60-Day Re-work Free',
            'sub_categories' => $parseList($request->input('sub_categories')),
            'feature_points' => $parseList($request->input('feature_points')),
            'included_items' => $parseList($request->input('included_items')),
            'excluded_items' => $parseList($request->input('excluded_items')),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.services')
            ->with('success', "Service category '{$validated['name']}' created successfully!");
    }

    /**
     * Update the specified service category in storage.
     */
    public function update(Request $request, Profession $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:professions,slug,' . $service->id],
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

        $imagePath = $validated['image'] ?? $service->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'service_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $fileName);
            $imagePath = 'assets/images/' . $fileName;
        }

        $parseList = function ($input) {
            if (is_array($input)) {
                return array_values(array_filter(array_map('trim', $input)));
            }
            if (is_string($input)) {
                if (str_contains($input, "\n") || str_contains($input, "\r")) {
                    $lines = preg_split('/\r\n|\r|\n/', $input);
                } else {
                    $lines = explode(',', $input);
                }
                return array_values(array_filter(array_map('trim', $lines)));
            }
            return null;
        };

        $service->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['slug']),
            'icon' => $validated['icon'] ?? $service->icon,
            'base_price' => isset($validated['base_price']) ? (int) $validated['base_price'] : $service->base_price,
            'price_unit' => $validated['price_unit'] ?? ($service->price_unit ?? 'base'),
            'estimated_duration' => $validated['estimated_duration'] ?? ($service->estimated_duration ?? '30 – 60 mins'),
            'headline' => $validated['headline'] ?? ($service->headline ?? $validated['name']),
            'image' => $imagePath ?: $service->image,
            'warranty_text' => $validated['warranty_text'] ?? ($service->warranty_text ?? '60-Day Re-work Free'),
            'sub_categories' => $request->has('sub_categories') ? $parseList($request->input('sub_categories')) : $service->sub_categories,
            'feature_points' => $request->has('feature_points') ? $parseList($request->input('feature_points')) : $service->feature_points,
            'included_items' => $request->has('included_items') ? $parseList($request->input('included_items')) : $service->included_items,
            'excluded_items' => $request->has('excluded_items') ? $parseList($request->input('excluded_items')) : $service->excluded_items,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.services')
            ->with('success', "Service category '{$service->name}' updated successfully!");
    }

    /**
     * Remove the specified service category from storage.
     */
    public function destroy(Profession $service): RedirectResponse
    {
        $techCount = $service->professionals()->count();

        if ($techCount > 0) {
            return redirect()->route('admin.services')
                ->with('error', "Cannot delete '{$service->name}' because {$techCount} technician(s) are linked to it. Deactivate the service instead.");
        }

        $name = $service->name;
        $service->delete();

        return redirect()->route('admin.services')
            ->with('success', "Service category '{$name}' has been deleted.");
    }

    /**
     * Toggle the active status of a service category.
     */
    public function toggle(Profession $service): RedirectResponse
    {
        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        $statusText = $service->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.services')
            ->with('success', "Service '{$service->name}' is now {$statusText}.");
    }
}
