<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityIssueUpvote extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_issue_id',
        'user_id',
        'ip_address',
    ];

    public function issue(): BelongsTo
    {
        return $this->belongsTo(CommunityIssue::class, 'community_issue_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
