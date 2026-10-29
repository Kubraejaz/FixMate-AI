<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profession_id',
        'name',
        'email',
        'phone',
        'experience',
        'description',
        'sub_categories',
        'subscription_plan',
        'subscribed_until',
        'is_featured',
        'cnic_number',
        'is_verified',
        'verification_status',
        'biometric_status',
        'rejection_reason',
        'cnic_front_path',
        'cnic_back_path',
        'biometric_selfie_path',
        'police_certificate_path',
        'trade_license_path',
        'proof_of_address_path',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $hidden = [
        'cnic_number',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'subscribed_until' => 'datetime',
            'sub_categories' => 'array',
            'cnic_number' => 'encrypted',
        ];
    }

    public function getDocumentUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return asset('storage/' . ltrim($path, '/'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(TechnicianSubscription::class);
    }

    public function application(): HasOne
    {
        return $this->hasOne(TechnicianApplication::class, 'user_id', 'user_id');
    }

    /**
     * Get available wallet balance for technician.
     * Calculated as lifetime earnings from completed jobs minus any subscription fees paid via wallet.
     */
    public function getAvailableWalletBalance(): int
    {
        $completedBookings = $this->bookings()
            ->where('status', 'completed')
            ->get();

        $lifetimeEarnings = (int) $completedBookings->sum(function ($b) {
            return $b->technician_payout ?: round($b->total_price * 0.90);
        });

        $walletDeductions = (int) $this->subscriptions()
            ->where('payment_method', 'wallet')
            ->whereIn('status', ['active', 'expired', 'completed'])
            ->sum('price');

        return max(0, $lifetimeEarnings - $walletDeductions);
    }

    /**
     * Check if technician has an active VIP Pro subscription (0% commission perk).
     */
    public function hasActiveProSubscription(): bool
    {
        if ($this->subscription_plan === 'free' || empty($this->subscription_plan)) {
            return false;
        }

        return $this->subscribed_until !== null && $this->subscribed_until->isFuture();
    }

    public function isPro(): bool
    {
        return $this->hasActiveProSubscription();
    }

    /**
     * Determine platform commission rate applied to this technician.
     * VIP Pro subscribers enjoy 0% platform commission!
     * Standard free tier pays platform commission (default 10%).
     */
    public function getCommissionRate(): float
    {
        if ($this->hasActiveProSubscription()) {
            return 0.0;
        }

        return (float) cache('platform_commission', 10.0);
    }

    /**
     * Determine if technician is currently online or available for dispatch.
     */
    public function isOnline(): bool
    {
        if ($this->user && ! $this->user->is_active) {
            return false;
        }

        if ($this->user?->last_login_at && $this->user->last_login_at->diffInHours(now()) <= 2) {
            return true;
        }

        return (bool) ($this->is_verified ?? false);
    }
}
