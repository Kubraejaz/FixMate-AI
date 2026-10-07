@extends('Frontend.layouts.admin')

@section('title', 'Services & Professions Catalog — FixMate Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <h1>Services &amp; Professions Catalog</h1>
        <p>Manage dynamic services displayed across the website, registration dropdowns, and search filters with upfront pricing and scope features.</p>
    </div>
    <div class="adm-page-actions">
        <button type="button" class="adm-btn adm-btn-primary" onclick="openAddServiceModal()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Add New Service
        </button>
    </div>
</div>

<!-- Flash Alerts -->
@if(session('success'))
    <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; color: #166534; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">✓</span>
            <span>{{ session('success') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #166534;">&times;</button>
    </div>
@endif

@if(session('error'))
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; font-size: 13.5px; font-weight: 600;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 18px;">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 18px; cursor: pointer; color: #991B1B;">&times;</button>
    </div>
@endif

@if($errors->any())
    <div style="background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; padding: 14px 18px; border-radius: 12px; margin-bottom: 22px; font-size: 13px;">
        <strong style="display: block; margin-bottom: 6px;">Please correct the errors below:</strong>
        <ul style="margin: 0; padding-left: 20px;">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Summary KPIs -->
<div class="adm-kpi-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 24px;">
    
    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Total Services</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft); color: #B45309;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total'] ?? $services->count() }}</div>
        <div class="kpi-foot">Defined in database</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Active On Website</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft); color: var(--adm-success);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-success);">{{ $stats['active'] ?? $services->where('is_active', true)->count() }}</div>
        <div class="kpi-foot up">Live for customer bookings</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Inactive / Drafts</span>
            <span class="kpi-icon" style="background: #F1F5F9; color: var(--adm-muted);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-muted);">{{ $stats['inactive'] ?? $services->where('is_active', false)->count() }}</div>
        <div class="kpi-foot">Hidden from public views</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Active Technicians</span>
            <span class="kpi-icon" style="background: var(--adm-info-soft); color: var(--adm-info);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total_technicians'] ?? 0 }}</div>
        <div class="kpi-foot">Distributed across trades</div>
    </div>

</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 16px 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.categories') }}" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 260px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search service name, slug, or keywords..." class="adm-input" style="padding-left: 38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="position: absolute; left: 13px; top: 13px; color: var(--adm-faint);">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <div style="width: 180px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
            </select>
        </div>

        <button type="submit" class="adm-btn adm-btn-secondary" style="height: 42px;">
            Filter
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('admin.categories') }}" class="adm-btn" style="height: 42px; text-decoration: none; color: var(--adm-muted); background: #F1F5F9;">
                Clear
            </a>
        @endif

    </form>
</div>

<!-- Services Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 22px; margin-bottom: 40px;">
    
    @forelse($services as $svc)
        <div class="adm-card" style="display: flex; flex-direction: column; justify-content: space-between; border-top: 4px solid {{ $svc->is_active ? 'var(--adm-accent)' : 'var(--adm-border)' }}; transition: transform 0.15s ease, box-shadow 0.15s ease; padding: 22px;">
            
            <div>
                <!-- Card Header -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 50px; height: 50px; border-radius: 14px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                            {{ $svc->display_icon }}
                        </div>
                        <div>
                            <h3 style="font-size: 16px; font-weight: 800; color: var(--adm-ink); margin-bottom: 2px;">{{ $svc->name }}</h3>
                            <span style="font-size: 11.5px; color: var(--adm-muted); font-family: monospace;">/services/{{ $svc->slug }}</span>
                        </div>
                    </div>

                    <!-- Active Toggle Form -->
                    <form action="{{ route('admin.categories.toggle', $svc->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="adm-badge {{ $svc->is_active ? 'green' : 'gray' }}" style="cursor: pointer; border: none; padding: 4px 10px; font-weight: 700;" title="Click to toggle status">
                            {{ $svc->is_active ? '● Active' : '○ Inactive' }}
                        </button>
                    </form>
                </div>

                <!-- Price and Duration Strip -->
                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 14px;">
                    <span style="font-size: 13px; font-weight: 800; color: #0F172A; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 10px; border-radius: 8px;">
                        Rs. {{ number_format($svc->base_price) }} <span style="font-size: 11px; font-weight: 600; color: #64748B;">{{ $svc->price_unit }}</span>
                    </span>
                    <span style="font-size: 11.5px; font-weight: 700; color: #475569; background: #F1F5F9; padding: 4px 10px; border-radius: 8px;">
                        ⏱ {{ $svc->estimated_duration ?: '30 – 60 mins' }}
                    </span>
                    <span style="font-size: 11.5px; font-weight: 700; color: #0369A1; background: #E0F2FE; padding: 4px 10px; border-radius: 8px;">
                        🛡️ {{ $svc->warranty_text ?: '60-Day Re-work' }}
                    </span>
                </div>

                <!-- Description -->
                <p style="font-size: 13px; color: var(--adm-body); line-height: 1.5; margin-bottom: 14px;">
                    {{ $svc->description ?: 'No detailed description set for this service category.' }}
                </p>

                <!-- Sub-Categories Badges -->
                @if(!empty($svc->sub_categories_list))
                    <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px;">
                        <div style="font-weight: 800; color: #92400E; margin-bottom: 6px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.04em;">
                            Sub-Categories ({{ count($svc->sub_categories_list) }}):
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                            @foreach($svc->sub_categories_list as $subCat)
                                <span style="font-size: 11px; font-weight: 700; color: #0F172A; background: #FFFFFF; border: 1px solid #E2E8F0; padding: 2px 7px; border-radius: 6px;">
                                    {{ $subCat }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Key Feature Points Preview -->
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; font-size: 12px; color: #475569;">
                    <div style="font-weight: 700; color: #0F172A; margin-bottom: 6px; font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.03em;">Key Features / Scope:</div>
                    @foreach($svc->feature_points_list as $point)
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 3px;">
                            <span style="color: #059669; font-weight: 900;">✓</span>
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $point }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card Bottom Bar -->
            <div>
                <div style="border-top: 1px solid var(--adm-border-soft); padding: 12px 0; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px;">
                    <span style="color: var(--adm-muted); display: flex; align-items: center; gap: 6px;">
                        <span>🧑‍🔧</span>
                        <strong>{{ $svc->professionals_count }}</strong> assigned technician(s)
                    </span>
                    <a href="{{ url('/services/' . $svc->slug) }}" target="_blank" style="color: var(--adm-info); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
                        Preview Live ↗
                    </a>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <button type="button" class="adm-btn adm-btn-secondary" style="font-size: 12.5px; padding: 8px 12px; justify-content: center;" onclick="openEditModal({{ json_encode($svc) }})">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                        </svg>
                        Edit
                    </button>

                    <button type="button" class="adm-btn adm-btn-danger" style="font-size: 12.5px; padding: 8px 12px; justify-content: center;" onclick="confirmDeleteService({{ $svc->id }}, '{{ addslashes($svc->name) }}', {{ $svc->professionals_count }})">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>

        </div>
    @empty
        <div style="grid-column: 1 / -1;" class="adm-card adm-empty">
            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            <p><strong>No services found matching your criteria.</strong></p>
            <p class="sub">Try clearing your filters or create a new service category above.</p>
        </div>
    @endforelse

</div>


<!-- ======================================================== -->
<!-- MODAL: ADD SERVICE                                       -->
<!-- ======================================================== -->
<div id="addServiceModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 32px; box-shadow: 0 25px 50px rgba(0,0,0,0.25); position: relative; animation: modalPop 0.2s ease;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #E2E8F0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #FFF9E6; border: 1px solid #FEF08A; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    ✨
                </div>
                <div>
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--adm-ink); margin: 0;">Add New Service</h2>
                    <span style="font-size: 12.5px; color: var(--adm-muted);">Create dynamic service with upfront pricing, scope, and guarantees.</span>
                </div>
            </div>
            <button type="button" onclick="closeAddServiceModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="adm-field">
                    <label for="addServiceName">Service Name *</label>
                    <input type="text" id="addServiceName" name="name" required placeholder="e.g. Solar & Inverter Specialist" class="adm-input" onkeyup="autoGenerateSlug(this.value)">
                </div>

                <div class="adm-field">
                    <label for="addServiceSlug">URL Slug (lowercase-with-hyphens)</label>
                    <input type="text" id="addServiceSlug" name="slug" placeholder="e.g. solar-specialist" class="adm-input">
                </div>
            </div>

            <!-- Icon Picker -->
            <div class="adm-field">
                <label for="addServiceIcon">Service Icon / Emoji</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="addServiceIcon" name="icon" value="🔧" class="adm-input" style="max-width: 120px; font-size: 18px; text-align: center;">
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        @foreach(['💧', '⚡', '❄️', '🧹', '🖌️', '🔨', '🧺', '📹', '☀️', '🔧', '🚪', '🛡️'] as $em)
                            <button type="button" onclick="document.getElementById('addServiceIcon').value='{{ $em }}'" style="border: 1px solid #E2E8F0; background: #F8FAFC; border-radius: 8px; padding: 4px 8px; font-size: 16px; cursor: pointer;">{{ $em }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pricing & Duration Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="addServicePrice">Base Labor Price (PKR) *</label>
                    <input type="number" id="addServicePrice" name="base_price" required value="750" min="0" step="50" class="adm-input">
                </div>

                <div class="adm-field">
                    <label for="addServicePriceUnit">Price Unit</label>
                    <select id="addServicePriceUnit" name="price_unit" class="adm-select">
                        <option value="base" selected>base (Starting rate)</option>
                        <option value="service">service (Fixed fee)</option>
                        <option value="package">package</option>
                        <option value="/ sq.ft">/ sq.ft</option>
                        <option value="diagnosis">diagnosis</option>
                        <option value="visit">visit</option>
                    </select>
                </div>

                <div class="adm-field">
                    <label for="addServiceDuration">Estimated Duration</label>
                    <input type="text" id="addServiceDuration" name="estimated_duration" value="30 – 50 mins" class="adm-input" placeholder="e.g. 30 – 50 mins">
                </div>
            </div>

            <!-- Headline & Warranty -->
            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="addServiceHeadline">Details Page Headline</label>
                    <input type="text" id="addServiceHeadline" name="headline" class="adm-input" placeholder="e.g. Ultrasonic Leak Detection & Pipe Repair">
                </div>

                <div class="adm-field">
                    <label for="addServiceWarranty">Warranty Coverage</label>
                    <input type="text" id="addServiceWarranty" name="warranty_text" value="60-Day Re-work Free" class="adm-input">
                </div>
            </div>

            <!-- Image Selection -->
            <div class="adm-field">
                <label for="addServiceImage">Banner Image Asset</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <select id="addServiceImage" name="image" class="adm-select">
                        <option value="assets/images/image_3.png" selected>assets/images/image_3.png (Plumbing / Workshop)</option>
                        <option value="assets/images/image_2.png">assets/images/image_2.png (Electrical / Wiring)</option>
                        <option value="assets/images/image_1.png">assets/images/image_1.png (HVAC / Appliances)</option>
                        <option value="assets/images/image_4.png">assets/images/image_4.png (Cleaning / Janitorial)</option>
                        <option value="assets/images/image_8.png">assets/images/image_8.png (Modern Home Service)</option>
                    </select>
                    <input type="file" name="image_file" accept="image/*" class="adm-input" style="font-size: 12px; padding: 7px 10px;">
                </div>
            </div>

            <!-- Sub-Categories Field -->
            <div class="adm-field">
                <label for="addServiceSubCategories">Sub-Categories &amp; Specialized Capabilities (One per line or comma-separated)</label>
                <textarea id="addServiceSubCategories" name="sub_categories" rows="3" class="adm-textarea" placeholder="Pipe Leakage & Repair&#10;Sanitary Fittings & Taps&#10;Water Tank Cleaning&#10;Motor & Water Pump"></textarea>
                <span style="font-size: 11.5px; color: var(--adm-muted); margin-top: 4px; display: block;">
                    These sub-categories appear as skills for technicians and filter tags across public and customer portals.
                </span>
            </div>

            <!-- Bullet Points Textarea -->
            <div class="adm-field">
                <label for="addServiceFeatures">Key Features (One bullet per line, shown on service cards)</label>
                <textarea id="addServiceFeatures" name="feature_points" rows="3" class="adm-textarea" placeholder="Pipe leak repair & Teflon sealing&#10;Electric/Gas geyser heating element overhaul&#10;Water pressure motor suction calibration"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="addServiceIncluded">What's Included (One per line)</label>
                    <textarea id="addServiceIncluded" name="included_items" rows="3" class="adm-textarea" placeholder="Ultrasonic joint leak inspection&#10;Slip washer Teflon replacement&#10;60-day rework warranty"></textarea>
                </div>

                <div class="adm-field">
                    <label for="addServiceExcluded">What's Excluded / Extra (One per line)</label>
                    <textarea id="addServiceExcluded" name="excluded_items" rows="3" class="adm-textarea" placeholder="Spare brass mixer hardware&#10;Excavation beyond 2 feet"></textarea>
                </div>
            </div>

            <div class="adm-field">
                <label for="addServiceDesc">Short Description</label>
                <textarea id="addServiceDesc" name="description" rows="2" class="adm-textarea" placeholder="Brief summary of trade and skills..."></textarea>
            </div>

            <div class="adm-field" style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                <input type="checkbox" id="addServiceActive" name="is_active" value="1" checked style="width: 18px; height: 18px; accent-color: var(--adm-accent);">
                <label for="addServiceActive" style="margin-bottom: 0; cursor: pointer; font-size: 13.5px; font-weight: 700;">Make visible immediately on public website and registration forms</label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 14px; border-top: 1px solid #E2E8F0;">
                <button type="button" class="adm-btn adm-btn-secondary" style="flex: 1; justify-content: center;" onclick="closeAddServiceModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary" style="flex: 1.5; justify-content: center;">Create Service Category</button>
            </div>
        </form>

    </div>
</div>


<!-- ======================================================== -->
<!-- MODAL: EDIT SERVICE                                      -->
<!-- ======================================================== -->
<div id="editServiceModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px; overflow-y: auto;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 680px; width: 100%; max-height: 90vh; overflow-y: auto; padding: 32px; box-shadow: 0 25px 50px rgba(0,0,0,0.25); position: relative;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #E2E8F0;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #EFF6FF; border: 1px solid #BFDBFE; display: flex; align-items: center; justify-content: center; font-size: 22px;">
                    ✏️
                </div>
                <div>
                    <h2 style="font-size: 20px; font-weight: 800; color: var(--adm-ink); margin: 0;">Edit Service Category</h2>
                    <span style="font-size: 12.5px; color: var(--adm-muted);">Update pricing, scope features, guarantees, or active status.</span>
                </div>
            </div>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: var(--adm-muted);">&times;</button>
        </div>

        <form id="editServiceForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="adm-field">
                    <label for="editServiceName">Service Name *</label>
                    <input type="text" id="editServiceName" name="name" required class="adm-input">
                </div>

                <div class="adm-field">
                    <label for="editServiceSlug">URL Slug *</label>
                    <input type="text" id="editServiceSlug" name="slug" required class="adm-input">
                </div>
            </div>

            <!-- Icon Picker -->
            <div class="adm-field">
                <label for="editServiceIcon">Service Icon / Emoji</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="editServiceIcon" name="icon" class="adm-input" style="max-width: 120px; font-size: 18px; text-align: center;">
                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                        @foreach(['💧', '⚡', '❄️', '🧹', '🖌️', '🔨', '🧺', '📹', '☀️', '🔧', '🚪', '🛡️'] as $em)
                            <button type="button" onclick="document.getElementById('editServiceIcon').value='{{ $em }}'" style="border: 1px solid #E2E8F0; background: #F8FAFC; border-radius: 8px; padding: 4px 8px; font-size: 16px; cursor: pointer;">{{ $em }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Pricing & Duration Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="editServicePrice">Base Labor Price (PKR) *</label>
                    <input type="number" id="editServicePrice" name="base_price" required min="0" step="50" class="adm-input">
                </div>

                <div class="adm-field">
                    <label for="editServicePriceUnit">Price Unit</label>
                    <select id="editServicePriceUnit" name="price_unit" class="adm-select">
                        <option value="base">base (Starting rate)</option>
                        <option value="service">service (Fixed fee)</option>
                        <option value="package">package</option>
                        <option value="/ sq.ft">/ sq.ft</option>
                        <option value="diagnosis">diagnosis</option>
                        <option value="visit">visit</option>
                    </select>
                </div>

                <div class="adm-field">
                    <label for="editServiceDuration">Estimated Duration</label>
                    <input type="text" id="editServiceDuration" name="estimated_duration" class="adm-input">
                </div>
            </div>

            <!-- Headline & Warranty -->
            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="editServiceHeadline">Details Page Headline</label>
                    <input type="text" id="editServiceHeadline" name="headline" class="adm-input">
                </div>

                <div class="adm-field">
                    <label for="editServiceWarranty">Warranty Coverage</label>
                    <input type="text" id="editServiceWarranty" name="warranty_text" class="adm-input">
                </div>
            </div>

            <!-- Image Selection -->
            <div class="adm-field">
                <label for="editServiceImage">Banner Image Asset</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <select id="editServiceImage" name="image" class="adm-select">
                        <option value="assets/images/image_3.png">assets/images/image_3.png (Plumbing / Workshop)</option>
                        <option value="assets/images/image_2.png">assets/images/image_2.png (Electrical / Wiring)</option>
                        <option value="assets/images/image_1.png">assets/images/image_1.png (HVAC / Appliances)</option>
                        <option value="assets/images/image_4.png">assets/images/image_4.png (Cleaning / Janitorial)</option>
                        <option value="assets/images/image_8.png">assets/images/image_8.png (Modern Home Service)</option>
                    </select>
                    <input type="file" name="image_file" accept="image/*" class="adm-input" style="font-size: 12px; padding: 7px 10px;">
                </div>
            </div>

            <!-- Sub-Categories Field -->
            <div class="adm-field">
                <label for="editServiceSubCategories">Sub-Categories &amp; Specialized Capabilities (One per line or comma-separated)</label>
                <textarea id="editServiceSubCategories" name="sub_categories" rows="3" class="adm-textarea" placeholder="Pipe Leakage & Repair&#10;Sanitary Fittings & Taps&#10;Water Tank Cleaning"></textarea>
                <span style="font-size: 11.5px; color: var(--adm-muted); margin-top: 4px; display: block;">
                    These sub-categories appear as skills for technicians and filter tags across public and customer portals.
                </span>
            </div>

            <!-- Bullet Points Textarea -->
            <div class="adm-field">
                <label for="editServiceFeatures">Key Features (One bullet per line, shown on service cards)</label>
                <textarea id="editServiceFeatures" name="feature_points" rows="3" class="adm-textarea"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div class="adm-field">
                    <label for="editServiceIncluded">What's Included (One per line)</label>
                    <textarea id="editServiceIncluded" name="included_items" rows="3" class="adm-textarea"></textarea>
                </div>

                <div class="adm-field">
                    <label for="editServiceExcluded">What's Excluded / Extra (One per line)</label>
                    <textarea id="editServiceExcluded" name="excluded_items" rows="3" class="adm-textarea"></textarea>
                </div>
            </div>

            <div class="adm-field">
                <label for="editServiceDesc">Short Description</label>
                <textarea id="editServiceDesc" name="description" rows="2" class="adm-textarea"></textarea>
            </div>

            <div class="adm-field" style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                <input type="checkbox" id="editServiceActive" name="is_active" value="1" style="width: 18px; height: 18px; accent-color: var(--adm-accent);">
                <label for="editServiceActive" style="margin-bottom: 0; cursor: pointer; font-size: 13.5px; font-weight: 700;">Active on website</label>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px; padding-top: 14px; border-top: 1px solid #E2E8F0;">
                <button type="button" class="adm-btn adm-btn-secondary" style="flex: 1; justify-content: center;" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary" style="flex: 1.5; justify-content: center;">Save Changes</button>
            </div>
        </form>

    </div>
</div>


<!-- ======================================================== -->
<!-- MODAL: DELETE CONFIRMATION                               -->
<!-- ======================================================== -->
<div id="deleteServiceModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; max-width: 440px; width: 100%; padding: 28px; box-shadow: 0 20px 40px rgba(0,0,0,0.25); text-align: center;">
        
        <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 16px auto;">
            🗑️
        </div>

        <h3 style="font-size: 18px; font-weight: 800; color: var(--adm-ink); margin-bottom: 8px;">Delete Service?</h3>
        <p id="deleteModalMessage" style="font-size: 13.5px; color: var(--adm-muted); line-height: 1.5; margin-bottom: 22px;">
            Are you sure you want to delete this service category?
        </p>

        <form id="deleteServiceForm" method="POST">
            @csrf
            @method('DELETE')

            <div style="display: flex; gap: 10px;">
                <button type="button" class="adm-btn adm-btn-secondary" style="flex: 1; justify-content: center;" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" id="deleteModalSubmitBtn" class="adm-btn adm-btn-danger" style="flex: 1; justify-content: center;">Delete Forever</button>
            </div>
        </form>

    </div>
</div>


<script>
    function openAddServiceModal() {
        document.getElementById('addServiceModal').style.display = 'flex';
        document.getElementById('addServiceName').focus();
    }

    function closeAddServiceModal() {
        document.getElementById('addServiceModal').style.display = 'none';
    }

    function autoGenerateSlug(text) {
        const slug = text.toLowerCase()
            .trim()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('addServiceSlug').placeholder = slug || 'e.g. service-name';
    }

    function parseLines(items) {
        if (!items) return '';
        if (Array.isArray(items)) return items.join('\n');
        if (typeof items === 'string') {
            try {
                const parsed = JSON.parse(items);
                if (Array.isArray(parsed)) return parsed.join('\n');
            } catch(e) {}
            return items;
        }
        return '';
    }

    function openEditModal(service) {
        document.getElementById('editServiceForm').action = "{{ url('/admin/services') }}/" + service.id;
        document.getElementById('editServiceName').value = service.name || '';
        document.getElementById('editServiceSlug').value = service.slug || '';
        document.getElementById('editServiceIcon').value = service.icon || '🔧';
        document.getElementById('editServicePrice').value = service.base_price !== undefined ? service.base_price : 650;
        
        const priceUnitSelect = document.getElementById('editServicePriceUnit');
        if (priceUnitSelect) {
            priceUnitSelect.value = service.price_unit || 'base';
        }

        document.getElementById('editServiceDuration').value = service.estimated_duration || '30 – 60 mins';
        document.getElementById('editServiceHeadline').value = service.headline || service.name || '';
        document.getElementById('editServiceWarranty').value = service.warranty_text || '60-Day Re-work Free';

        const imageSelect = document.getElementById('editServiceImage');
        if (imageSelect && service.image) {
            imageSelect.value = service.image;
        }

        document.getElementById('editServiceSubCategories').value = parseLines(service.sub_categories);
        document.getElementById('editServiceFeatures').value = parseLines(service.feature_points);
        document.getElementById('editServiceIncluded').value = parseLines(service.included_items);
        document.getElementById('editServiceExcluded').value = parseLines(service.excluded_items);
        document.getElementById('editServiceDesc').value = service.description || '';
        document.getElementById('editServiceActive').checked = service.is_active ? true : false;
        
        document.getElementById('editServiceModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editServiceModal').style.display = 'none';
    }

    function confirmDeleteService(id, name, techCount) {
        const form = document.getElementById('deleteServiceForm');
        const msg = document.getElementById('deleteModalMessage');
        const submitBtn = document.getElementById('deleteModalSubmitBtn');

        form.action = "{{ url('/admin/services') }}/" + id;

        if (techCount > 0) {
            msg.innerHTML = `<strong>${name}</strong> has <strong>${techCount} technician(s)</strong> assigned to it.<br><br><span style="color: #DC2626;">Deletion is blocked to protect existing technician profiles.</span> You can deactivate it instead to hide it from the website.`;
            submitBtn.style.display = 'none';
        } else {
            msg.innerHTML = `Are you sure you want to permanently delete <strong>${name}</strong>? This action cannot be undone.`;
            submitBtn.style.display = 'inline-flex';
        }

        document.getElementById('deleteServiceModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteServiceModal').style.display = 'none';
    }

    // Close modals on Escape key
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddServiceModal();
            closeEditModal();
            closeDeleteModal();
        }
    });
</script>

@endsection
