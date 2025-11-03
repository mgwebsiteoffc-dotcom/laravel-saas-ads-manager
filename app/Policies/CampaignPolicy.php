<?php
// app/Policies/CampaignPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Campaign;

class CampaignPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Campaign $campaign): bool
    {
        return $user->isSuperAdmin() || 
               $user->organization_id === $campaign->organization_id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Campaign $campaign): bool
    {
        return $user->isSuperAdmin() || 
               ($user->isAdmin() && $user->organization_id === $campaign->organization_id);
    }

    public function delete(User $user, Campaign $campaign): bool
    {
        return $user->isSuperAdmin() || 
               ($user->isAdmin() && $user->organization_id === $campaign->organization_id);
    }
}