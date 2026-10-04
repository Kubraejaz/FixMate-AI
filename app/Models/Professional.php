<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
