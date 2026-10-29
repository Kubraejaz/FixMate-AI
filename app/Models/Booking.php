<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'professional_id',
        'profession_id',
        'service_title',
        'problem_description',
        'problem_image',
        'service_date',
        'service_time_slot',
        'service_address',
        'city',
        'technician_latitude',
        'technician_longitude',
        'destination_latitude',
        'destination_longitude',
        'tracking_eta_minutes',
        'location_updated_at',
        'status',
        'arrival_otp',
        'base_price',
        'total_price',
        'platform_fee',
        'technician_payout',
        'commission_rate',
        'payment_status',
        'payment_method',
        'cancellation_reason',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'service_date' => 'date',
            'base_price' => 'integer',
            'total_price' => 'integer',
            'platform_fee' => 'integer',
            'technician_payout' => 'integer',
            'commission_rate' => 'float',
            'tracking_eta_minutes' => 'integer',
            'technician_latitude' => 'float',
            'technician_longitude' => 'float',
            'destination_latitude' => 'float',
            'destination_longitude' => 'float',
            'location_updated_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Compute platform commission, convenience fee, and technician net payout.
     */
    public function calculateFinancials(?Professional $pro = null): self
    {
        if ($pro === null && $this->professional_id) {
            $pro = $this->professional;
        }

        $rate = $pro ? $pro->getCommissionRate() : (float) cache('platform_commission', 10.0);
        $total = (int) ($this->total_price ?: $this->base_price ?: 650);

        $fee = (int) round(($total * $rate) / 100);
        $payout = max(0, $total - $fee);

        $this->commission_rate = $rate;
        $this->platform_fee = $fee;
        $this->technician_payout = $payout;

        return $this;
    }

    protected static function booted(): void
    {
        static::creating(function (Booking $booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = static::generateBookingNumber();
            }
            if (empty($booking->arrival_otp)) {
                $booking->arrival_otp = static::generateOtp();
            }
            if (empty($booking->service_date)) {
                $booking->service_date = now()->toDateString();
            }
            if (empty($booking->service_time_slot)) {
                $booking->service_time_slot = '10:00 AM - 12:00 PM';
            }
            if (empty($booking->service_address)) {
                $booking->service_address = 'Address not specified';
            }
            if (empty($booking->city)) {
                $booking->city = 'Karachi';
            }

            if ($booking->technician_payout === null || $booking->technician_payout === 0) {
                $booking->calculateFinancials();
            }
        });
    }

    public static function generateBookingNumber(): string
    {
        do {
            $num = 'FM-' . rand(10000, 99999);
        } while (static::where('booking_number', $num)->exists());

        return $num;
    }

    public static function generateOtp(): string
    {
        return str_pad((string) rand(1000, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Resolve route binding by either primary key or booking_number.
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return is_numeric($value)
            ? $this->where('id', $value)->first()
            : $this->where('booking_number', $value)->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function videoMeetings(): HasMany
    {
        return $this->hasMany(VideoMeeting::class);
    }

    public function latestVideoMeeting(): HasOne
    {
        return $this->hasOne(VideoMeeting::class)->latestOfMany();
    }

    /**
     * Check if a given user is the customer who made this booking.
     */
    public function isCustomer(User|int $user): bool
    {
        $userId = $user instanceof User ? $user->id : (int) $user;
        return (int) $this->user_id === $userId;
    }

    /**
     * Check if a given user or technician is the assigned professional.
     */
    public function isAssignedTechnician(User|int $user): bool
    {
        if ($user instanceof User) {
            return $this->professional && (int) $this->professional->user_id === $user->id;
        }

        return (int) $this->professional_id === (int) $user;
    }

    /**
     * Determine if a user can view or manage this booking.
     */
    public function canBeManagedBy(User $user): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $this->isCustomer($user) || $this->isAssignedTechnician($user);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Awaiting Technician',
            'confirmed' => 'Confirmed & Assigned',
            'en_route' => 'En Route (ETA < 20m)',
            'in_progress' => 'Work In Progress',
            'completed' => 'Completed & Released',
            'cancelled' => 'Cancelled',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'en_route' => 'yellow',
            'in_progress' => 'blue',
            'completed' => 'green',
            'cancelled' => 'gray',
            default => 'gray',
        };
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rs. ' . number_format($this->total_price);
    }

    /**
     * Get or calculate default destination and technician coordinates.
     */
    public function getLiveTrackingPayload(): array
    {
        // City coordinate anchor presets
        $cityPresets = [
            'karachi' => ['dest_lat' => 24.8716, 'dest_lng' => 67.0599, 'tech_lat' => 24.8530, 'tech_lng' => 67.0250],
            'lahore' => ['dest_lat' => 31.5497, 'dest_lng' => 74.3436, 'tech_lat' => 31.5204, 'tech_lng' => 74.3210],
            'islamabad' => ['dest_lat' => 33.7294, 'dest_lng' => 73.0931, 'tech_lat' => 33.6980, 'tech_lng' => 73.0450],
            'rawalpindi' => ['dest_lat' => 33.5950, 'dest_lng' => 73.0550, 'tech_lat' => 33.5651, 'tech_lng' => 73.0169],
        ];

        $cityKey = strtolower(trim($this->city ?: 'karachi'));
        $preset = $cityPresets[$cityKey] ?? $cityPresets['karachi'];

        $destLat = $this->destination_latitude ?? $preset['dest_lat'];
        $destLng = $this->destination_longitude ?? $preset['dest_lng'];

        $techLat = $this->technician_latitude ?? $preset['tech_lat'];
        $techLng = $this->technician_longitude ?? $preset['tech_lng'];

        // Calculate real-time distance using Haversine
        $dLat = deg2rad($destLat - $techLat);
        $dLon = deg2rad($destLng - $techLng);
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($techLat)) * cos(deg2rad($destLat)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distanceKm = round(6371 * $c, 2);

        // Approximate city traffic ETA (average speed 25 km/h)
        $computedEta = max(2, (int) round(($distanceKm / 25) * 60));
        $etaMinutes = $this->tracking_eta_minutes ?? $computedEta;

        return [
            'booking_id' => $this->id,
            'booking_number' => $this->booking_number,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'technician' => [
                'name' => $this->professional?->name ?? 'Verified FixMate Partner',
                'profession' => $this->profession?->name ?? 'Technician',
                'lat' => $techLat,
                'lng' => $techLng,
                'phone' => $this->professional?->phone ?? $this->professional?->user?->phone ?? '+92 300 1234567',
                'rating' => $this->professional?->rating ?? '4.9',
                'updated_at' => $this->location_updated_at ? $this->location_updated_at->diffForHumans() : 'Just now',
            ],
            'destination' => [
                'address' => $this->service_address,
                'city' => $this->city,
                'lat' => $destLat,
                'lng' => $destLng,
            ],
            'distance_km' => $distanceKm,
            'eta_minutes' => $etaMinutes,
            'arrival_otp' => $this->arrival_otp,
            'is_arrived' => $distanceKm <= 0.08 || in_array($this->status, ['in_progress', 'completed']),
        ];
    }

    /**
     * Check if the booking service date is near (today, tomorrow, or within 2 days).
     */
    public function isDateNear(): bool
    {
        if (! $this->service_date || in_array($this->status, ['completed', 'cancelled'])) {
            return false;
        }

        $today = now()->startOfDay();
        $date = $this->service_date->copy()->startOfDay();
        $diffDays = (int) $today->diffInDays($date, false);

        return $diffDays >= 0 && $diffDays <= 2;
    }

    /**
     * Get a human-friendly label for near booking date.
     */
    public function getDateNearLabel(): ?string
    {
        if (! $this->isDateNear()) {
            return null;
        }

        if ($this->service_date->isToday()) {
            return 'Today';
        }

        if ($this->service_date->isTomorrow()) {
            return 'Tomorrow';
        }

        return $this->service_date->format('l, M d');
    }
}
