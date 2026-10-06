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
        'base_price',
        'price_unit',
        'estimated_duration',
        'headline',
        'image',
        'warranty_text',
        'feature_points',
        'included_items',
        'excluded_items',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'base_price' => 'integer',
            'feature_points' => 'array',
            'included_items' => 'array',
            'excluded_items' => 'array',
        ];
    }

    public function getFormattedPriceAttribute(): string
    {
        $amount = number_format($this->base_price ?? 650);
        return "Rs. {$amount}";
    }

    public function getDisplayIconAttribute(): string
    {
        $iconMap = [
            'plumber' => '💧',
            'plumbing' => '💧',
            'electrician' => '⚡',
            'electrical' => '⚡',
            'ac-refrigeration' => '❄️',
            'ac-cooling' => '❄️',
            'deep-cleaning' => '🧹',
            'cleaning' => '🧹',
            'painter' => '🖌️',
            'painting' => '🖌️',
            'carpenter' => '🔨',
            'carpentry' => '🔨',
            'home-appliances' => '🧺',
            'appliances' => '🧺',
            'cctv-smart-security' => '📹',
            'solar-specialist' => '☀️',
            'solar-ups' => '☀️',
            'handyman-masonry' => '🔨',
            'pest-control' => '🛡️',
        ];

        if (! empty($this->icon) && mb_strlen($this->icon, 'UTF-8') <= 4) {
            return $this->icon;
        }

        return $iconMap[$this->slug] ?? ($this->icon ? '🔧' : '🔧');
    }

    public function getFeaturePointsListAttribute(): array
    {
        if (is_array($this->feature_points) && count($this->feature_points) > 0) {
            return $this->feature_points;
        }

        return [
            'Certified background-checked diagnostic inspection',
            'Standard professional labor and safety calibration',
            'Escrow-backed rework protection guarantee',
        ];
    }

    public function getIncludedListAttribute(): array
    {
        if (is_array($this->included_items) && count($this->included_items) > 0) {
            return $this->included_items;
        }

        return $this->feature_points_list;
    }

    public function getExcludedListAttribute(): array
    {
        if (is_array($this->excluded_items) && count($this->excluded_items) > 0) {
            return $this->excluded_items;
        }

        return [
            'Replacement spare parts or external hardware (billed at actual receipt)',
            'Structural demolition or masonry excavation work',
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

