@if ($errors->any())
    <div style="margin-bottom: 18px; padding: 12px 16px; background: #FEF2F2; border: 1px solid #FECACA; border-radius: 12px; font-size: 13px; color: #B91C1C;">
        <strong style="display: block; margin-bottom: 4px;">Please fix the following:</strong>
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

@if (session('status'))
    <div style="margin-bottom: 18px; padding: 12px 16px; background: #ECFDF5; border: 1px solid #A7F3D0; border-radius: 12px; font-size: 13px; color: #047857;">
        {{ session('status') }}
    </div>
@endif

@if (session('info'))
    <div style="margin-bottom: 18px; padding: 12px 16px; background: #FFFDF0; border: 1px solid #FEF08A; border-radius: 12px; font-size: 13px; color: #92400E; display: flex; align-items: center; gap: 8px;">
        <span style="font-size: 16px;">💡</span>
        <span>{{ session('info') }}</span>
    </div>
@endif