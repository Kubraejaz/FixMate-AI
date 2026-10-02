@extends('Frontend.layouts.public')

@section('title', 'Frequently Asked Questions (FAQs) — FixMate AI | Help Center')
@section('meta_desc', 'Got questions about FixMate AI? Find verified answers on AI problem diagnosis, upfront pricing, escrow payments, technician verification, and our 30-day warranty.')

@section('content')
<div style="background: #FFFFFF; min-height: 85vh;">

    <!-- Clean Header -->
    <section style="padding: 56px 0 36px 0; text-align: center; background: linear-gradient(180deg, #F8FAFC 0%, #FFFFFF 100%); border-bottom: 1px solid #F1F5F9;">
        <div class="container" style="max-width: 860px;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: #FFF9E6; border: 1px solid #FEF08A; padding: 6px 16px; border-radius: 50px; margin-bottom: 16px;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #FFB800;"></span>
                <span style="font-size: 12.5px; font-weight: 800; color: #92400E; letter-spacing: 0.05em; text-transform: uppercase;">Help &amp; Knowledge Base</span>
            </div>
            <h1 style="font-size: 42px; font-weight: 900; color: #0F172A; margin: 0 0 16px 0; letter-spacing: -0.03em; line-height: 1.15;">
                Frequently Asked <span style="color: #FFB800;">Questions</span>
            </h1>
            <p style="font-size: 16.5px; color: #64748B; margin: 0 auto 30px auto; line-height: 1.7; max-width: 680px;">
                Everything you need to know about our AI computer vision diagnosis, certified technician vetting, escrow payments, and customer protection.
            </p>

            <!-- Search Bar -->
            <form action="{{ route('faqs') }}" method="GET" style="max-width: 640px; margin: 0 auto; position: relative;">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div style="position: relative; display: flex; align-items: center; box-shadow: 0 8px 30px -10px rgba(15, 23, 42, 0.12); border-radius: 50px;">
                    <span style="position: absolute; left: 22px; font-size: 18px; color: #94A3B8; pointer-events: none;">🔍</span>
                    <input 
                        type="text" 
                        id="faqSearchInput"
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Type keywords like 'warranty', 'escrow', 'OTP', 'rates'..." 
                        style="width: 100%; height: 56px; border-radius: 50px; border: 1.5px solid #E2E8F0; padding: 0 130px 0 54px; font-size: 15px; outline: none; transition: border-color 0.2s ease; background: #FFFFFF; font-family: inherit;"
                        onfocus="this.style.borderColor='#FFB800'"
                        onblur="this.style.borderColor='#E2E8F0'"
                    >
                    <button type="submit" style="position: absolute; right: 7px; height: 42px; padding: 0 22px; background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; border: none; border-radius: 50px; cursor: pointer; transition: background 0.18s ease;">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- FAQs Section -->
    <section style="padding: 40px 0 70px 0;">
        <div class="container" style="max-width: 940px;">
            
            <!-- Category Filter Pills -->
            <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 20px; margin-bottom: 30px; scrollbar-width: none; -ms-overflow-style: none;">
                <a href="{{ route('faqs', array_filter(['search' => request('search')])) }}" 
                   style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 50px; text-decoration: none; font-size: 13.5px; font-weight: 700; white-space: nowrap; transition: all 0.18s ease; {{ !request('category') ? 'background: #0F172A; color: #FFFFFF; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);' : 'background: #F1F5F9; color: #475569;' }}">
                    <span>🌐</span>
                    <span>All Topics</span>
                    <span style="font-size: 11px; padding: 2px 7px; border-radius: 12px; {{ !request('category') ? 'background: rgba(255,255,255,0.2); color: #FFF;' : 'background: #E2E8F0; color: #64748B;' }}">
                        {{ $totalActiveCount }}
                    </span>
                </a>

                @foreach($categories as $catKey => $catData)
                    @php
                        $isActive = request('category') === $catKey;
                        $count = $categoryCounts[$catKey] ?? 0;
                    @endphp
                    <a href="{{ route('faqs', array_filter(['category' => $catKey, 'search' => request('search')])) }}" 
                       style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; border-radius: 50px; text-decoration: none; font-size: 13.5px; font-weight: 700; white-space: nowrap; transition: all 0.18s ease; {{ $isActive ? 'background: #FFB800; color: #0F172A; box-shadow: 0 4px 12px rgba(255, 184, 0, 0.3);' : 'background: #F8FAFC; border: 1px solid #E2E8F0; color: #475569;' }}">
                        <span>{{ $catData['icon'] }}</span>
                        <span>{{ $catData['label'] }}</span>
                        <span style="font-size: 11px; padding: 2px 7px; border-radius: 12px; {{ $isActive ? 'background: rgba(15,23,42,0.1); color: #0F172A;' : 'background: #E2E8F0; color: #64748B;' }}">
                            {{ $count }}
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Active Search Filter Feedback -->
            @if(request('search') || request('category'))
                <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 12px; padding: 14px 20px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: gap; gap: 12px;">
                    <div style="font-size: 14px; color: #334155;">
                        Showing <strong>{{ $faqs->count() }}</strong> results 
                        @if(request('search'))
                            for "<strong>{{ request('search') }}</strong>"
                        @endif
                        @if(request('category'))
                            in topic <strong>{{ $categories[request('category')]['label'] ?? request('category') }}</strong>
                        @endif
                    </div>
                    <a href="{{ route('faqs') }}" style="font-size: 13px; font-weight: 700; color: #92400E; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                        <span>✕ Clear Filters</span>
                    </a>
                </div>
            @endif

            <!-- FAQs Listing -->
            <div id="faqListContainer">
                @forelse($groupedFaqs as $catKey => $items)
                    @php
                        $catMeta = $categories[$catKey] ?? [
                            'label' => ucwords(str_replace('_', ' ', $catKey)),
                            'icon' => '❓',
                            'description' => '',
                        ];
                    @endphp

                    <div class="faq-category-block" style="margin-bottom: 46px;">
                        
                        <!-- Category Header -->
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px; padding-bottom: 12px; border-bottom: 2px solid #F1F5F9;">
                            <span style="font-size: 26px;">{{ $catMeta['icon'] }}</span>
                            <div>
                                <h2 style="font-size: 22px; font-weight: 800; color: #0F172A; margin: 0;">{{ $catMeta['label'] }}</h2>
                                @if(!empty($catMeta['description']))
                                    <p style="font-size: 13px; color: #64748B; margin: 3px 0 0 0;">{{ $catMeta['description'] }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- FAQ Questions in this Category -->
                        <div style="display: flex; flex-direction: column; gap: 14px; margin-top: 16px;">
                            @foreach($items as $index => $faq)
                                <details class="faq-item" style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 14px; padding: 20px 24px; cursor: pointer; transition: all 0.2s ease;" {{ ($loop->parent->first && $index === 0 && !request('search')) ? 'open' : '' }}>
                                    <summary style="font-size: 16px; font-weight: 800; color: #0F172A; list-style: none; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
                                        <span class="faq-question-text">{{ $faq->question }}</span>
                                        <span class="faq-toggle-icon" style="color: #FFB800; font-size: 20px; font-weight: 900; transition: transform 0.2s ease;">▾</span>
                                    </summary>
                                    <div class="faq-answer-text" style="font-size: 15px; color: #475569; line-height: 1.7; margin: 14px 0 0 0; border-top: 1px solid #E2E8F0; padding-top: 14px;">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </details>
                            @endforeach
                        </div>

                    </div>
                @empty
                    <!-- Empty State -->
                    <div style="background: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 20px; padding: 60px 24px; text-align: center; margin-bottom: 40px;">
                        <div style="font-size: 44px; margin-bottom: 14px;">🔍</div>
                        <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 8px 0;">No Questions Found</h3>
                        <p style="font-size: 14.5px; color: #64748B; max-width: 480px; margin: 0 auto 20px auto; line-height: 1.6;">
                            We couldn't find any questions matching your query. Try searching with different keywords or send us a message directly.
                        </p>
                        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('faqs') }}" style="background: #0F172A; color: #FFFFFF; font-weight: 700; font-size: 13.5px; padding: 10px 20px; border-radius: 50px; text-decoration: none;">
                                View All FAQs
                            </a>
                            <a href="{{ route('contact') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 13.5px; padding: 10px 20px; border-radius: 50px; text-decoration: none;">
                                Contact Support →
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Still Have Questions Contact Banner -->
            <div style="background: #FFFDF0; border: 2px solid #FEF08A; border-radius: 20px; padding: 36px; display: flex; align-items: center; justify-content: space-between; gap: 24px; margin-top: 20px; flex-wrap: wrap;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 800; color: #0F172A; margin: 0 0 6px 0;">Have a question that is not listed here?</h3>
                    <p style="font-size: 14px; color: #64748B; margin: 0; line-height: 1.6;">Our support representatives in Islamabad, Lahore, and Karachi are available 7 days a week.</p>
                </div>
                <div style="display: flex; gap: 12px; flex-shrink: 0;">
                    <a href="{{ route('contact') }}" style="background: #FFB800; color: #0F172A; font-weight: 800; font-size: 14px; padding: 11px 24px; border-radius: 10px; text-decoration: none; transition: transform 0.15s ease;">
                        Submit an Inquiry →
                    </a>
                </div>
            </div>

        </div>
    </section>

</div>

<script>
    // Live instantaneous client-side search filter as user types
    document.getElementById('faqSearchInput').addEventListener('input', function(e) {
        var query = e.target.value.toLowerCase().trim();
        var faqItems = document.querySelectorAll('.faq-item');
        var categories = document.querySelectorAll('.faq-category-block');

        faqItems.forEach(function(item) {
            var q = item.querySelector('.faq-question-text').textContent.toLowerCase();
            var a = item.querySelector('.faq-answer-text').textContent.toLowerCase();

            if (q.includes(query) || a.includes(query)) {
                item.style.display = 'block';
                if (query.length > 2) {
                    item.open = true;
                }
            } else {
                item.style.display = 'none';
            }
        });

        // Hide empty categories if all their items are hidden
        categories.forEach(function(cat) {
            var visibleItems = cat.querySelectorAll('.faq-item[style*="display: block"]');
            var allItems = cat.querySelectorAll('.faq-item');
            var hasVisible = false;
            
            allItems.forEach(function(it) {
                if (it.style.display !== 'none') {
                    hasVisible = true;
                }
            });

            cat.style.display = hasVisible ? 'block' : 'none';
        });
    });
</script>

<style>
details[open] summary .faq-toggle-icon {
    transform: rotate(180deg);
}
details[open] {
    border-color: #FFB800 !important;
    background: #FFFFFF !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}
</style>
@endsection
