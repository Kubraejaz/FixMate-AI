<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_badge',
        'hero_title_main',
        'hero_title_highlight',
        'hero_subtitle',
        'hero_image',
        'hero_script_text',
        'hero_trusted_tag',
        'guarantee_title',
        'guarantee_subtitle',
        'warranty_days',
    ];

    protected $casts = [
        'warranty_days' => 'integer',
    ];

    /**
     * Get or create the singleton homepage settings record.
     */
    public static function instance(): self
    {
        return static::first() ?? static::create([
            'hero_badge' => 'AI Powered Home Service Platform',
            'hero_title_main' => 'Smart Home Services',
            'hero_title_highlight' => 'Simple',
            'hero_subtitle' => 'Describe your problem or upload defect photos. Let FixMate AI find verified technicians with transparent upfront pricing.',
            'hero_image' => 'assets/images/image_8.png',
            'hero_script_text' => "Your Home\nOur Priority",
            'hero_trusted_tag' => 'Trusted Professionals for Your Home',
            'guarantee_title' => 'FixMate AI Guarantee',
            'guarantee_subtitle' => 'Trusted service. Verified professionals. 30-day warranty on all completed jobs.',
            'warranty_days' => 30,
        ]);
    }
}
