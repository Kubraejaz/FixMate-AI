<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_ADMIN = 1;

    public const ROLE_TECHNICIAN = 2;

    public const ROLE_CUSTOMER = 3;

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
        'role',
        'is_active',
        'city',
        'area',
        'contact_verified_at',
        'last_login_at',
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
            'role' => 'integer',
            'is_active' => 'boolean',
            'email_verified_at' => 'datetime',
            'contact_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isTechnician(): bool
    {
        return $this->role === self::ROLE_TECHNICIAN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => '/admin/dashboard',
            self::ROLE_TECHNICIAN => '/technician/dashboard',
            default => '/customer/dashboard',
        };
    }

    public function technicianProfile(): HasOne
    {
        return $this->hasOne(Technician::class);
    }
}