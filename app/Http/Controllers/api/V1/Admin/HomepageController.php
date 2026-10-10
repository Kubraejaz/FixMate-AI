<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\ApiController;
use App\Http\Resources\HomepageSettingResource;
use App\Http\Resources\TestimonialResource;
use App\Http\Resources\WorkflowStepResource;
use App\Models\HomepageSetting;
use App\Models\Testimonial;
use App\Models\WorkflowStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomepageController extends ApiController
{
    public function index(): JsonResponse
    {
        $settings = HomepageSetting::instance();

        $availableImages = [
            'assets/images/image_8.png' => 'Technician with toolkit (Current Hero)',
            'assets/images/image_7.png' => 'Modern living room with smart appliances',
            'assets/images/Cleaning_Professional.png' => 'Cleaning Specialist in uniform',
            'assets/images/image_1.png' => 'Specialist Portrait 1',
            'assets/images/image_2.png' => 'Specialist Portrait 2',
            'assets/images/image_3.png' => 'Specialist Portrait 3',
            'assets/images/image_4.png' => 'Specialist Portrait 4',
        ];

        return $this->ok([
            'settings' => new HomepageSettingResource($settings),
            'testimonials' => TestimonialResource::collection(Testimonial::orderBy('display_order')->get()),
            'steps' => WorkflowStepResource::collection(WorkflowStep::orderBy('step_number')->get()),
            'available_images' => collect($availableImages)->map(fn ($label, $path) => [
                'path' => $path,
                'label' => $label,
                'url' => asset($path),
            ])->values(),
        ], 'Homepage CMS retrieved.');
    }

    public function updateHero(Request $request): JsonResponse
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

        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = 'hero_'.time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $validated['hero_image'] = 'assets/images/'.$filename;
        }

        unset($validated['hero_image_file']);
        $settings->update($validated);

        return $this->ok(new HomepageSettingResource($settings->fresh()), 'Homepage Hero & Guarantee sections updated successfully.');
    }

    public function storeTestimonial(Request $request): JsonResponse
    {
        $validated = $this->validateTestimonial($request);

        if ($request->hasFile('avatar_file')) {
            $validated['avatar'] = $this->storeAvatar($request);
        } elseif (empty($validated['avatar'])) {
            $validated['avatar'] = 'assets/images/image_2.png';
        }

        unset($validated['avatar_file']);
        $validated['is_featured'] = true;
        $validated['display_order'] = Testimonial::count() + 1;

        $testimonial = Testimonial::create($validated);

        return $this->created(new TestimonialResource($testimonial), 'New homeowner testimonial published on homepage.');
    }

    public function updateTestimonial(Request $request, Testimonial $testimonial): JsonResponse
    {
        $validated = $this->validateTestimonial($request);

        if ($request->hasFile('avatar_file')) {
            $validated['avatar'] = $this->storeAvatar($request);
        }

        unset($validated['avatar_file']);
        $testimonial->update($validated);

        return $this->ok(new TestimonialResource($testimonial->fresh()), "Testimonial from {$testimonial->name} updated.");
    }

    public function destroyTestimonial(Testimonial $testimonial): JsonResponse
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return $this->ok(null, "Testimonial from {$name} deleted.");
    }

    public function storeStep(Request $request): JsonResponse
    {
        $validated = $this->validateStep($request);
        $validated['is_active'] = true;

        $step = WorkflowStep::create($validated);

        return $this->created(new WorkflowStepResource($step), 'Workflow step added to homepage.');
    }

    public function updateStep(Request $request, WorkflowStep $step): JsonResponse
    {
        $validated = $this->validateStep($request);
        $step->update($validated);

        return $this->ok(new WorkflowStepResource($step->fresh()), "Workflow step #{$step->step_number} updated.");
    }

    public function destroyStep(WorkflowStep $step): JsonResponse
    {
        $num = $step->step_number;
        $step->delete();

        return $this->ok(null, "Step #{$num} removed from workflow.");
    }

    private function validateTestimonial(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'trade' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string'],
            'avatar' => ['nullable', 'string'],
            'avatar_file' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function validateStep(Request $request): array
    {
        return $request->validate([
            'step_number' => ['required', 'integer', 'min:1'],
            'icon' => ['required', 'string', 'max:30'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'badge_color' => ['required', 'string', 'max:20'],
        ]);
    }

    private function storeAvatar(Request $request): string
    {
        $file = $request->file('avatar_file');
        $filename = 'testimonial_'.time().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('assets/images'), $filename);

        return 'assets/images/'.$filename;
    }
}
