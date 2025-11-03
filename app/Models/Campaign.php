<?php
// app/Models/Campaign.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'meta_campaign_id',
        'meta_adset_id',
        'meta_ad_id',
        'status',
        'budget',
        'objective',
        'start_date',
        'end_date',
        'leads_count',
        'spent',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'spent' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}