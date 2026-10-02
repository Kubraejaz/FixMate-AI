<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display public FAQs with search and category filtering.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category');
        $searchTerm = $request->query('search');

        $query = Faq::active()->ordered();

        if ($selectedCategory && array_key_exists($selectedCategory, Faq::CATEGORIES)) {
            $query->where('category', $selectedCategory);
        }

        if ($searchTerm) {
            $term = '%' . trim($searchTerm) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('question', 'like', $term)
                  ->orWhere('answer', 'like', $term);
            });
        }

        $faqs = $query->get();

        // Group FAQs by category for clean sectioned display
        $groupedFaqs = $faqs->groupBy('category');

        // Total count of active FAQs in the system
        $totalActiveCount = Faq::active()->count();

        // Count per category
        $categoryCounts = Faq::active()
            ->selectRaw('category, count(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return view('Frontend.public.faqs', [
            'faqs' => $faqs,
            'groupedFaqs' => $groupedFaqs,
            'categories' => Faq::CATEGORIES,
            'selectedCategory' => $selectedCategory,
            'searchTerm' => $searchTerm,
            'totalActiveCount' => $totalActiveCount,
            'categoryCounts' => $categoryCounts,
        ]);
    }
}
