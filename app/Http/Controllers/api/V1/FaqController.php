<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends ApiController
{
    public function index(Request $request): JsonResponse
    {
        $query = Faq::active()->ordered();

        if ($request->filled('category') && array_key_exists($request->input('category'), Faq::CATEGORIES)) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $term = '%'.trim($request->input('search')).'%';
            $query->where(function ($q) use ($term) {
                $q->where('question', 'like', $term)->orWhere('answer', 'like', $term);
            });
        }

        $faqs = $query->get();

        $categoryCounts = Faq::active()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return $this->ok([
            'faqs' => FaqResource::collection($faqs),
            'grouped' => $this->groupByCategory($faqs),
            'categories' => Faq::CATEGORIES,
            'category_counts' => $categoryCounts,
            'total' => Faq::active()->count(),
        ], 'FAQs retrieved.');
    }

    protected function groupByCategory($faqs): array
    {
        return $faqs->groupBy('category')
            ->map(fn ($items, $category) => [
                'category' => $category,
                'label' => Faq::CATEGORIES[$category]['label'] ?? ucwords(str_replace('_', ' ', $category)),
                'icon' => Faq::CATEGORIES[$category]['icon'] ?? '❓',
                'faqs' => FaqResource::collection($items),
            ])
            ->values()
            ->toArray();
    }
}
