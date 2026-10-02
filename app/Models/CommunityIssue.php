<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CommunityIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'user_id',
        'reporter_name',
        'reporter_role',
        'reporter_phone',
        'title',
        'description',
        'category',
        'city',
        'location',
        'status',
        'status_update',
        'priority',
        'upvotes_count',
        'is_approved',
        'resolved_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'upvotes_count' => 'integer',
        'resolved_at' => 'datetime',
    ];

    public const CATEGORIES = [
        'water_supply' => [
            'label' => 'Water Supply',
            'icon' => '💧',
            'badge_bg' => '#E0F2FE',
            'badge_color' => '#0369A1',
        ],
        'electrical_hazard' => [
            'label' => 'Electrical Hazard',
            'icon' => '⚡',
            'badge_bg' => '#FEE2E2',
            'badge_color' => '#991B1B',
        ],
        'sewerage' => [
            'label' => 'Sewerage & Drainage',
            'icon' => '🚰',
            'badge_bg' => '#FEF3C7',
            'badge_color' => '#92400E',
        ],
        'street_light' => [
            'label' => 'Street Light',
            'icon' => '💡',
            'badge_bg' => '#FEF9C3',
            'badge_color' => '#854D0E',
        ],
        'gas_pipeline' => [
            'label' => 'Gas Pipeline Hazard',
            'icon' => '🔥',
            'badge_bg' => '#FFE4E6',
            'badge_color' => '#9F1239',
        ],
        'road_pothole' => [
            'label' => 'Road Damage / Pothole',
            'icon' => '🚧',
            'badge_bg' => '#F1F5F9',
            'badge_color' => '#475569',
        ],
        'general' => [
            'label' => 'Civic Maintenance',
            'icon' => '🏘️',
            'badge_bg' => '#F1F5F9',
            'badge_color' => '#334155',
        ],
    ];

    public const CITIES = [
        'Karachi',
        'Lahore',
        'Islamabad',
        'Rawalpindi',
        'Faisalabad',
        'Multan',
        'Peshawar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(CommunityIssueUpvote::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    public function getCategoryMetaAttribute(): array
    {
        return self::CATEGORIES[$this->category] ?? self::CATEGORIES['general'];
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'alert_active' => ['label' => 'Alert Active', 'bg' => '#FEE2E2', 'color' => '#991B1B', 'border' => '#FECDD3'],
            'in_progress' => ['label' => 'In Progress', 'bg' => '#FEF3C7', 'color' => '#92400E', 'border' => '#FDE68A'],
            'scheduled' => ['label' => 'Scheduled', 'bg' => '#E0F2FE', 'color' => '#0369A1', 'border' => '#BAE6FD'],
            'resolved' => ['label' => '✓ Resolved', 'bg' => '#ECFDF5', 'color' => '#047857', 'border' => '#A7F3D0'],
            default => ['label' => 'Reported', 'bg' => '#F8FAFC', 'color' => '#475569', 'border' => '#E2E8F0'],
        };
    }

    public function isUpvotedBy(?User $user, ?string $ip): bool
    {
        if ($user) {
            $hasVoted = $this->upvotes()->where('user_id', $user->id)->exists();
            if ($hasVoted) {
                return true;
            }
        }

        if ($ip) {
            return $this->upvotes()->where('ip_address', $ip)->exists();
        }

        return false;
    }
}
