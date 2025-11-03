<?php
// app/Http/Controllers/OrganizationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OrganizationController extends Controller
{
    public function settings()
    {
        $organization = auth()->user()->organization;
        return view('organization.settings', compact('organization'));
    }

    public function updateSettings(Request $request)
    {
        $organization = auth()->user()->organization;

        $request->validate([
            'name' => 'required|string|max:255',
            'meta_access_token' => 'nullable|string',
            'meta_ad_account_id' => 'nullable|string',
            'meta_pixel_id' => 'nullable|string',
        ]);

        $organization->update($request->only([
            'name',
            'meta_access_token',
            'meta_ad_account_id',
            'meta_pixel_id',
        ]));

        return redirect()->route('organization.settings')
            ->with('success', 'Settings updated successfully!');
    }

    public function team()
    {
        $organization = auth()->user()->organization;
        $users = $organization->users()->latest()->get();
        
        return view('organization.team', compact('organization', 'users'));
    }

    public function inviteTeamMember(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,member',
        ]);

        $organization = auth()->user()->organization;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'), // Send email with password reset
            'organization_id' => $organization->id,
            'role' => $request->role,
            'is_active' => true,
        ]);

        // TODO: Send invitation email

        return redirect()->route('organization.team')
            ->with('success', 'Team member invited successfully!');
    }
}