<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function professionals(): HasMany
    {
        return $this->hasMany(Professional::class);
    }

    public function technicians(): HasMany
    {
        return $this->hasMany(User::class, 'profession_id')->where('user_type', User::TYPE_TECHNICIAN);
    }
}
