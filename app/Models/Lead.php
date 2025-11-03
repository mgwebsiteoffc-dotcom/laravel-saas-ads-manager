<?php
// app/Models/Lead.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'campaign_id',
        'lead_status_id',
        'name',
        'email',
        'phone',
        'message',
        'fbclid',
        'fbp',
        'fbc',
        'ip_address',
        'user_agent',
        'metadata',
        'value',
        'assigned_to',
        'contacted_at',
        'converted_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'value' => 'decimal:2',
        'contacted_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function status()
    {
        return $this->belongsTo(LeadStatus::class, 'lead_status_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function scopeNew($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'new');
        });
    }

    public function scopeConverted($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('slug', 'converted');
        });
    }
}