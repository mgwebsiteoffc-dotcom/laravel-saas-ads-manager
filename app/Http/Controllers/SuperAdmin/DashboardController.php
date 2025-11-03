<?php
// app/Http/Controllers/SuperAdmin/DashboardController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use App\Models\Lead;
use App\Models\Campaign;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $stats = [
            'total_organizations' => Organization::count(),
            'active_organizations' => Organization::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_leads' => Lead::count(),
            'total_campaigns' => Campaign::count(),
        ];

        $organizations = Organization::with('industry')
            ->withCount(['users', 'campaigns', 'leads'])
            ->latest()
            ->paginate(20);

        $recentOrganizations = Organization::with('industry')
            ->latest()
            ->take(5)
            ->get();

        return view('superadmin.dashboard', compact('stats', 'organizations', 'recentOrganizations'));
    }

    public function organizations()
    {
        $organizations = Organization::with('industry')
            ->withCount(['users', 'campaigns', 'leads'])
            ->latest()
            ->paginate(20);

        return view('superadmin.organizations', compact('organizations'));
    }
}