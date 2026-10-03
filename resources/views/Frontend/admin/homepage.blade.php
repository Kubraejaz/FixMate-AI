@extends('Frontend.layouts.admin')

@section('title', 'Homepage CMS & Content Editor — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Homepage CMS &amp; Content Editor</h1>
        <p>Create, update, and manage all public homepage copy, hero imagery, workflow steps, and homeowner testimonials.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ url('/') }}" target="_blank" class="adm-btn adm-btn-ghost">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="2" y1="12" x2="22" y2="12"></line>
                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
            Live Homepage Preview &rarr;
        </a>
    </div>
</div>

@if(session('success'))
    <div style="background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 13.5px; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
        <span>✓ {{ session('success') }}</span>
        <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:#166534;cursor:pointer;font-weight:700;">×</button>
    </div>
@endif

@if($errors->any())
    <div style="background: #FFF1F2; border: 1px solid #FECDD3; color: #9F1239; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-size: 13px;">
        <strong style="display: block; margin-bottom: 4px;">Please correct the following:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Section 1: Hero & Guarantee Editor -->
<div class="adm-card" style="margin-bottom: 30px;">
    <div class="adm-card-head" style="border-bottom: 1px solid var(--adm-border-soft); padding-bottom: 16px;">
        <div>
            <h3>1. Hero Section &amp; Primary Imagery</h3>
            <span class="sub" style="font-size: 12.5px; color: var(--adm-muted);">Manage headline typography, subtitle, backdrop script, and hero graphics.</span>
        </div>
        <span class="adm-badge yellow">Primary Landing Fold</span>
    </div>

    <form method="POST" action="{{ route('admin.homepage.hero') }}" enctype="multipart/form-data" style="margin-top: 20px;">
        @csrf

        <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 24px;">
            <!-- Left Form Fields -->
            <div>
                <div class="adm-field">
                    <label>Pill Badge Tag</label>
                    <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings->hero_badge) }}" class="adm-input" required>
                </div>

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label>Main Headline Prefix</label>
                        <input type="text" name="hero_title_main" value="{{ old('hero_title_main', $settings->hero_title_main) }}" class="adm-input" required>
                    </div>
                    <div class="adm-field">
                        <label>Highlight Word (Yellow Accent)</label>
                        <input type="text" name="hero_title_highlight" value="{{ old('hero_title_highlight', $settings->hero_title_highlight) }}" class="adm-input" required>
                    </div>
                </div>

                <div class="adm-field">
                    <label>Hero Subtitle Description</label>
                    <textarea name="hero_subtitle" rows="3" class="adm-textarea" required>{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                </div>

                <div class="adm-form-grid">
                    <div class="adm-field">
                        <label>Floating Card Heading</label>
                        <input type="text" name="hero_trusted_tag" value="{{ old('hero_trusted_tag', $settings->hero_trusted_tag) }}" class="adm-input">
                    </div>
                    <div class="adm-field">
                        <label>Backdrop Cursive Script</label>
                        <input type="text" name="hero_script_text" value="{{ old('hero_script_text', $settings->hero_script_text) }}" class="adm-input">
                    </div>
                </div>

                <div style="background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 14px; padding: 18px; margin-top: 10px;">
                    <strong style="display: block; font-size: 13.5px; color: var(--adm-ink); margin-bottom: 12px;">FixMate AI Guarantee Parameters</strong>
                    
                    <div class="adm-form-grid">
                        <div class="adm-field" style="margin-bottom: 0;">
                            <label>Guarantee Title</label>
                            <input type="text" name="guarantee_title" value="{{ old('guarantee_title', $settings->guarantee_title) }}" class="adm-input" required>
                        </div>
                        <div class="adm-field" style="margin-bottom: 0;">
                            <label>Warranty Days</label>
                            <input type="number" name="warranty_days" value="{{ old('warranty_days', $settings->warranty_days) }}" class="adm-input" required min="1" max="365">
                        </div>
                    </div>
                    <div class="adm-field" style="margin-top: 14px; margin-bottom: 0;">
                        <label>Guarantee Subtitle Description</label>
                        <input type="text" name="guarantee_subtitle" value="{{ old('guarantee_subtitle', $settings->guarantee_subtitle) }}" class="adm-input" required>
                    </div>
                </div>
            </div>

            <!-- Right Hero Image Preview & Selector -->
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: var(--adm-ink); margin-bottom: 8px;">
                    Current Hero Graphic Preview
                </label>
                <div style="background: #FFFBEB; border: 1.5px dashed #FDE68A; border-radius: 16px; padding: 20px; text-align: center; margin-bottom: 16px; position: relative;">
                    <img src="{{ asset($settings->hero_image) }}" alt="Hero Preview" style="max-height: 220px; width: auto; object-fit: contain; display: inline-block;">
                    <span style="position: absolute; bottom: 10px; right: 10px; background: rgba(15,23,42,0.75); color: #FFF; font-size: 10.5px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        Active Asset
                    </span>
                </div>

                <div class="adm-field">
                    <label>Select from Image Catalog</label>
                    <select name="hero_image" class="adm-select">
                        @foreach($availableImages as $path => $label)
                            <option value="{{ $path }}" {{ $settings->hero_image === $path ? 'selected' : '' }}>
                                {{ $label }} ({{ basename($path) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="adm-field">
                    <label>Or Upload New Hero Image (.png, .webp, .jpg)</label>
                    <input type="file" name="hero_image_file" accept="image/*" class="adm-input" style="padding-top: 8px; height: auto;">
                    <span style="font-size: 11px; color: var(--adm-muted); margin-top: 4px; display: block;">Transparent PNG recommended for best fit with the yellow hero arc.</span>
                </div>

                <button type="submit" class="adm-btn adm-btn-primary" style="width: 100%; height: 44px; margin-top: 10px; font-size: 14px;">
                    ✓ Save Hero &amp; Guarantee Updates
                </button>
            </div>
        </div>

    </form>
</div>

<!-- Section 2: Homeowner Testimonials (Full CRUD) -->
<div class="adm-card" style="margin-bottom: 30px;">
    <div class="adm-card-head" style="border-bottom: 1px solid var(--adm-border-soft); padding-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3>2. Homeowner Testimonials &amp; Verified Reviews ({{ $testimonials->count() }})</h3>
            <span class="sub" style="font-size: 12.5px; color: var(--adm-muted);">Add, edit, or remove customer stories featured on the public homepage.</span>
        </div>
        <button type="button" class="adm-btn adm-btn-primary adm-btn-sm" onclick="document.getElementById('addTestimonialForm').style.display = document.getElementById('addTestimonialForm').style.display === 'none' ? 'block' : 'none';">
            + Add New Testimonial
        </button>
    </div>

    <!-- Collapsible Add Testimonial Form -->
    <div id="addTestimonialForm" style="display: none; background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 14px; padding: 22px; margin: 20px 0;">
        <strong style="display: block; font-size: 14px; color: var(--adm-ink); margin-bottom: 14px;">Publish New Customer Review</strong>
        <form method="POST" action="{{ route('admin.homepage.testimonials.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="adm-form-grid">
                <div class="adm-field">
                    <label>Customer Full Name</label>
                    <input type="text" name="name" class="adm-input" placeholder="e.g. Ayesha Siddiqui" required>
                </div>
                <div class="adm-field">
                    <label>Location / City</label>
                    <input type="text" name="location" class="adm-input" placeholder="e.g. Karachi — Clifton" required>
                </div>
            </div>

            <div class="adm-form-grid">
                <div class="adm-field">
                    <label>Service / Trade Name</label>
                    <input type="text" name="trade" class="adm-input" placeholder="e.g. Master Plumbing" required>
                </div>
                <div class="adm-field">
                    <label>Rating (1 to 5 Stars)</label>
                    <select name="rating" class="adm-select" required>
                        <option value="5" selected>★★★★★ (5 Stars)</option>
                        <option value="4">★★★★☆ (4 Stars)</option>
                        <option value="3">★★★☆☆ (3 Stars)</option>
                    </select>
                </div>
            </div>

            <div class="adm-field">
                <label>Review Comment / Quote</label>
                <textarea name="comment" rows="2" class="adm-textarea" placeholder="What did the customer say about the repair and pricing?" required></textarea>
            </div>

            <div class="adm-form-grid">
                <div class="adm-field">
                    <label>Select Preset Avatar</label>
                    <select name="avatar" class="adm-select">
                        <option value="assets/images/image_1.png">Avatar 1</option>
                        <option value="assets/images/image_2.png" selected>Avatar 2 (Woman in Navy)</option>
                        <option value="assets/images/image_3.png">Avatar 3 (Doctor/Elderly)</option>
                        <option value="assets/images/image_4.png">Avatar 4 (Young Man)</option>
                    </select>
                </div>
                <div class="adm-field">
                    <label>Or Upload Custom Photo</label>
                    <input type="file" name="avatar_file" accept="image/*" class="adm-input" style="padding-top: 8px;">
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" class="adm-btn adm-btn-primary">Publish Testimonial</button>
                <button type="button" class="adm-btn adm-btn-ghost" onclick="document.getElementById('addTestimonialForm').style.display='none';">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Testimonials Table -->
    <div class="adm-table-wrap" style="margin-top: 16px;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Location</th>
                    <th>Trade Tag</th>
                    <th>Rating</th>
                    <th>Customer Quote</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                    <tr>
                        <td>
                            <div class="adm-person">
                                <img src="{{ $t->avatar_url }}" alt="{{ $t->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1.5px solid var(--adm-accent);">
                                <div>
                                    <div class="pname">{{ $t->name }}</div>
                                    <div class="pmeta">Order #{{ $t->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $t->location }}</td>
                        <td><strong style="color: var(--adm-ink);">{{ $t->trade }}</strong></td>
                        <td><span style="color: #D97706; font-weight: 700;">★ {{ $t->rating }}.0</span></td>
                        <td style="max-width: 320px; font-size: 12.5px; color: #475569; line-height: 1.5;">
                            "{{ Str::limit($t->comment, 85) }}"
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.homepage.testimonials.destroy', $t) }}" onsubmit="return confirm('Delete this testimonial?');" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="adm-btn adm-btn-sm" style="background: #FFF1F2; color: #E11D48; border-color: #FECDD3; height: 28px; padding: 0 10px; font-size: 11.5px;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px; color: var(--adm-muted);">
                            No testimonials currently published. Click "+ Add New Testimonial" above.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Section 3: How FixMate AI Works Steps (Full CRUD) -->
<div class="adm-card">
    <div class="adm-card-head" style="border-bottom: 1px solid var(--adm-border-soft); padding-bottom: 16px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3>3. "How FixMate AI Works" Workflow Steps ({{ $steps->count() }})</h3>
            <span class="sub" style="font-size: 12.5px; color: var(--adm-muted);">Configure step order, emoji/icons, and process instructions.</span>
        </div>
        <button type="button" class="adm-btn adm-btn-primary adm-btn-sm" onclick="document.getElementById('addStepForm').style.display = document.getElementById('addStepForm').style.display === 'none' ? 'block' : 'none';">
            + Add Step
        </button>
    </div>

    <!-- Collapsible Add Step Form -->
    <div id="addStepForm" style="display: none; background: #F8FAFC; border: 1px solid var(--adm-border); border-radius: 14px; padding: 22px; margin: 20px 0;">
        <strong style="display: block; font-size: 14px; color: var(--adm-ink); margin-bottom: 14px;">Add Workflow Step</strong>
        <form method="POST" action="{{ route('admin.homepage.steps.store') }}">
            @csrf
            <div class="adm-form-grid">
                <div class="adm-field">
                    <label>Step Number</label>
                    <input type="number" name="step_number" value="{{ $steps->count() + 1 }}" class="adm-input" required min="1">
                </div>
                <div class="adm-field">
                    <label>Icon / Emoji</label>
                    <input type="text" name="icon" class="adm-input" placeholder="e.g. 📷, 🤖, 🧑‍🔧, 📍, ✓" required>
                </div>
            </div>

            <div class="adm-form-grid">
                <div class="adm-field">
                    <label>Step Title</label>
                    <input type="text" name="title" class="adm-input" placeholder="e.g. Describe Your Problem" required>
                </div>
                <div class="adm-field">
                    <label>Badge Color</label>
                    <select name="badge_color" class="adm-select" required>
                        <option value="#FFC107">Yellow / Gold (#FFC107)</option>
                        <option value="#10B981">Emerald Green (#10B981)</option>
                        <option value="#2563EB">Royal Blue (#2563EB)</option>
                    </select>
                </div>
            </div>

            <div class="adm-field">
                <label>Step Description</label>
                <input type="text" name="description" class="adm-input" placeholder="e.g. Share details or upload defect photos." required>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 10px;">
                <button type="submit" class="adm-btn adm-btn-primary">Add Step</button>
                <button type="button" class="adm-btn adm-btn-ghost" onclick="document.getElementById('addStepForm').style.display='none';">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Steps Table -->
    <div class="adm-table-wrap" style="margin-top: 16px;">
        <table class="adm-table">
            <thead>
                <tr>
                    <th style="width: 70px;">Step #</th>
                    <th style="width: 70px;">Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Badge Color</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($steps as $s)
                    <tr>
                        <td>
                            <div style="width: 28px; height: 28px; border-radius: 50%; background: {{ $s->badge_color }}; color: #0F172A; font-weight: 800; font-size: 13px; display: flex; align-items: center; justify-content: center;">
                                {{ $s->step_number }}
                            </div>
                        </td>
                        <td style="font-size: 22px;">{{ $s->icon }}</td>
                        <td><strong style="color: var(--adm-ink);">{{ $s->title }}</strong></td>
                        <td style="color: var(--adm-muted); font-size: 13px;">{{ $s->description }}</td>
                        <td>
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700;">
                                <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background: {{ $s->badge_color }};"></span>
                                {{ $s->badge_color }}
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" action="{{ route('admin.homepage.steps.destroy', $s) }}" onsubmit="return confirm('Remove step #{{ $s->step_number }}?');" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="adm-btn adm-btn-sm" style="background: #FFF1F2; color: #E11D48; border-color: #FECDD3; height: 28px; padding: 0 10px; font-size: 11.5px;">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 36px; color: var(--adm-muted);">
                            No workflow steps defined.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
