<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const TYPE_ADMIN = 1;
    public const TYPE_CUSTOMER = 2;
    public const TYPE_TECHNICIAN = 3;

    // Aliases for backward compatibility
    public const ROLE_ADMIN = 1;
    public const ROLE_CUSTOMER = 2;
    public const ROLE_TECHNICIAN = 3;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'user_type',
        'profession_id',
        'experience',
        'cnic_number',
        'is_verified',
        'is_active',
        'city',
        'area',
        'notification_settings',
        'contact_verified_at',
        'last_login_at',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'otp_code',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_type' => 'integer',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'cnic_number' => 'encrypted',
            'email_verified_at' => 'datetime',
            'contact_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'notification_settings' => 'array',
        ];
    }

    /**
     * Legacy role attribute accessor/mutator for seamless backward compatibility.
     */
    public function getRoleAttribute(): int
    {
        return (int) ($this->user_type ?? self::TYPE_CUSTOMER);
    }

    public function setRoleAttribute(mixed $value): void
    {
        if ($value === 'admin' || $value === 1 || $value === '1') {
            $value = self::TYPE_ADMIN;
        } elseif ($value === 'customer' || $value === 2 || $value === '2') {
            $value = self::TYPE_CUSTOMER;
        } elseif ($value === 'technician' || $value === 3 || $value === '3') {
            $value = self::TYPE_TECHNICIAN;
        }

        $this->attributes['user_type'] = (int) $value;
    }

    public function isAdmin(): bool
    {
        return (int) $this->user_type === self::TYPE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return (int) $this->user_type === self::TYPE_CUSTOMER;
    }

    public function isTechnician(): bool
    {
        return (int) $this->user_type === self::TYPE_TECHNICIAN;
    }

    public function dashboardRoute(): string
    {
        return match ((int) $this->user_type) {
            self::TYPE_ADMIN => '/admin/dashboard',
            self::TYPE_TECHNICIAN => '/technician/dashboard',
            default => '/customer/dashboard',
        };
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function professional(): HasOne
    {
        return $this->hasOne(Professional::class);
    }

    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function notifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function sentMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function getNotificationPref(string $key, bool $default = true): bool
    {
        $prefs = $this->notification_settings ?? [
            'sms' => true,
            'whatsapp' => true,
            'email' => true,
            'push' => true,
        ];

        return (bool) ($prefs[$key] ?? $default);
    }
}