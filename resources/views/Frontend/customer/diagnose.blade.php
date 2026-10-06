@extends('Frontend.layouts.customer')

@section('title', 'Request a Service — FixMate')

@section('content')
<div style="max-width: 820px; margin: 0 auto;">
    
    <!-- Title matching Mockup 1 & 2 -->
    <div style="margin-bottom: 24px;">
        <h1 style="font-size: 26px; font-weight: 900; color: #111; margin-bottom: 6px;">Describe Your Repair Issue</h1>
        <p style="font-size: 14.5px; color: #666; margin: 0;">Tell us what's wrong and attach optional photos. We will match you with certified local technicians and provide upfront tariff pricing.</p>
    </div>

    <div class="portal-card" style="padding: 32px; background: #FFFFFF;">
        <form action="{{ route('customer.ai-result') }}" method="POST" enctype="multipart/form-data" id="diagnoseForm">
            @csrf
            
            <!-- Category / Trade Selection -->
            <div class="form-group" style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 8px;">
                    <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin: 0;">Trade Category Selection</label>
                    <span style="font-size: 11.5px; color: #64748B;">Choose your trade or let us match from your description</span>
                </div>
                <select name="category" class="form-input" style="font-size: 13.5px; padding: 10px 14px;">
                    <option value="auto" {{ !request('category') || request('category') === 'auto' ? 'selected' : '' }}>
                        🛠️ Auto-Match Trade from Problem Description
                    </option>
                    @foreach($professions as $prof)
                        <option value="{{ $prof->slug }}" {{ request('category') == $prof->slug ? 'selected' : '' }}>
                            {{ $prof->name }} (Base Inspection: Rs. {{ number_format($prof->base_price) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- What problem are you facing? -->
            <div class="form-group" style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin-bottom: 8px;">What problem are you facing?</label>
                <textarea name="issue" class="form-input" rows="4" style="font-size: 14px; line-height: 1.6; padding: 12px 14px;" placeholder="Describe your issue in detail (e.g. 'Split AC outdoor unit is making a loud buzzing sound and indoor is not cooling', 'Kitchen pipe under sink is leaking water', 'Main circuit breaker tripped with burning smell', 'Wooden door is jammed and won't lock')...">{{ old('issue', request('q', $queryText ?: '')) }}</textarea>
            </div>

            <!-- Upload Photos (Drag & Drop + Interactive File Input) -->
            <div class="form-group" style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <label class="form-label" style="font-size: 13.5px; font-weight: 800; color: #111; margin: 0;">Attach Photos of the Issue (Optional)</label>
                    <span style="font-size: 12px; color: #10B981; font-weight: 600;">✓ Supports JPG, PNG, WEBP up to 10MB</span>
                </div>
                
                <!-- Hidden file input for real selection -->
                <input type="file" id="defect_photo_input" name="defect_photo" accept="image/*" style="display: none;">

                <div style="display: grid; grid-template-columns: 200px 1fr; gap: 18px; align-items: stretch;">
                    
                    <!-- Clickable Upload Dropzone -->
                    <div id="dropzoneBox" 
                         style="border: 2px dashed #D1D5DB; border-radius: 14px; padding: 24px 16px; text-align: center; background: #F9FAFB; cursor: pointer; transition: all 0.2s ease; display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 130px;"
                         tabindex="0"
                         role="button"
                         aria-label="Upload photo for technician">
                        <div style="font-size: 30px; margin-bottom: 6px; pointer-events: none;">📷</div>
                        <strong style="display: block; font-size: 13px; color: #111; pointer-events: none;">Click to Attach Photo</strong>
                        <span style="font-size: 11px; color: #6B7280; pointer-events: none;">or drag and drop here</span>
                    </div>

                    <!-- Active Image Preview Container -->
                    <div id="previewCard" style="display: flex; gap: 14px; align-items: center; background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 14px; padding: 12px 16px;">
                        
                        <!-- Main Preview Thumbnail -->
                        <div style="position: relative; width: 110px; height: 105px; border-radius: 12px; overflow: hidden; border: 2px solid #FFB800; flex-shrink: 0; background: #FFF;">
                            <img id="previewImg" src="{{ asset('assets/images/image_6.png') }}" alt="Defect Preview" style="width: 100%; height: 100%; object-fit: cover;">
                            <span id="removeBtn" title="Remove image" style="position: absolute; top: 4px; right: 4px; background: rgba(0,0,0,0.65); color: #FFF; width: 20px; height: 20px; border-radius: 50%; font-size: 11px; display: flex; align-items: center; justify-content: center; cursor: pointer; border: none;">✕</span>
                            <span id="photoBadge" style="position: absolute; bottom: 4px; left: 4px; background: #10B981; color: #FFF; font-size: 9px; font-weight: 800; padding: 2px 6px; border-radius: 4px;">Photo Attached</span>
                        </div>

                        <!-- Image Status & Meta -->
                        <div style="flex: 1;">
                            <strong id="previewFileName" style="display: block; font-size: 13.5px; color: #0F172A; word-break: break-all; margin-bottom: 4px;">Sample: kitchen_sink_leak.jpg</strong>
                            <p id="previewFileMeta" style="font-size: 12px; color: #64748B; margin: 0 0 10px 0;">Photo attached for technician review before arrival.</p>
                            <button type="button" id="changeImageBtn" style="background: none; border: 1px solid #CBD5E1; color: #0F172A; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 6px; cursor: pointer;">
                                🔄 Replace Photo
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Two Selects: Location & Urgency -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 800; color: #111; margin-bottom: 6px;">Select Location</label>
                    <select name="city" class="form-input" style="font-size: 13.5px; padding: 10px 14px;">
                        <option value="Karachi">Karachi, Pakistan (DHA Phase 6)</option>
                        <option value="Karachi">Karachi, Clifton Block 4</option>
                        <option value="Lahore">Lahore, Gulberg III</option>
                        <option value="Islamabad">Islamabad, Sector F-8/2</option>
                    </select>
                </div>

                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 800; color: #111; margin-bottom: 6px;">Urgency Level</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <label style="border: 2px solid #FFCC00; background: #FFFDF0; padding: 9px 12px; border-radius: 10px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="urgency" value="normal" checked style="accent-color: #FFCC00;">
                            <div>
                                <strong style="font-size: 13px; color: #111; display: block;">Normal</strong>
                                <span style="font-size: 10.5px; color: #777;">Within 24 Hours</span>
                            </div>
                        </label>
                        <label style="border: 1px solid var(--border-color); background: #FFF; padding: 9px 12px; border-radius: 10px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="radio" name="urgency" value="urgent" style="accent-color: #FFCC00;">
                            <div>
                                <strong style="font-size: 13px; color: #DC2626; display: block;">Urgent</strong>
                                <span style="font-size: 10.5px; color: #777;">Within 30 Mins</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit CTA -->
            <button type="submit" class="btn-yellow" style="width: 100%; padding: 13px 0; font-size: 15px; font-weight: 900; border-radius: 12px; border: none; cursor: pointer;">
                Find Available Technicians &amp; Upfront Pricing →
            </button>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('defect_photo_input');
    const dropzone = document.getElementById('dropzoneBox');
    const previewImg = document.getElementById('previewImg');
    const photoBadge = document.getElementById('photoBadge');
    const fileNameSpan = document.getElementById('previewFileName');
    const fileMetaSpan = document.getElementById('previewFileMeta');
    const removeBtn = document.getElementById('removeBtn');
    const changeBtn = document.getElementById('changeImageBtn');
    const defaultSampleUrl = "{{ asset('assets/images/image_6.png') }}";

    // 1. Click dropzone triggers file picker
    dropzone.addEventListener('click', function (e) {
        fileInput.click();
    });

    changeBtn.addEventListener('click', function (e) {
        e.preventDefault();
        fileInput.click();
    });

    // 2. Keyboard support (Enter or Space)
    dropzone.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            fileInput.click();
        }
    });

    // 3. Drag and Drop handlers
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.style.borderColor = '#FFB800';
            dropzone.style.background = '#FFFDF0';
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.style.borderColor = '#D1D5DB';
            dropzone.style.background = '#F9FAFB';
        });
    });

    dropzone.addEventListener('drop', function (e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length > 0) {
            fileInput.files = files;
            handleFileSelect(files[0]);
        }
    });

    // 4. Change event on input
    fileInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            handleFileSelect(this.files[0]);
        }
    });

    function handleFileSelect(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file (JPG, PNG, WEBP)');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            fileNameSpan.textContent = file.name;
            const sizeInKb = Math.round(file.size / 1024);
            fileMetaSpan.textContent = `Attached file: ${sizeInKb} KB • Photo will be shared with the technician.`;
            photoBadge.textContent = 'Photo Attached';
            photoBadge.style.background = '#10B981';
            dropzone.style.borderColor = '#10B981';
            dropzone.style.background = '#F0FDF4';
        };
        reader.readAsDataURL(file);
    }

    // 5. Remove button resets to default
    removeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        fileInput.value = '';
        previewImg.src = defaultSampleUrl;
        fileNameSpan.textContent = 'Sample: kitchen_sink_leak.jpg';
        fileMetaSpan.textContent = 'Default sample preview.';
        photoBadge.textContent = 'Sample Preview';
        photoBadge.style.background = '#94A3B8';
        dropzone.style.borderColor = '#D1D5DB';
        dropzone.style.background = '#F9FAFB';
    });
});
</script>
@endsection
