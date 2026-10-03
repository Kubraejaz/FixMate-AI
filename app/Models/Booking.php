<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'status',
        'arrival_otp',
        'base_price',
        'total_price',
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
            'completed_at' => 'datetime',
        ];
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
}
