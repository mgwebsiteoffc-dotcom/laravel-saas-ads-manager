<?php
// app/Http/Controllers/SuperAdmin/MasterController.php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    // Industries
    public function industries()
    {
        $industries = Industry::orderBy('order')->paginate(20);
        return view('superadmin.masters.industries', compact('industries'));
    }

    public function storeIndustry(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:20',
        ]);

        Industry::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
            'color' => $request->color ?? '#3B82F6',
            'order' => Industry::max('order') + 1,
        ]);

        return back()->with('success', 'Industry created successfully!');
    }

    public function updateIndustry(Request $request, Industry $industry)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $industry->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon,
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Industry updated successfully!');
    }

    public function destroyIndustry(Industry $industry)
    {
        $industry->delete();
        return back()->with('success', 'Industry deleted successfully!');
    }

    // Lead Statuses
    public function leadStatuses()
    {
        $statuses = LeadStatus::orderBy('order')->paginate(20);
        return view('superadmin.masters.lead-statuses', compact('statuses'));
    }

    public function storeLeadStatus(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
        ]);

        LeadStatus::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color ?? '#3B82F6',
            'order' => LeadStatus::max('order') + 1,
        ]);

        return back()->with('success', 'Lead status created successfully!');
    }

    public function updateLeadStatus(Request $request, LeadStatus $status)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $status->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'color' => $request->color,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Lead status updated successfully!');
    }

    public function destroyLeadStatus(LeadStatus $status)
    {
        $status->delete();
        return back()->with('success', 'Lead status deleted successfully!');
    }
}