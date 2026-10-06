@extends('Frontend.layouts.public')

@section('title', 'Community Issues & Civic Maintenance — FixMate')
@section('meta_desc', 'Report and track neighborhood maintenance issues like water pipeline leaks, sparking power lines, and broken streetlights across Pakistan.')

@section('content')
<div style="background: #FFFFFF; min-height: 85vh;">

    <!-- Clean Executive Header -->
    <section style="padding: 48px 0 36px 0; text-align: center; background: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
        <div class="container" style="max-width: 820px;">
            <div style="display: inline-flex; align-items: center; gap: 6px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 4px 14px; border-radius: 50px; margin-bottom: 12px;">
                <span style="font-size: 11.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">PUBLIC CIVIC &amp; NEIGHBORHOOD FEED</span>
            </div>
            <h1 style="font-size: 38px; font-weight: 900; color: #0F172A; margin: 0 0 12px 0; letter-spacing: -0.02em;">
                Neighborhood Maintenance Feed
            </h1>
            <p style="font-size: 15.5px; color: #64748B; margin: 0; line-height: 1.6;">
                FixMate enables residents to report, upvote, and coordinate rapid technician squad dispatch for communal hazards like main line water leaks, transformer sparking, and street dark zones.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 32px 0 60px 0;">
        <div class="container" style="max-width: 920px;">
            
            <!-- Success Flash Notification -->
            @if(session('success_hazard_report'))
                <div style="background: #F0FDF4; border: 1.5px solid #86EFAC; color: #166534; padding: 16px 20px; border-radius: 14px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; font-size: 14px; font-weight: 600; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.08);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 22px;">🏘️</span>
                        <div>
                            <strong style="display: block; font-size: 14.5px;">Report Published to Neighborhood Feed!</strong>
                            <span style="font-weight: 500; font-size: 13px;">{{ session('success_hazard_report') }}</span>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: #166534;">&times;</button>
                </div>
            @endif

            <!-- Civic Guarantee Banner -->
            <div style="background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 16px; padding: 20px 24px; margin-bottom: 28px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 280px;">
                    <span style="font-size: 28px;">🏘️</span>
                    <div>
                        <strong style="font-size: 14.5px; color: #0F172A; display: block;">Civic Partnership Program</strong>
                        <p style="font-size: 13px; color: #64748B; margin: 0; line-height: 1.5;">Community issues with 25+ upvotes are escalated immediately to registered housing societies, municipal departments, or emergency technician squads.</p>
                    </div>
                </div>
                <button type="button" onclick="openReportModal()" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 11px 22px; border-radius: 50px; border: none; cursor: pointer; white-space: nowrap; box-shadow: 0 2px 8px rgba(255, 184, 0, 0.35); transition: transform 0.15s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    + Report Civic Hazard
                </button>
            </div>

            <!-- Feed Filter Tabs & Cities -->
            <div style="margin-bottom: 24px;">
                
                <!-- City Filter Pills -->
                <div style="display: flex; gap: 8px; overflow-x: auto; padding-bottom: 12px; margin-bottom: 16px; scrollbar-width: none;">
                    <a href="{{ route('community', array_filter(['city' => null, 'category' => request('category'), 'status' => request('status'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
                       style="padding: 7px 18px; border-radius: 50px; font-size: 13px; font-weight: 700; text-decoration: none; white-space: nowrap; transition: all 0.15s ease; {{ (!request('city') || request('city') === 'all') ? 'background: #0F172A; color: #FFF;' : 'background: #F1F5F9; color: #475569;' }}">
                        All Cities ({{ $totalApprovedCount }})
                    </a>

                    @foreach($cities as $city)
                        @php
                            $cCount = $cityCounts[$city] ?? 0;
                            $isCityActive = request('city') === $city;
                        @endphp
                        <a href="{{ route('community', array_filter(['city' => $city, 'category' => request('category'), 'status' => request('status'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
                           style="padding: 7px 18px; border-radius: 50px; font-size: 13px; font-weight: 700; text-decoration: none; white-space: nowrap; transition: all 0.15s ease; {{ $isCityActive ? 'background: #FFB800; color: #0F172A; box-shadow: 0 2px 6px rgba(255,184,0,0.3);' : 'background: #F1F5F9; color: #475569;' }}">
                            {{ $city }} ({{ $cCount }})
                        </a>
                    @endforeach
                </div>

                <!-- Secondary Filters Bar -->
                <form action="{{ route('community') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    @if(request('city'))
                        <input type="hidden" name="city" value="{{ request('city') }}">
                    @endif

                    <!-- Search Input -->
                    <div style="flex: 1; min-width: 220px; position: relative;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search hazard, area, or ref #..." style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #E2E8F0; padding: 0 14px 0 36px; font-size: 13.5px; outline: none; background: #FFFFFF; font-family: inherit;">
                        <span style="position: absolute; left: 12px; top: 12px; font-size: 14px; color: #94A3B8;">🔍</span>
                    </div>

                    <!-- Category Filter -->
                    <div style="width: 180px;">
                        <select name="category" onchange="this.form.submit()" style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #E2E8F0; padding: 0 12px; font-size: 13px; background: #FFFFFF; font-family: inherit; color: #0F172A; cursor: pointer;">
                            <option value="">All Categories</option>
                            @foreach($categories as $cKey => $cVal)
                                <option value="{{ $cKey }}" {{ request('category') === $cKey ? 'selected' : '' }}>
                                    {{ $cVal['icon'] }} {{ $cVal['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div style="width: 160px;">
                        <select name="sort" onchange="this.form.submit()" style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #E2E8F0; padding: 0 12px; font-size: 13px; background: #FFFFFF; font-family: inherit; color: #0F172A; cursor: pointer;">
                            <option value="upvotes" {{ request('sort') !== 'latest' ? 'selected' : '' }}>🔥 Most Upvoted</option>
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>🕒 Newest First</option>
                        </select>
                    </div>

                    <button type="submit" style="background: #0F172A; color: #FFF; border: none; height: 42px; padding: 0 16px; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer;">
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'category', 'status', 'city']))
                        <a href="{{ route('community') }}" style="background: #F1F5F9; color: #64748B; text-decoration: none; height: 42px; display: inline-flex; align-items: center; padding: 0 14px; border-radius: 10px; font-size: 12.5px; font-weight: 700;">
                            Clear
                        </a>
                    @endif
                </form>

            </div>

            <!-- Issues Feed List -->
            <div style="display: flex; flex-direction: column; gap: 18px;" id="communityFeedList">
                
                @forelse($issues as $issue)
                    @php
                        $badge = $issue->status_badge;
                        $cat = $issue->category_meta;
                        $isUpvoted = in_array($issue->id, $userUpvotedIssueIds);
                        $isCritical = $issue->status === 'alert_active' || $issue->priority === 'critical';
                    @endphp

                    <div class="community-card" style="background: #FFFFFF; border: 1.5px solid {{ $isCritical ? '#FECDD3' : '#E2E8F0' }}; border-radius: 18px; padding: 22px 24px; display: grid; grid-template-columns: 64px 1fr auto; gap: 20px; align-items: flex-start; box-shadow: 0 2px 8px rgba(0,0,0,0.02); transition: transform 0.15s ease, box-shadow 0.15s ease;" onmouseover="this.style.boxShadow='0 6px 18px rgba(0,0,0,0.06)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.02)'">
                        
                        <!-- Upvote Column -->
                        <div style="text-align: center;">
                            <button 
                                type="button" 
                                class="upvote-btn" 
                                onclick="handleUpvote({{ $issue->id }}, this)"
                                data-upvoted="{{ $isUpvoted ? 'true' : 'false' }}"
                                style="width: 100%; border-radius: 12px; padding: 10px 4px; border: 1.5px solid {{ $isUpvoted ? '#F59E0B' : ($isCritical ? '#FECDD3' : '#E2E8F0') }}; background: {{ $isUpvoted ? '#FEF3C7' : ($isCritical ? '#FFF1F2' : '#F8FAFC') }}; cursor: pointer; transition: all 0.18s ease; display: flex; flex-direction: column; align-items: center;"
                                title="{{ $isUpvoted ? 'Remove your upvote' : 'Upvote this neighborhood hazard' }}"
                            >
                                <span class="arrow" style="font-size: 15px; color: {{ $isUpvoted ? '#B45309' : ($isCritical ? '#BE123C' : '#64748B') }}; line-height: 1;">▲</span>
                                <strong class="vote-count" style="display: block; font-size: 15px; color: {{ $isUpvoted ? '#92400E' : ($isCritical ? '#BE123C' : '#0F172A') }}; margin-top: 4px;">{{ $issue->upvotes_count }}</strong>
                            </button>
                            <span style="font-size: 10.5px; color: #94A3B8; font-weight: 700; margin-top: 4px; display: block; text-transform: uppercase;">votes</span>
                        </div>

                        <!-- Main Details -->
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap;">
                                <span style="background: {{ $cat['badge_bg'] }}; color: {{ $cat['badge_color'] }}; font-size: 11.5px; font-weight: 800; padding: 3px 9px; border-radius: 6px; display: inline-flex; align-items: center; gap: 4px;">
                                    <span>{{ $cat['icon'] }}</span>
                                    <span>{{ $cat['label'] }}</span>
                                </span>
                                <span style="font-size: 12.5px; color: #64748B; font-weight: 600;">📍 {{ $issue->location }}</span>
                                <span style="font-size: 11px; background: #F1F5F9; color: #64748B; padding: 2px 7px; border-radius: 6px; font-family: monospace;">#{{ $issue->reference_no }}</span>
                            </div>

                            <h3 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0; line-height: 1.35;">
                                {{ $issue->title }}
                            </h3>

                            <p style="font-size: 14px; color: #64748B; margin: 0 0 12px 0; line-height: 1.55;">
                                {{ $issue->description }}
                            </p>

                            <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; flex-wrap: wrap;">
                                @if(!empty($issue->status_update))
                                    <span style="color: {{ $isCritical ? '#DC2626' : '#059669' }}; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;">
                                        <span>●</span> {{ $issue->status_update }}
                                    </span>
                                    <span style="color: #CBD5E1;">•</span>
                                @endif
                                <span style="color: #64748B;">Reported by <strong>{{ $issue->reporter_name }}</strong> ({{ $issue->reporter_role }})</span>
                                <span style="color: #CBD5E1;">•</span>
                                <span style="color: #94A3B8;">{{ $issue->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div style="flex-shrink: 0;">
                            <span style="background: {{ $badge['bg'] }}; color: {{ $badge['color'] }}; border: 1px solid {{ $badge['border'] }}; font-size: 12px; font-weight: 800; padding: 5px 13px; border-radius: 20px; white-space: nowrap; display: inline-block;">
                                {{ $badge['label'] }}
                            </span>
                        </div>

                    </div>
                @empty
                    <!-- Empty State -->
                    <div style="background: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 20px; padding: 60px 24px; text-align: center;">
                        <div style="font-size: 44px; margin-bottom: 12px;">🏘️</div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">No Community Hazards Reported</h3>
                        <p style="font-size: 14px; color: #64748B; max-width: 480px; margin: 0 auto 20px auto; line-height: 1.6;">
                            There are currently no reported community maintenance issues matching your filter criteria. Be the first to report a neighborhood issue in your area!
                        </p>
                        <button type="button" onclick="openReportModal()" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 50px; border: none; cursor: pointer;">
                            + Report First Civic Hazard
                        </button>
                    </div>
                @endforelse

            </div>

            @if($issues->hasPages())
                <div style="margin-top: 30px; display: flex; justify-content: center;">
                    {{ $issues->links() }}
                </div>
            @endif

        </div>
    </section>

</div>

<!-- Modal: Report Civic Hazard -->
<div id="reportHazardModal" style="display: none; position: fixed; inset: 0; z-index: 999; background: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #FFFFFF; border-radius: 20px; width: 100%; max-width: 620px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow: hidden; animation: popIn 0.2s ease-out;">
        
        <div style="padding: 22px 26px; border-bottom: 1px solid #E2E8F0; display: flex; align-items: center; justify-content: space-between; background: #F8FAFC;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="font-size: 24px;">📢</span>
                <div>
                    <strong style="font-size: 16.5px; color: #0F172A; display: block;">Report Neighborhood Hazard</strong>
                    <span style="font-size: 12.5px; color: #64748B;">Mobilize emergency squads &amp; alert your neighborhood</span>
                </div>
            </div>
            <button type="button" onclick="closeReportModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #64748B; line-height: 1;">&times;</button>
        </div>

        <form action="{{ route('community.report') }}" method="POST">
            @csrf
            <div style="padding: 24px 26px; display: flex; flex-direction: column; gap: 16px; max-height: 72vh; overflow-y: auto;">
                
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                        Issue Title <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" name="title" required placeholder="e.g. Main water pipe burst flooding the street" style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 13.5px; outline: none; font-family: inherit;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                            Hazard Category <span style="color: #DC2626;">*</span>
                        </label>
                        <select name="category" required style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 13px; font-family: inherit;">
                            @foreach($categories as $key => $cat)
                                <option value="{{ $key }}">{{ $cat['icon'] }} {{ $cat['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                            City <span style="color: #DC2626;">*</span>
                        </label>
                        <select name="city" required style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 13px; font-family: inherit;">
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                        Exact Location / Street Address <span style="color: #DC2626;">*</span>
                    </label>
                    <input type="text" name="location" required placeholder="e.g. Block 13D, Street 5, Near Primary School" style="width: 100%; height: 42px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 13.5px; outline: none; font-family: inherit;">
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                        Detailed Description &amp; Impact <span style="color: #DC2626;">*</span>
                    </label>
                    <textarea name="description" rows="3" required placeholder="Describe what happened, how many homes are affected, and if there is immediate physical danger..." style="width: 100%; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 12px; font-size: 13.5px; outline: none; resize: vertical; font-family: inherit; line-height: 1.5;"></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
                    <div>
                        <label style="display: block; font-size: 12.5px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                            Your Name <span style="color: #DC2626;">*</span>
                        </label>
                        <input type="text" name="reporter_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required placeholder="e.g. Tariq Mehmood" style="width: 100%; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 13px; outline: none;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 12.5px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                            Your Role
                        </label>
                        <select name="reporter_role" style="width: 100%; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 12.5px;">
                            <option value="Resident">Resident</option>
                            <option value="Shop Owner">Shop Owner</option>
                            <option value="Area Elder">Area Elder</option>
                            <option value="Commuter">Commuter</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 12.5px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                            Priority Urgency
                        </label>
                        <select name="priority" style="width: 100%; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 10px; font-size: 12.5px;">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="critical">🚨 Critical Alert</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 12.5px; font-weight: 700; color: #0F172A; margin-bottom: 6px;">
                        Phone Number (Optional - for dispatch status SMS)
                    </label>
                    <input type="text" name="reporter_phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="0300-1234567" style="width: 100%; height: 40px; border-radius: 10px; border: 1.5px solid #CBD5E1; padding: 0 12px; font-size: 13px; outline: none;">
                </div>

            </div>

            <div style="padding: 16px 26px; background: #F8FAFC; border-top: 1px solid #E2E8F0; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeReportModal()" style="background: #FFFFFF; border: 1px solid #CBD5E1; color: #64748B; font-weight: 700; padding: 10px 18px; border-radius: 10px; cursor: pointer; font-size: 13px;">Cancel</button>
                <button type="submit" style="background: #FFB800; color: #0F172A; border: none; font-weight: 800; padding: 10px 22px; border-radius: 10px; cursor: pointer; font-size: 13.5px; box-shadow: 0 2px 6px rgba(255,184,0,0.3);">Publish Civic Report</button>
            </div>
        </form>

    </div>
</div>

<script>
    function openReportModal() {
        document.getElementById('reportHazardModal').style.display = 'flex';
    }

    function closeReportModal() {
        document.getElementById('reportHazardModal').style.display = 'none';
    }

    function handleUpvote(issueId, btn) {
        var countEl = btn.querySelector('.vote-count');
        var arrowEl = btn.querySelector('.arrow');
        var wasUpvoted = btn.getAttribute('data-upvoted') === 'true';

        fetch("{{ url('/community') }}/" + issueId + "/upvote", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                countEl.textContent = data.count;
                if (data.upvoted) {
                    btn.setAttribute('data-upvoted', 'true');
                    btn.style.background = '#FEF3C7';
                    btn.style.borderColor = '#F59E0B';
                    arrowEl.style.color = '#B45309';
                    countEl.style.color = '#92400E';
                } else {
                    btn.setAttribute('data-upvoted', 'false');
                    btn.style.background = '#F8FAFC';
                    btn.style.borderColor = '#E2E8F0';
                    arrowEl.style.color = '#64748B';
                    countEl.style.color = '#0F172A';
                }
            }
        })
        .catch(err => {
            console.error('Error recording upvote', err);
        });
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeReportModal();
        }
    });

    var reportModal = document.getElementById('reportHazardModal');
    if (reportModal) {
        reportModal.addEventListener('click', function(e) {
            if (e.target === reportModal) {
                closeReportModal();
            }
        });
    }
</script>

<style>
@keyframes popIn {
    from { opacity: 0; transform: scale(0.96) translateY(6px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
</style>
@endsection
