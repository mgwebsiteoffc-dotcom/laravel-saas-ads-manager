<?php
// app/Http/Controllers/CampaignController.php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('organization_id', auth()->user()->organization_id)
            ->withCount('leads')
            ->latest()
            ->paginate(15);

        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('campaigns.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'objective' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $campaign = Campaign::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $request->name,
            'budget' => $request->budget,
            'objective' => $request->objective,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        // Update onboarding status if first campaign
        $organization = auth()->user()->organization;
        if ($organization->onboarding_status === 'meta_connected') {
            $organization->update(['onboarding_status' => 'campaign_created']);
        }

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign created successfully!');
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);

        $campaign->load(['leads' => function($query) {
            $query->with('status')->latest()->take(20);
        }]);

        $stats = [
            'total_leads' => $campaign->leads()->count(),
            'new_leads' => $campaign->leads()->whereHas('status', fn($q) => $q->where('slug', 'new'))->count(),
            'converted' => $campaign->leads()->whereHas('status', fn($q) => $q->where('slug', 'converted'))->count(),
        ];

        return view('campaigns.show', compact('campaign', 'stats'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $this->authorize('update', $campaign);

        $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,paused,completed,draft',
            'objective' => 'nullable|string',
        ]);

        $campaign->update($request->all());

        return redirect()->route('campaigns.show', $campaign)
            ->with('success', 'Campaign updated successfully!');
    }

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaign deleted successfully!');
    }
}