<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_no',
        'department',
        'name',
        'phone',
        'email',
        'city',
        'message',
        'status',
        'admin_notes',
    ];

    /**
     * Get a human-readable department label.
     */
    public function getDepartmentLabelAttribute(): string
    {
        return match ($this->department) {
            'booking' => 'Booking & Status Tracking',
            'emergency' => 'Emergency Breakdown Squad',
            'escrow' => 'Escrow & Payment Dispute',
            'technician' => 'Technician Onboarding / KYC',
            'corporate' => 'Corporate / Housing AMC',
            default => 'General Feedback / Inquiry',
        };
    }

    /**
     * Get badge styling class for inquiry status.
     */
    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'new' => ['label' => 'New / Unread', 'class' => 'yellow', 'bg' => '#FEF3C7', 'color' => '#92400E'],
            'in_progress' => ['label' => 'In Progress', 'class' => 'blue', 'bg' => '#E0F2FE', 'color' => '#0369A1'],
            'resolved' => ['label' => 'Resolved', 'class' => 'green', 'bg' => '#DCFCE7', 'color' => '#15803D'],
            'closed' => ['label' => 'Closed', 'class' => 'gray', 'bg' => '#F1F5F9', 'color' => '#475569'],
            default => ['label' => ucfirst($this->status), 'class' => 'gray', 'bg' => '#F1F5F9', 'color' => '#475569'],
        };
    }
}
