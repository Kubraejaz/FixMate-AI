<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public const TYPE_ADMIN = 1;
    public const TYPE_CUSTOMER = 2;
    public const TYPE_TECHNICIAN = 3;

    // Aliases for backward compatibility
    public const ROLE_ADMIN = 1;
    public const ROLE_CUSTOMER = 2;
    public const ROLE_TECHNICIAN = 3;

    public const ROLE_NAMES = [
        self::TYPE_ADMIN => 'admin',
        self::TYPE_CUSTOMER => 'customer',
        self::TYPE_TECHNICIAN => 'technician',
    ];

    public const ROLE_LABELS = [
        self::TYPE_ADMIN => 'Administrator',
        self::TYPE_CUSTOMER => 'Customer',
        self::TYPE_TECHNICIAN => 'Technician / Partner',
    ];

    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

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
        'subscription_plan',
        'subscribed_until',
        'city',
        'area',
        'description',
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
        'subscription_plan' => 'free',
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
            'subscribed_until' => 'datetime',
            'cnic_number' => 'encrypted',
            'email_verified_at' => 'datetime',
            'contact_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'notification_settings' => 'array',
        ];
    }

    public function isVip(): bool
    {
        return $this->subscription_plan !== 'free'
            && ! empty($this->subscription_plan)
            && $this->subscribed_until !== null
            && $this->subscribed_until->isFuture();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->isVip();
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

    /**
     * Get textual role name string ('admin', 'customer', 'technician').
     */
    public function getRoleNameAttribute(): string
    {
        return self::ROLE_NAMES[(int) ($this->user_type ?? self::TYPE_CUSTOMER)] ?? 'customer';
    }

    /**
     * Get human-friendly role label string.
     */
    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[(int) ($this->user_type ?? self::TYPE_CUSTOMER)] ?? 'Customer';
    }

    /**
     * Check if user has a specific role (by string, integer, or array of roles).
     */
    public function hasRole(string|int|array $roles): bool
    {
        if (is_array($roles)) {
            return $this->hasAnyRole(...$roles);
        }

        $typeMap = [
            '1' => self::TYPE_ADMIN,
            'admin' => self::TYPE_ADMIN,
            '2' => self::TYPE_CUSTOMER,
            'customer' => self::TYPE_CUSTOMER,
            '3' => self::TYPE_TECHNICIAN,
            'technician' => self::TYPE_TECHNICIAN,
            'provider' => self::TYPE_TECHNICIAN,
        ];

        $expectedType = $typeMap[strtolower((string) $roles)] ?? (int) $roles;

        return (int) $this->user_type === $expectedType;
    }

    /**
     * Check if user matches any of the given roles.
     */
    public function hasAnyRole(string|int|array ...$roles): bool
    {
        foreach ($roles as $role) {
            if (is_array($role)) {
                if ($this->hasAnyRole(...$role)) {
                    return true;
                }
            } elseif ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles(string|int|array ...$roles): bool
    {
        foreach ($roles as $role) {
            if (is_array($role)) {
                if (! $this->hasAllRoles(...$role)) {
                    return false;
                }
            } elseif (! $this->hasRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if user has permission to perform an action.
     */
    public function hasPermission(string $permission): bool
    {
        return \App\Support\Permissions::roleHas($this->user_type, $permission);
    }

    /**
     * Get list of all permissions user possesses.
     */
    public function getPermissions(): array
    {
        return \App\Support\Permissions::forRole($this->user_type);
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

    public function technicianApplications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TechnicianApplication::class);
    }

    public function technicianApplication(): HasOne
    {
        return $this->hasOne(TechnicianApplication::class)->latestOfMany();
    }

    public function communityIssues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityIssue::class);
    }

    public function communityIssueUpvotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CommunityIssueUpvote::class);
    }

    public function callerMeetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VideoMeeting::class, 'caller_id');
    }

    public function receiverMeetings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VideoMeeting::class, 'receiver_id');
    }

    public function contactInquiries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContactInquiry::class, 'email', 'email');
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