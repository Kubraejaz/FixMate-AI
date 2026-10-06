@extends('Frontend.layouts.admin')

@section('title', 'FAQs & Knowledge Base — FixMate Admin')

@section('content')

<!-- Page Heading & Actions -->
<div class="adm-page-head">
    <div>
        <h1>Help Center &amp; FAQs Management</h1>
        <p>Manage customer and technician frequently asked questions, update response answers, organize categories, and toggle live visibility.</p>
    </div>
    <div class="adm-page-actions">
        <a href="{{ route('faqs') }}" target="_blank" class="adm-btn adm-btn-secondary" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-ink);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                <polyline points="15 3 21 3 21 9"></polyline>
                <line x1="10" y1="14" x2="21" y2="3"></line>
            </svg>
            Preview Public Portal
        </a>
        <button type="button" class="adm-btn adm-btn-primary" onclick="openCreateModal()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round">
                <path d="M12 5v14"></path>
                <path d="M5 12h14"></path>
            </svg>
            Add New FAQ
        </button>
    </div>
</div>

<!-- Flash Notifications -->
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
        <strong style="display: block; margin-bottom: 6px;">Please correct the validation errors:</strong>
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
            <span class="kpi-label">Total Questions</span>
            <span class="kpi-icon" style="background: var(--adm-accent-soft); color: #B45309;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-val">{{ $stats['total'] ?? 0 }}</div>
        <div class="kpi-foot">In system database</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Active on Live Portal</span>
            <span class="kpi-icon" style="background: var(--adm-success-soft); color: var(--adm-success);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-success);">{{ $stats['active'] ?? 0 }}</div>
        <div class="kpi-foot up">Visible to customers</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Hidden / Drafts</span>
            <span class="kpi-icon" style="background: #F1F5F9; color: var(--adm-muted);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-muted);">{{ $stats['inactive'] ?? 0 }}</div>
        <div class="kpi-foot">Unpublished FAQs</div>
    </div>

    <div class="adm-kpi">
        <div class="kpi-head">
            <span class="kpi-label">Help Topics</span>
            <span class="kpi-icon" style="background: #EFF6FF; color: var(--adm-info);">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </span>
        </div>
        <div class="kpi-val" style="color: var(--adm-info);">{{ $stats['categories'] ?? 0 }}</div>
        <div class="kpi-foot">Organized categories</div>
    </div>

</div>

<!-- Filter Bar -->
<div class="adm-card" style="padding: 16px 20px; margin-bottom: 24px;">
    <form method="GET" action="{{ route('admin.faqs') }}" style="display: flex; gap: 14px; align-items: center; flex-wrap: wrap;">
        
        <div style="flex: 1; min-width: 260px; position: relative;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search questions or keywords in answers..." class="adm-input" style="padding-left: 38px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="position: absolute; left: 13px; top: 13px; color: var(--adm-faint);">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
        </div>

        <div style="width: 220px;">
            <select name="category" class="adm-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories as $key => $cat)
                    <option value="{{ $key }}" {{ request('category') === $key ? 'selected' : '' }}>
                        {{ $cat['icon'] }} {{ $cat['label'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="width: 170px;">
            <select name="status" class="adm-select" onchange="this.form.submit()">
                <option value="">All Visibility</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active / Published</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Hidden / Draft</option>
            </select>
        </div>

        <button type="submit" class="adm-btn adm-btn-primary" style="height: 42px;">
            Filter
        </button>

        @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('admin.faqs') }}" class="adm-btn" style="height: 42px; text-decoration: none; color: var(--adm-muted); background: #F1F5F9;">
                Reset
            </a>
        @endif

    </form>
</div>

<!-- FAQs Table Card -->
<div class="adm-card" style="padding: 0; overflow: hidden; margin-bottom: 24px;">
    
    <div style="padding: 18px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <strong style="font-size: 15px; color: var(--adm-ink);">Knowledgebase Q&amp;A List</strong>
            <span style="font-size: 12px; font-weight: 600; color: var(--adm-muted);">({{ $faqs->total() }} total)</span>
        </div>
        <span style="font-size: 12px; color: var(--adm-muted);">Drag or adjust sort order numbers to control public display priority</span>
    </div>

    <div style="overflow-x: auto;">
        <table class="adm-table" style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #F8FAFC; border-bottom: 1px solid var(--adm-border); font-size: 12px; color: var(--adm-muted); text-transform: uppercase; letter-spacing: 0.04em;">
                    <th style="padding: 12px 20px; width: 60px;">Order</th>
                    <th style="padding: 12px 20px; width: 34%;">Question</th>
                    <th style="padding: 12px 20px; width: 18%;">Category</th>
                    <th style="padding: 12px 20px; width: 14%;">Visibility</th>
                    <th style="padding: 12px 20px; width: 16%;">Last Updated</th>
                    <th style="padding: 12px 20px; width: 14%; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr style="border-bottom: 1px solid var(--adm-border-soft); transition: background 0.15s ease;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='transparent'">
                        
                        <!-- Sort Order -->
                        <td style="padding: 16px 20px; font-weight: 700; color: var(--adm-muted); font-size: 13px;">
                            <span style="display: inline-block; background: #F1F5F9; border-radius: 6px; padding: 2px 8px;">#{{ $faq->sort_order }}</span>
                        </td>

                        <!-- Question & Answer Preview -->
                        <td style="padding: 16px 20px;">
                            <div style="font-weight: 700; font-size: 14px; color: var(--adm-ink); line-height: 1.4; margin-bottom: 5px;">
                                {{ $faq->question }}
                            </div>
                            <div style="font-size: 12.5px; color: var(--adm-muted); line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $faq->answer }}
                            </div>
                        </td>

                        <!-- Category -->
                        <td style="padding: 16px 20px;">
                            <span style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #0F172A; background: #F1F5F9; border: 1px solid #E2E8F0; padding: 4px 10px; border-radius: 20px;">
                                <span>{{ $faq->category_icon }}</span>
                                <span>{{ $faq->category_label }}</span>
                            </span>
                        </td>

                        <!-- Status / Toggle -->
                        <td style="padding: 16px 20px;">
                            <label style="position: relative; display: inline-flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" onchange="toggleFaqStatus({{ $faq->id }}, this)" {{ $faq->is_active ? 'checked' : '' }} style="display: none;">
                                <div class="toggle-pill" style="width: 38px; height: 22px; background: {{ $faq->is_active ? 'var(--adm-success)' : '#CBD5E1' }}; border-radius: 20px; position: relative; transition: background 0.2s ease;">
                                    <div class="toggle-circle" style="width: 16px; height: 16px; background: #FFFFFF; border-radius: 50%; position: absolute; top: 3px; left: {{ $faq->is_active ? '19px' : '3px' }}; transition: left 0.2s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.2);"></div>
                                </div>
                                <span class="status-text" style="font-size: 12.5px; font-weight: 700; color: {{ $faq->is_active ? 'var(--adm-success)' : 'var(--adm-muted)' }};">
                                    {{ $faq->is_active ? 'Published' : 'Hidden' }}
                                </span>
                            </label>
                        </td>

                        <!-- Last Updated -->
                        <td style="padding: 16px 20px; font-size: 12.5px; color: var(--adm-muted);">
                            <div>{{ $faq->updated_at->format('M d, Y') }}</div>
                            <div style="font-size: 11px; color: var(--adm-faint);">{{ $faq->updated_at->diffForHumans() }}</div>
                        </td>

                        <!-- Actions -->
                        <td style="padding: 16px 20px; text-align: right;">
                            <div style="display: inline-flex; gap: 8px;">
                                <button type="button" class="adm-btn" style="height: 32px; padding: 0 10px; font-size: 12px; background: #F8FAFC; border: 1px solid var(--adm-border); color: var(--adm-ink);" onclick='openEditModal(@json($faq))' title="Edit FAQ">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button type="button" class="adm-btn" style="height: 32px; padding: 0 10px; font-size: 12px; background: #FFF1F2; border: 1px solid #FECDD3; color: var(--adm-danger);" onclick="confirmDelete({{ $faq->id }}, '{{ addslashes($faq->question) }}')" title="Delete FAQ">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 50px 20px; text-align: center;">
                            <div style="max-width: 380px; margin: 0 auto;">
                                <div style="width: 52px; height: 52px; background: var(--adm-accent-soft); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; color: #B45309; font-size: 22px;">❓</div>
                                <div style="font-weight: 700; font-size: 15px; color: var(--adm-ink); margin-bottom: 4px;">No FAQs Found</div>
                                <div style="font-size: 13px; color: var(--adm-muted); margin-bottom: 16px;">No questions match the current filter or search criteria. Try clearing filters or create a new question.</div>
                                <button type="button" class="adm-btn adm-btn-primary" onclick="openCreateModal()">+ Add New FAQ</button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($faqs->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end;">
            {{ $faqs->links() }}
        </div>
    @endif

</div>

<!-- Modal: Add New FAQ -->
<div id="createFaqModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 16px; width: 100%; max-width: 620px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); overflow: hidden; animation: modalPop 0.2s ease-out;">
        
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: var(--adm-accent-soft); color: #B45309; font-weight: 800;">+</span>
                <strong style="font-size: 16px; color: var(--adm-ink);">Add New Frequently Asked Question</strong>
            </div>
            <button type="button" onclick="closeCreateModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--adm-muted); line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('admin.faqs.store') }}" method="POST">
            @csrf
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 18px; max-height: 75vh; overflow-y: auto;">
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Help Topic / Category <span style="color: var(--adm-danger);">*</span></label>
                    <select name="category" class="adm-select" required>
                        @foreach($categories as $key => $cat)
                            <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>
                                {{ $cat['icon'] }} {{ $cat['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Question <span style="color: var(--adm-danger);">*</span></label>
                    <input type="text" name="question" value="{{ old('question') }}" placeholder="e.g., How does the 30-day workmanship warranty work?" class="adm-input" required>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Answer Description <span style="color: var(--adm-danger);">*</span></label>
                    <textarea name="answer" rows="5" class="adm-input" placeholder="Provide a detailed, helpful answer for customers and technicians..." required style="height: auto; padding: 12px; resize: vertical; line-height: 1.6;">{{ old('answer') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: center;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', ($faqs->total() + 1)) }}" min="0" max="9999" class="adm-input">
                        <span style="font-size: 11px; color: var(--adm-muted); display: block; margin-top: 3px;">Lower numbers appear first</span>
                    </div>

                    <div style="padding-top: 18px;">
                        <label style="display: flex; align-items: center; gap: 9px; cursor: pointer; font-size: 13.5px; font-weight: 700; color: var(--adm-ink);">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} style="width: 17px; height: 17px; accent-color: var(--adm-accent);">
                            <span>Publish immediately to public portal</span>
                        </label>
                    </div>
                </div>

            </div>

            <div style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-muted);" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Save FAQ</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal: Edit FAQ -->
<div id="editFaqModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 16px; width: 100%; max-width: 620px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); overflow: hidden; animation: modalPop 0.2s ease-out;">
        
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--adm-border); display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 8px; background: #EFF6FF; color: var(--adm-info); font-weight: 800;">✎</span>
                <strong style="font-size: 16px; color: var(--adm-ink);">Edit FAQ Question</strong>
            </div>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: var(--adm-muted); line-height: 1;">&times;</button>
        </div>

        <form id="editFaqForm" method="POST">
            @csrf
            @method('PUT')
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 18px; max-height: 75vh; overflow-y: auto;">
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Help Topic / Category <span style="color: var(--adm-danger);">*</span></label>
                    <select id="edit_category" name="category" class="adm-select" required>
                        @foreach($categories as $key => $cat)
                            <option value="{{ $key }}">{{ $cat['icon'] }} {{ $cat['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Question <span style="color: var(--adm-danger);">*</span></label>
                    <input type="text" id="edit_question" name="question" class="adm-input" required>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Answer Description <span style="color: var(--adm-danger);">*</span></label>
                    <textarea id="edit_answer" name="answer" rows="5" class="adm-input" required style="height: auto; padding: 12px; resize: vertical; line-height: 1.6;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: center;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--adm-ink); margin-bottom: 6px;">Sort Order</label>
                        <input type="number" id="edit_sort_order" name="sort_order" min="0" max="9999" class="adm-input">
                    </div>

                    <div style="padding-top: 18px;">
                        <label style="display: flex; align-items: center; gap: 9px; cursor: pointer; font-size: 13.5px; font-weight: 700; color: var(--adm-ink);">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: 17px; height: 17px; accent-color: var(--adm-accent);">
                            <span>Active on live public portal</span>
                        </label>
                    </div>
                </div>

            </div>

            <div style="padding: 16px 24px; background: #F8FAFC; border-top: 1px solid var(--adm-border); display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-muted);" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="adm-btn adm-btn-primary">Update FAQ</button>
            </div>
        </form>

    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="deleteFaqModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 16px; width: 100%; max-width: 460px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2); overflow: hidden; animation: modalPop 0.2s ease-out;">
        
        <div style="padding: 24px; text-align: center;">
            <div style="width: 50px; height: 50px; background: #FFF1F2; border-radius: 50%; color: var(--adm-danger); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; font-size: 22px;">
                🗑️
            </div>
            <strong style="font-size: 17px; color: var(--adm-ink); display: block; margin-bottom: 8px;">Delete FAQ Question?</strong>
            <p id="deleteFaqQuestionText" style="font-size: 13.5px; color: var(--adm-muted); margin: 0 0 20px 0; line-height: 1.5;"></p>
            
            <form id="deleteFaqForm" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" class="adm-btn" style="background: #FFFFFF; border: 1px solid var(--adm-border); color: var(--adm-muted);" onclick="closeDeleteModal()">Cancel</button>
                    <button type="submit" class="adm-btn" style="background: var(--adm-danger); color: #FFFFFF; border: none;">Permanently Delete</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@section('extra_js')
<script>
    function openCreateModal() {
        var modal = document.getElementById('createFaqModal');
        modal.style.display = 'flex';
    }

    function closeCreateModal() {
        document.getElementById('createFaqModal').style.display = 'none';
    }

    function openEditModal(faq) {
        document.getElementById('editFaqForm').action = "{{ url('/admin/faqs') }}/" + faq.id;
        document.getElementById('edit_question').value = faq.question;
        document.getElementById('edit_answer').value = faq.answer;
        document.getElementById('edit_category').value = faq.category;
        document.getElementById('edit_sort_order').value = faq.sort_order;
        document.getElementById('edit_is_active').checked = !!faq.is_active;

        var modal = document.getElementById('editFaqModal');
        modal.style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editFaqModal').style.display = 'none';
    }

    function confirmDelete(id, question) {
        document.getElementById('deleteFaqForm').action = "{{ url('/admin/faqs') }}/" + id;
        document.getElementById('deleteFaqQuestionText').textContent = 'Are you sure you want to delete "' + question + '"? This will remove it from the knowledgebase.';
        
        var modal = document.getElementById('deleteFaqModal');
        modal.style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteFaqModal').style.display = 'none';
    }

    function toggleFaqStatus(id, inputEl) {
        var pill = inputEl.nextElementSibling;
        var circle = pill.querySelector('.toggle-circle');
        var text = inputEl.parentElement.querySelector('.status-text');

        fetch("{{ url('/admin/faqs') }}/" + id + "/toggle", {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.is_active) {
                    pill.style.background = 'var(--adm-success)';
                    circle.style.left = '19px';
                    text.textContent = 'Published';
                    text.style.color = 'var(--adm-success)';
                } else {
                    pill.style.background = '#CBD5E1';
                    circle.style.left = '3px';
                    text.textContent = 'Hidden';
                    text.style.color = 'var(--adm-muted)';
                }
                showToast(data.message, true);
            } else {
                inputEl.checked = !inputEl.checked;
                showToast('Failed to update status', false);
            }
        })
        .catch(err => {
            inputEl.checked = !inputEl.checked;
            showToast('Network error while toggling FAQ status', false);
        });
    }

    // Close modals on escape key or clicking backdrop
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCreateModal();
            closeEditModal();
            closeDeleteModal();
        }
    });

    ['createFaqModal', 'editFaqModal', 'deleteFaqModal'].forEach(function(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    });
</script>

<style>
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.96) translateY(8px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
</style>
@endsection
