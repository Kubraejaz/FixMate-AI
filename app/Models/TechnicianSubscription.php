<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicianSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'plan_name',
        'price',
        'payment_method',
        'transaction_reference',
        'status',
        'starts_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->expires_at === null || $this->expires_at->isFuture());
    }

    public static function generateReference(): string
    {
        do {
            $ref = 'SUB-'.strtoupper(bin2hex(random_bytes(4)));
        } while (self::where('transaction_reference', $ref)->exists());

        return $ref;
    }
}
