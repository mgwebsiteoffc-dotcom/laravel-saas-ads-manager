<?php
// app/Models/Organization.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'industry_id',
        'onboarding_status',
        'onboarding_completed_at',
        'meta_access_token',
        'meta_ad_account_id',
        'meta_pixel_id',
        'meta_business_id',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'onboarding_completed_at' => 'datetime',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class);
    }

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function isMetaConnected(): bool
    {
        return !empty($this->meta_access_token) && !empty($this->meta_pixel_id);
    }

    public function getOnboardingProgress(): int
    {
        return match($this->onboarding_status) {
            'pending' => 0,
            'industry_selected' => 33,
            'meta_connected' => 66,
            'campaign_created', 'completed' => 100,
            default => 0,
        };
    }
}