<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'trade',
        'rating',
        'comment',
        'avatar',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get avatar url with sensible fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://'))) {
            return $this->avatar;
        }

        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        }

        return asset('assets/images/image_2.png');
    }
}
