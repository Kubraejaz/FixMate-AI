@extends('Frontend.layouts.admin')

@section('title', 'Categories & Pricing — FixMate AI Admin')

@section('content')

<div class="adm-page-head">
    <div>
        <h1>Problem Categories &amp; Catalog</h1>
        <p>Manage diagnostic categories, base pricing rules, and trade classifications.</p>
    </div>
    <div class="adm-page-actions">
        <button type="button" class="adm-btn adm-btn-primary" onclick="showToast('New category draft created')">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Add Category
        </button>
    </div>
</div>

<div class="adm-grid-2-even" style="grid-template-columns: repeat(3, minmax(0, 1fr));">

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: var(--adm-accent-soft);">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a4 4 0 0 0 5 5l-9.6 9.6a2.8 2.8 0 0 1-4-4l9.6-9.6z"></path>
                </svg>
            </span>
            <span class="adm-badge green">1,248 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">Plumbing</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Leakage, pipe repair, bathroom sanitary, sink drain, motor pumps.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 500</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: var(--adm-info-soft);">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2L4.5 13H11l-1 9 8.5-11H12l1-9z"></path>
                </svg>
            </span>
            <span class="adm-badge green">892 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">Electrical</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Wiring, short-circuit troubleshooting, breaker panels, ceiling fans.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 600</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: var(--adm-success-soft);">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20"></path>
                    <path d="m4.6 6 14.8 12"></path>
                    <path d="M4.6 18 19.4 6"></path>
                    <path d="M9.5 4.5 12 2l2.5 2.5"></path>
                    <path d="M9.5 19.5 12 22l2.5-2.5"></path>
                </svg>
            </span>
            <span class="adm-badge green">740 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">AC &amp; Cooling</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Split AC service, gas refill, inverter troubleshooting, cooling coil.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 1,200</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: var(--adm-danger-soft);">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#E11D48" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="5" y="2" width="14" height="20" rx="2.5"></rect>
                    <path d="M12 7v3"></path>
                    <path d="M12 13v.01"></path>
                </svg>
            </span>
            <span class="adm-badge green">480 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">Appliance Repair</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Refrigerator, washing machine, microwave oven, water dispenser.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 900</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: #FEF3C7;">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21V9l9-6 9 6v12"></path>
                    <path d="M9 21v-6h6v6"></path>
                </svg>
            </span>
            <span class="adm-badge green">350 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">Carpentry</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Door locks, handles, wardrobe hinges, wooden polishing, shelves.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 800</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

    <div class="adm-card">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; margin-bottom: 14px;">
            <span class="kpi-icon" style="width: 44px; height: 44px; border-radius: 12px; background: #FAF5FF;">
                <svg width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="#A855F7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 21h18"></path>
                    <path d="M5 21V11"></path>
                    <path d="M9 21V11"></path>
                    <path d="M15 21V11"></path>
                    <path d="M19 21V11"></path>
                    <path d="M2 11h20"></path>
                    <path d="M8 11V6a4 4 0 0 1 8 0v5"></path>
                </svg>
            </span>
            <span class="adm-badge green">520 inquiries</span>
        </div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 6px;">Deep Cleaning</h3>
        <p style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.55; margin-bottom: 15px;">Full house deep cleaning, sofas, carpets, water tank disinfection.</p>
        <div style="border-top: 1px solid var(--adm-border-soft); padding-top: 13px; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
            <span style="color: var(--adm-faint);">Base fee: <strong style="color: #B45309;">Rs. 1,500</strong></span>
            <a href="#" class="adm-card-link">Edit Catalog</a>
        </div>
    </div>

</div>

@endsection
