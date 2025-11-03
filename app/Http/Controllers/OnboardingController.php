<?php
// app/Http/Controllers/OnboardingController.php

namespace App\Http\Controllers;

use App\Models\Industry;
use App\Models\LeadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OnboardingController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;

        // Redirect if already completed
        if ($organization->onboarding_status === 'completed') {
            return redirect()->route('dashboard');
        }

        $industries = Industry::active()->get();
        $step = $this->getCurrentStep($organization->onboarding_status);

        return view('onboarding.index', compact('organization', 'industries', 'step'));
    }

    public function selectIndustry(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
        ]);

        $organization = auth()->user()->organization;
        $organization->update([
            'industry_id' => $request->industry_id,
            'onboarding_status' => 'industry_selected',
        ]);

        return response()->json([
            'success' => true,
            'next_step' => 2,
        ]);
    }

    public function connectMeta(Request $request)
    {
        $request->validate([
            'meta_access_token' => 'required|string',
            'meta_ad_account_id' => 'nullable|string',
            'meta_pixel_id' => 'nullable|string',
        ]);

        // Verify Meta token
        try {
            $response = Http::get('https://graph.facebook.com/v18.0/me', [
                'access_token' => $request->meta_access_token,
            ]);

            if (!$response->successful()) {
                return back()->withErrors(['meta_access_token' => 'Invalid Meta access token']);
            }

            $organization = auth()->user()->organization;
            $organization->update([
                'meta_access_token' => $request->meta_access_token,
                'meta_ad_account_id' => $request->meta_ad_account_id,
                'meta_pixel_id' => $request->meta_pixel_id,
                'onboarding_status' => 'meta_connected',
            ]);

            return response()->json([
                'success' => true,
                'next_step' => 3,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify Meta credentials',
            ], 422);
        }
    }

    public function skip(Request $request)
    {
        $organization = auth()->user()->organization;
        
        if ($organization->onboarding_status === 'industry_selected') {
            $organization->update(['onboarding_status' => 'meta_connected']);
        }

        return response()->json(['success' => true, 'next_step' => 3]);
    }

    public function complete()
    {
        $organization = auth()->user()->organization;
        $organization->update([
            'onboarding_status' => 'completed',
            'onboarding_completed_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Onboarding completed! Welcome aboard 🎉');
    }

    private function getCurrentStep($status)
    {
        return match($status) {
            'pending' => 1,
            'industry_selected' => 2,
            'meta_connected', 'campaign_created', 'completed' => 3,
            default => 1,
        };
    }
}