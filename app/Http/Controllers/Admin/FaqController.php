<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    /**
     * Display FAQ management catalog with stats and filters.
     */
    public function index(Request $request): View
    {
        $query = Faq::query();

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('status')) {
            if ($request->input('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->input('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $term = '%' . trim($request->input('search')) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('question', 'like', $term)
                  ->orWhere('answer', 'like', $term);
            });
        }

        $faqs = $query->ordered()->paginate(12)->withQueryString();

        $stats = [
            'total' => Faq::count(),
            'active' => Faq::where('is_active', true)->count(),
            'inactive' => Faq::where('is_active', false)->count(),
            'categories' => count(Faq::CATEGORIES),
        ];

        return view('Frontend.admin.faqs', [
            'faqs' => $faqs,
            'stats' => $stats,
            'categories' => Faq::CATEGORIES,
        ]);
    }

    /**
     * Store a newly created FAQ.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(Faq::CATEGORIES))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $sortOrder = $validated['sort_order'] ?? (Faq::max('sort_order') + 1);

        Faq::create([
            'question' => trim($validated['question']),
            'answer' => trim($validated['answer']),
            'category' => $validated['category'],
            'sort_order' => $sortOrder,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.faqs')
            ->with('success', 'FAQ question has been added successfully.');
    }

    /**
     * Update an existing FAQ.
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(Faq::CATEGORIES))],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $faq->update([
            'question' => trim($validated['question']),
            'answer' => trim($validated['answer']),
            'category' => $validated['category'],
            'sort_order' => $validated['sort_order'] ?? $faq->sort_order,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.faqs')
            ->with('success', "FAQ '{$faq->question}' updated successfully.");
    }

    /**
     * Delete an FAQ.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $title = $faq->question;
        $faq->delete();

        return redirect()->route('admin.faqs')
            ->with('success', "FAQ '{$title}' has been removed.");
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggle(Request $request, Faq $faq): JsonResponse|RedirectResponse
    {
        $faq->is_active = ! $faq->is_active;
        $faq->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $faq->is_active,
                'message' => $faq->is_active ? 'FAQ published to live site.' : 'FAQ unpublished and hidden from public.',
            ]);
        }

        return redirect()->back()->with('success', $faq->is_active ? 'FAQ published.' : 'FAQ unpublished.');
    }
}
