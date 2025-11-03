<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Lead;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $organization = $user->organization;

        // Redirect to onboarding if not completed
        if ($organization && $organization->onboarding_status !== 'completed') {
            return redirect()->route('onboarding.index');
        }

        $stats = [
            'total_campaigns' => Campaign::where('organization_id', $organization->id)->count(),
            'active_campaigns' => Campaign::where('organization_id', $organization->id)
                ->where('status', 'active')->count(),
            'total_leads' => Lead::where('organization_id', $organization->id)->count(),
            'new_leads' => Lead::where('organization_id', $organization->id)
                ->whereHas('status', fn($q) => $q->where('slug', 'new'))
                ->count(),
            'converted_leads' => Lead::where('organization_id', $organization->id)
                ->whereHas('status', fn($q) => $q->where('slug', 'converted'))
                ->count(),
            'total_spent' => Campaign::where('organization_id', $organization->id)
                ->sum('spent'),
        ];

        $recentLeads = Lead::where('organization_id', $organization->id)
            ->with(['campaign', 'status'])
            ->latest()
            ->take(10)
            ->get();

        $campaigns = Campaign::where('organization_id', $organization->id)
            ->withCount('leads')
            ->latest()
            ->take(5)
            ->get();

        // Leads by status
        $leadsByStatus = Lead::where('organization_id', $organization->id)
            ->select('lead_status_id', DB::raw('count(*) as count'))
            ->groupBy('lead_status_id')
            ->with('status')
            ->get();

        return view('dashboard', compact('stats', 'recentLeads', 'campaigns', 'leadsByStatus'));
    }
}