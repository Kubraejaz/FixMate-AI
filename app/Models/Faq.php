<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Map of available categories with label, icon, and description.
     */
    public const CATEGORIES = [
        'pricing_booking' => [
            'label' => 'Service Pricing & Booking',
            'icon' => '🏷️',
            'description' => 'Upfront pricing tariff, problem description, photos, and repair quotes.',
        ],
        'trust_safety' => [
            'label' => 'Trust, Safety & Arrival OTP',
            'icon' => '🛡️',
            'description' => 'NADRA biometric verification, police clearances, and arrival OTP codes.',
        ],
        'payments_escrow' => [
            'label' => 'Payments & Escrow Protection',
            'icon' => '💳',
            'description' => 'Secure escrow vaults, payment methods, and automated release policies.',
        ],
        'warranty_guarantee' => [
            'label' => 'Warranty & Customer Protection',
            'icon' => '✨',
            'description' => '30-day workmanship warranties, re-inspection protocol, and guarantees.',
        ],
        'general' => [
            'label' => 'General & Platform Support',
            'icon' => 'ℹ️',
            'description' => 'Account setup, bookings, technician booking flow, and general questions.',
        ],
    ];

    /**
     * Scope only active FAQs.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by sort_order ascending then id ascending.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get the human-readable category label.
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category]['label'] ?? ucwords(str_replace('_', ' ', $this->category));
    }

    /**
     * Get category icon emoji.
     */
    public function getCategoryIconAttribute(): string
    {
        return self::CATEGORIES[$this->category]['icon'] ?? '❓';
    }
}
