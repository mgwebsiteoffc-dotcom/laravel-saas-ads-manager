<?php
// app/Http/Controllers/LeadController.php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Campaign;
use App\Models\LeadStatus;
use App\Services\MetaConversionService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    protected $metaService;

    public function __construct(MetaConversionService $metaService)
    {
        $this->metaService = $metaService;
    }

    public function index(Request $request)
    {
        $query = Lead::where('organization_id', auth()->user()->organization_id)
            ->with(['campaign', 'status', 'assignedUser']);

        // Filters
        if ($request->filled('status')) {
            $query->where('lead_status_id', $request->status);
        }

        if ($request->filled('campaign')) {
            $query->where('campaign_id', $request->campaign);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $leads = $query->latest()->paginate(20);

        $campaigns = Campaign::where('organization_id', auth()->user()->organization_id)
            ->orderBy('name')
            ->get();

        $statuses = LeadStatus::active()->get();

        return view('leads.index', compact('leads', 'campaigns', 'statuses'));
    }

    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);
        $lead->load(['campaign', 'status', 'assignedUser']);
        $statuses = LeadStatus::active()->get();

        return view('leads.show', compact('lead', 'statuses'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'lead_status_id' => 'required|exists:lead_statuses,id',
        ]);

        $oldStatus = $lead->status;
        $lead->update(['lead_status_id' => $request->lead_status_id]);
        $newStatus = $lead->fresh()->status;

        // Track conversion if status changed to converted
        if ($newStatus->slug === 'converted' && $oldStatus->slug !== 'converted') {
            $lead->update(['converted_at' => now()]);
            
            // Send to Meta
            $this->metaService->sendConversion($lead, 'Purchase');
        }

        return back()->with('success', 'Lead status updated successfully!');
    }

    public function assign(Request $request, Lead $lead)
    {
        $this->authorize('update', $lead);

        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $lead->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Lead assigned successfully!');
    }

    // Public endpoint for lead capture (webhook/form)
    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'message' => 'nullable|string',
        ]);

        // Get default "new" status
        $newStatus = LeadStatus::where('slug', 'new')->first();

        $lead = Lead::create([
            'organization_id' => $request->organization_id,
            'campaign_id' => $request->campaign_id,
            'lead_status_id' => $newStatus?->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'fbclid' => $request->fbclid,
            'fbp' => $request->fbp,
            'fbc' => $request->fbc,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => $request->except(['organization_id', 'campaign_id', 'name', 'email', 'phone', 'message']),
        ]);

        // Send lead event to Meta
        $this->metaService->sendConversion($lead, 'Lead');

        return response()->json([
            'success' => true,
            'lead_id' => $lead->id,
        ]);
    }
}