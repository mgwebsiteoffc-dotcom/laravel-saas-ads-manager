<?php
// app/Providers/AuthServiceProvider.php

namespace App\Providers;

use App\Models\Campaign;
use App\Models\Lead;
use App\Policies\CampaignPolicy;
use App\Policies\LeadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Campaign::class => CampaignPolicy::class,
        Lead::class => LeadPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}