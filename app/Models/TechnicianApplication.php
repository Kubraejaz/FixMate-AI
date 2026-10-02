<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicianApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'user_id',
        'profession_id',
        'name',
        'phone',
        'email',
        'cnic_number',
        'city',
        'experience_years',
        'workshop_type',
        'tools_available',
        'documents_list',
        'status',
        'admin_notes',
        'reviewed_at',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'reviewed_at' => 'datetime',
    ];

    public function profession(): BelongsTo
    {
        return $this->belongsTo(Profession::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'approved' => ['label' => 'Approved', 'class' => 'green', 'bg' => '#ECFDF5', 'color' => '#047857'],
            'rejected' => ['label' => 'Rejected', 'class' => 'red', 'bg' => '#FFF1F2', 'color' => '#BE123C'],
            'under_review' => ['label' => 'Under Review', 'class' => 'blue', 'bg' => '#EFF6FF', 'color' => '#1D4ED8'],
            default => ['label' => 'Pending Review', 'class' => 'yellow', 'bg' => '#FFFBEB', 'color' => '#B45309'],
        };
    }
}
