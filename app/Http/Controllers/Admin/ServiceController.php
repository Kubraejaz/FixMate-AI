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
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:professions,slug'],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
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

        Profession::create([
            'name' => trim($validated['name']),
            'slug' => $slug,
            'icon' => $validated['icon'] ?? 'wrench',
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.categories')
            ->with('success', "Service category '{$validated['name']}' created successfully!");
    }

    /**
     * Update the specified service category in storage.
     */
    public function update(Request $request, Profession $service): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:professions,slug,' . $service->id],
            'icon' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $service->update([
            'name' => trim($validated['name']),
            'slug' => Str::slug($validated['slug']),
            'icon' => $validated['icon'] ?? $service->icon,
            'description' => $validated['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.categories')
            ->with('success', "Service category '{$service->name}' updated successfully!");
    }

    /**
     * Remove the specified service category from storage.
     */
    public function destroy(Profession $service): RedirectResponse
    {
        $techCount = $service->professionals()->count();

        if ($techCount > 0) {
            return redirect()->route('admin.categories')
                ->with('error', "Cannot delete '{$service->name}' because {$techCount} technician(s) are linked to it. Deactivate the service instead.");
        }

        $name = $service->name;
        $service->delete();

        return redirect()->route('admin.categories')
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

        return redirect()->route('admin.categories')
            ->with('success', "Service '{$service->name}' is now {$statusText}.");
    }
}
