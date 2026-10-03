<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\Profession;
use App\Models\Testimonial;
use App\Models\WorkflowStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomepageController extends Controller
{
    /**
     * Display the Homepage CMS portal where the admin can manage all sections,
     * hero imagery, copy, workflow steps, and homeowner testimonials.
     */
    public function index(): View
    {
        $settings = HomepageSetting::instance();
        $testimonials = Testimonial::orderBy('display_order')->get();
        $steps = WorkflowStep::orderBy('step_number')->get();
        $professions = Profession::where('is_active', true)->get();

        $availableImages = [
            'assets/images/image_8.png' => 'Technician with toolkit (Current Hero)',
            'assets/images/image_7.png' => 'Modern living room with smart appliances',
            'assets/images/Cleaning_Professional.png' => 'Cleaning Specialist in uniform',
            'assets/images/image_1.png' => 'Specialist Portrait 1',
            'assets/images/image_2.png' => 'Specialist Portrait 2',
            'assets/images/image_3.png' => 'Specialist Portrait 3',
            'assets/images/image_4.png' => 'Specialist Portrait 4',
        ];

        return view('Frontend.admin.homepage', compact(
            'settings',
            'testimonials',
            'steps',
            'professions',
            'availableImages'
        ));
    }

    /**
     * Update Hero & Guarantee copy and primary imagery.
     */
    public function updateHero(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => ['required', 'string', 'max:255'],
            'hero_title_main' => ['required', 'string', 'max:255'],
            'hero_title_highlight' => ['required', 'string', 'max:100'],
            'hero_subtitle' => ['required', 'string'],
            'hero_script_text' => ['nullable', 'string', 'max:150'],
            'hero_trusted_tag' => ['nullable', 'string', 'max:200'],
            'guarantee_title' => ['required', 'string', 'max:255'],
            'guarantee_subtitle' => ['required', 'string'],
            'warranty_days' => ['required', 'integer', 'min:1', 'max:365'],
            'hero_image' => ['nullable', 'string'],
            'hero_image_file' => ['nullable', 'image', 'max:4096'],
        ]);

        $settings = HomepageSetting::instance();

        // Handle custom image upload if provided
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $validated['hero_image'] = 'assets/images/' . $filename;
        }

        unset($validated['hero_image_file']);
        $settings->update($validated);

        return back()->with('success', 'Homepage Hero & Guarantee sections updated successfully.');
    }

    /**
     * Store a new homeowner testimonial / review.
     */
    public function storeTestimonial(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'trade' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = 'testimonial_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $validated['avatar'] = 'assets/images/' . $filename;
        } elseif (empty($validated['avatar'])) {
            $validated['avatar'] = 'assets/images/image_2.png';
        }

        unset($validated['avatar_file']);
        $validated['is_featured'] = true;
        $validated['display_order'] = Testimonial::count() + 1;

        Testimonial::create($validated);

        return back()->with('success', 'New homeowner testimonial published on homepage.');
    }

    /**
     * Update an existing testimonial.
     */
    public function updateTestimonial(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'trade' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $filename = 'testimonial_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $validated['avatar'] = 'assets/images/' . $filename;
        }

        unset($validated['avatar_file']);
        $testimonial->update($validated);

        return back()->with('success', "Testimonial from {$testimonial->name} updated.");
    }

    /**
     * Delete a testimonial.
     */
    public function destroyTestimonial(Testimonial $testimonial): RedirectResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimonial from {$name} deleted.");
    }

    /**
     * Store a new workflow step.
     */
    public function storeStep(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'step_number' => ['required', 'integer', 'min:1'],
            'icon' => ['required', 'string', 'max:30'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'badge_color' => ['required', 'string', 'max:20'],
        ]);

        $validated['is_active'] = true;
        WorkflowStep::create($validated);

        return back()->with('success', 'Workflow step added to homepage.');
    }

    /**
     * Update an existing workflow step.
     */
    public function updateStep(Request $request, WorkflowStep $step): RedirectResponse
    {
        $validated = $request->validate([
            'step_number' => ['required', 'integer', 'min:1'],
            'icon' => ['required', 'string', 'max:30'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'badge_color' => ['required', 'string', 'max:20'],
        ]);

        $step->update($validated);

        return back()->with('success', "Workflow step #{$step->step_number} updated.");
    }

    /**
     * Delete a workflow step.
     */
    public function destroyStep(WorkflowStep $step): RedirectResponse
    {
        $num = $step->step_number;
        $step->delete();

        return back()->with('success', "Step #{$num} removed from workflow.");
    }
}
