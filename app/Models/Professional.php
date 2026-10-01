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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }
}
