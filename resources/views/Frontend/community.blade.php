@extends('Frontend.layouts.master')

@section('title', 'Neighborhood Community Issues Forum — FixMate AI')
@section('meta_desc', 'Public neighborhood issue reporting and validation. Upvote local infrastructure issues, report street hazards, and track municipal contractor fixes.')

@section('content')
<div class="container" style="padding-top: 28px; padding-bottom: 70px;">

    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #757575; margin-bottom: 14px;">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <span style="color: #111111; font-weight: 600;">Community Forum</span>
    </div>

    <!-- Hero Header -->
    <div style="background: linear-gradient(135deg, #111111 0%, #1E1E1E 100%); color: #FFFFFF; border-radius: 32px; padding: 40px; margin-bottom: 32px; position: relative; overflow: hidden;">
        <div style="display: grid; grid-template-columns: 1.3fr 1fr; gap: 30px; align-items: center;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255,204,0,0.15); border: 1px solid rgba(255,204,0,0.4); padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; color: #FFCC00; margin-bottom: 12px;">
                    <span>📍 Brooklyn Community Ward 4</span>
                </div>
                <h1 style="font-size: 32px; font-weight: 800; line-height: 1.2; margin-bottom: 12px;">
                    Public Neighborhood Repair Board
                </h1>
                <p style="color: #AAAAAA; font-size: 14.5px; line-height: 1.6; max-width: 520px; margin-bottom: 24px;">
                    Spot a broken water main, flickering streetlight, or hazard? Report it to rally local neighbors. High-upvote issues are dispatched directly to accredited municipal contractors.
                </p>
                <div style="display: flex; gap: 12px;">
                    <button type="button" class="btn-primary" onclick="openReportModal()" style="padding: 12px 22px; font-size: 14px;">
                        <span>+ Report a Local Issue</span>
                    </button>
                    <a href="{{ url('/services') }}" class="btn-secondary" style="background: transparent; color: #FFFFFF; border-color: #444444; font-size: 14px;">
                        <span>Private Home Fixes</span>
                    </a>
                </div>
            </div>

            <!-- Stats Badge -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 20px; text-align: center;">
                    <span style="font-size: 32px; font-weight: 900; color: #FFCC00; display: block;">42</span>
                    <span style="font-size: 12px; color: #AAAAAA; font-weight: 600;">Issues Resolved This Month</span>
                </div>
                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 20px; text-align: center;">
                    <span style="font-size: 32px; font-weight: 900; color: #10B981; display: block;">&lt; 36h</span>
                    <span style="font-size: 12px; color: #AAAAAA; font-weight: 600;">Avg Contractor Response</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs (FR-7.1) -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 14px;">
        <div style="display: flex; gap: 8px; overflow-x: auto;">
            <button type="button" class="category-pill active">All Issues (24)</button>
            <button type="button" class="category-pill">🚰 Water & Drainage (8)</button>
            <button type="button" class="category-pill">⚡ Streetlights & Electrical (6)</button>
            <button type="button" class="category-pill">🚧 Roads & Potholes (7)</button>
            <button type="button" class="category-pill">🌳 Public Parks (3)</button>
        </div>
        <div style="font-size: 13px; color: #757575;">
            Sorted by: <strong>Most Upvoted First</strong>
        </div>
    </div>

    <!-- Issues Cards Stream (FR-7.2 Upvoting & FR-7.3 Status) -->
    <div style="display: flex; flex-direction: column; gap: 18px;">

        <!-- Issue 1: High Upvotes / In Progress -->
        <div class="fm-card" style="display: grid; grid-template-columns: 80px 1fr 180px; gap: 24px; align-items: center; padding: 22px;">
            <!-- Upvote Box (FR-7.2) -->
            <div style="text-align: center; background: #FFF9E6; border: 1.5px solid #FFCC00; border-radius: 18px; padding: 12px 8px; cursor: pointer;" onclick="toggleUpvote(this, 142)">
                <span style="font-size: 18px; display: block; line-height: 1;">▲</span>
                <strong class="upvote-count" style="font-size: 18px; font-weight: 900; color: #111;">142</strong>
                <span style="font-size: 10px; color: #8C6B00; font-weight: 700; display: block;">UPVOTES</span>
            </div>

            <!-- Issue Body -->
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="background: #E0F2FE; color: #0369A1; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 8px;">WATER & DRAINAGE</span>
                    <span style="font-size: 12px; color: #757575;">Reported 4 hours ago by @sarah_b</span>
                    <span style="font-size: 12px; color: #111; font-weight: 600;">• 4th Ave & 9th St</span>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 6px;">
                    Pressurized Main Pipeline Leak Flooding Sidewalk & Bike Lane
                </h3>
                <p class="text-secondary" style="font-size: 13.5px; line-height: 1.5; margin-bottom: 10px;">
                    Clean water is continuously gushing from beneath the curb slab near the bus stop. Ice hazard forming overnight.
                </p>
                <div style="display: flex; gap: 14px; font-size: 12px; color: #777;">
                    <span>📷 3 Photos attached</span>
                    <span>💬 18 Neighbor comments</span>
                </div>
            </div>

            <!-- Status & Assigned Contractor (FR-7.3) -->
            <div style="text-align: right; border-left: 1px solid #EEEEEE; padding-left: 20px;">
                <span style="display: inline-block; background: #FEF3C7; color: #92400E; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; margin-bottom: 8px;">
                    ⚙️ IN PROGRESS
                </span>
                <span style="display: block; font-size: 11px; color: #888;">Assigned Contractor:</span>
                <strong style="display: block; font-size: 13px; color: #111; margin-bottom: 10px;">AquaFix Municipal</strong>
                <button type="button" class="btn-secondary" style="font-size: 12px; padding: 6px 12px; width: 100%; justify-content: center;" onclick="showToast('Subscribed to status notifications for this issue')">
                    Track Fix
                </button>
            </div>
        </div>

        <!-- Issue 2: Streetlight Malfunction -->
        <div class="fm-card" style="display: grid; grid-template-columns: 80px 1fr 180px; gap: 24px; align-items: center; padding: 22px;">
            <div style="text-align: center; background: #FAFAFA; border: 1.5px solid #EEEEEE; border-radius: 18px; padding: 12px 8px; cursor: pointer;" onclick="toggleUpvote(this, 89)">
                <span style="font-size: 18px; display: block; line-height: 1;">▲</span>
                <strong class="upvote-count" style="font-size: 18px; font-weight: 900; color: #111;">89</strong>
                <span style="font-size: 10px; color: #777; font-weight: 700; display: block;">UPVOTES</span>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="background: #FEF3C7; color: #B45309; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 8px;">ELECTRICAL</span>
                    <span style="font-size: 12px; color: #757575;">Reported 1 day ago by @dave_k</span>
                    <span style="font-size: 12px; color: #111; font-weight: 600;">• Prospect Park West & 3rd St</span>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 6px;">
                    Two Consecutive Streetlights Dead Near School Crosswalk
                </h3>
                <p class="text-secondary" style="font-size: 13.5px; line-height: 1.5; margin-bottom: 10px;">
                    Completely pitch black at evening crosswalk hours. Safety concern for kids walking home from sports center.
                </p>
                <div style="display: flex; gap: 14px; font-size: 12px; color: #777;">
                    <span>📷 1 Photo attached</span>
                    <span>💬 9 Neighbor comments</span>
                </div>
            </div>

            <div style="text-align: right; border-left: 1px solid #EEEEEE; padding-left: 20px;">
                <span style="display: inline-block; background: #ECFDF5; color: #047857; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; margin-bottom: 8px;">
                    ✓ RESOLVED
                </span>
                <span style="display: block; font-size: 11px; color: #888;">Resolved By:</span>
                <strong style="display: block; font-size: 13px; color: #111; margin-bottom: 10px;">City Power Crew #12</strong>
                <span style="font-size: 11px; color: #10B981; font-weight: 700;">Inspected & Closed</span>
            </div>
        </div>

        <!-- Issue 3: Pothole / Structural Fix -->
        <div class="fm-card" style="display: grid; grid-template-columns: 80px 1fr 180px; gap: 24px; align-items: center; padding: 22px;">
            <div style="text-align: center; background: #FAFAFA; border: 1.5px solid #EEEEEE; border-radius: 18px; padding: 12px 8px; cursor: pointer;" onclick="toggleUpvote(this, 64)">
                <span style="font-size: 18px; display: block; line-height: 1;">▲</span>
                <strong class="upvote-count" style="font-size: 18px; font-weight: 900; color: #111;">64</strong>
                <span style="font-size: 10px; color: #777; font-weight: 700; display: block;">UPVOTES</span>
            </div>

            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <span style="background: #F1F5F9; color: #475569; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 8px;">ROADS & ASPHALT</span>
                    <span style="font-size: 12px; color: #757575;">Reported 2 days ago by @marcus_h</span>
                    <span style="font-size: 12px; color: #111; font-weight: 600;">• Union St between 5th & 6th</span>
                </div>
                <h3 style="font-size: 18px; font-weight: 800; color: #111; margin-bottom: 6px;">
                    Deep 8-Inch Rim Pothole Causing Tire Damage
                </h3>
                <p class="text-secondary" style="font-size: 13.5px; line-height: 1.5; margin-bottom: 10px;">
                    Severely eroded pothole after the winter freeze. Multiple delivery bicycles and cars have blown tires.
                </p>
                <div style="display: flex; gap: 14px; font-size: 12px; color: #777;">
                    <span>📷 2 Photos attached</span>
                    <span>💬 12 Neighbor comments</span>
                </div>
            </div>

            <div style="text-align: right; border-left: 1px solid #EEEEEE; padding-left: 20px;">
                <span style="display: inline-block; background: #EFF6FF; color: #1D4ED8; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 12px; margin-bottom: 8px;">
                    ASSIGNED
                </span>
                <span style="display: block; font-size: 11px; color: #888;">Dispatched To:</span>
                <strong style="display: block; font-size: 13px; color: #111; margin-bottom: 10px;">Brooklyn Roadworks LLC</strong>
                <button type="button" class="btn-secondary" style="font-size: 12px; padding: 6px 12px; width: 100%; justify-content: center;" onclick="showToast('Subscribed to status notifications')">
                    Track Fix
                </button>
            </div>
        </div>

    </div>

    <!-- Report New Issue Modal (FR-7.1) -->
    <div id="reportIssueModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center;">
        <div style="background: #FFFFFF; border-radius: 28px; width: 100%; max-width: 520px; padding: 32px; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 20px; font-weight: 800; color: #111;">Report Neighborhood Hazard</h3>
                <button type="button" onclick="closeReportModal()" style="font-size: 20px; color: #777;">✕</button>
            </div>

            <form onsubmit="submitIssue(event)">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Issue Title</label>
                    <input type="text" required placeholder="e.g. Broken Fire Hydrant or Deep Pothole" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Category</label>
                    <select style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none; background: #FAFAFA;">
                        <option>Water & Sewage / Drainage</option>
                        <option>Electrical / Streetlights</option>
                        <option>Roads & Potholes</option>
                        <option>Public Parks & Trees</option>
                    </select>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Address or Intersection</label>
                    <input type="text" required value="7th Ave & Carroll St, Brooklyn, NY" style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #111; margin-bottom: 6px;">Description & Urgency</label>
                    <textarea rows="3" required placeholder="Provide details on danger level, size, or impact to neighbors..." style="width: 100%; border: 1px solid #DCDCDC; border-radius: 14px; padding: 12px 14px; font-size: 14px; outline: none;"></textarea>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="button" class="btn-secondary" onclick="closeReportModal()" style="flex: 1; padding: 12px; justify-content: center;">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary" style="flex: 2; padding: 12px; justify-content: center;">
                        Submit to Public Board
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('extra_js')
<script>
    function openReportModal() {
        document.getElementById('reportIssueModal').style.display = 'flex';
    }

    function closeReportModal() {
        document.getElementById('reportIssueModal').style.display = 'none';
    }

    function toggleUpvote(el, initialCount) {
        const countEl = el.querySelector('.upvote-count');
        let current = parseInt(countEl.textContent);
        if (el.classList.contains('upvoted')) {
            el.classList.remove('upvoted');
            el.style.background = '#FAFAFA';
            el.style.borderColor = '#EEEEEE';
            countEl.textContent = current - 1;
            showToast("Upvote removed");
        } else {
            el.classList.add('upvoted');
            el.style.background = '#FFF9E6';
            el.style.borderColor = '#FFCC00';
            countEl.textContent = current + 1;
            showToast("Upvoted! Issue boosted in municipal queue.");
        }
    }

    function submitIssue(e) {
        e.preventDefault();
        closeReportModal();
        showToast("Community issue submitted! Listed on the public board.");
    }
</script>
@endsection
