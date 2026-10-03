<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'step_number',
        'icon',
        'title',
        'description',
        'badge_color',
        'is_active',
    ];

    protected $casts = [
        'step_number' => 'integer',
        'is_active' => 'boolean',
    ];
}
