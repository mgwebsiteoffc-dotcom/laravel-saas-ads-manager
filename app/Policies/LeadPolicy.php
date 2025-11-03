<?php
// app/Policies/LeadPolicy.php

namespace App\Policies;

use App\Models\User;
use App\Models\Lead;

class LeadPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Lead $lead): bool
    {
        return $user->isSuperAdmin() || 
               $user->organization_id === $lead->organization_id;
    }

    public function create(User $user): bool
    {
        return true; // Anyone can create leads (for API)
    }

    public function update(User $user, Lead $lead): bool
    {
        return $user->isSuperAdmin() || 
               $user->organization_id === $lead->organization_id;
    }

    public function delete(User $user, Lead $lead): bool
    {
        return $user->isSuperAdmin() || 
               ($user->isAdmin() && $user->organization_id === $lead->organization_id);
    }
}