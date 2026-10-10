<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Faq::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->input('status') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->input('status') === 'inactive') {
            $query->where('is_active', false);
        }

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('question', 'like', $term)
                    ->orWhere('answer', 'like', $term);
            });
        }

        $perPage = min((int) $request->input('per_page', 12), 50);
        $faqs = $query->ordered()->paginate($perPage);

        return $this->ok(FaqResource::collection($faqs->items()), 'FAQs retrieved.', [
            'current_page' => $faqs->currentPage(),
            'per_page' => $faqs->perPage(),
            'total' => $faqs->total(),
            'last_page' => $faqs->lastPage(),
            'stats' => [
                'total' => Faq::count(),
                'active' => Faq::where('is_active', true)->count(),
                'inactive' => Faq::where('is_active', false)->count(),
                'categories' => count(Faq::CATEGORIES),
            ],
            'categories' => Faq::CATEGORIES,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validatePayload($request);

        $faq = Faq::create([
            'question' => trim($validated['question']),
            'answer' => trim($validated['answer']),
            'category' => $validated['category'],
            'sort_order' => $validated['sort_order'] ?? (Faq::max('sort_order') + 1),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return $this->created(new FaqResource($faq), 'FAQ question has been added successfully.');
    }

    public function update(Request $request, Faq $faq): JsonResponse
    {
        $validated = $this->validatePayload($request);

        $faq->update([
            'question' => trim($validated['question']),
            'answer' => trim($validated['answer']),
            'category' => $validated['category'],
            'sort_order' => $validated['sort_order'] ?? $faq->sort_order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return $this->ok(new FaqResource($faq->fresh()), "FAQ '{$faq->question}' updated successfully.");
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $title = $faq->question;
        $faq->delete();

        return $this->ok(null, "FAQ '{$title}' has been removed.");
    }

    public function toggle(Faq $faq): JsonResponse
    {
        $faq->update(['is_active' => ! $faq->is_active]);

        return $this->ok(new FaqResource($faq->fresh()), $faq->is_active ? 'FAQ published to live site.' : 'FAQ unpublished and hidden from public.');
    }

    private function validatePayload(Request $request): array
    {
        return $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'in:'.implode(',', array_keys(Faq::CATEGORIES))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
