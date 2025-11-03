<?php
// app/Services/MetaConversionService.php

namespace App\Services;

use App\Models\Lead;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaConversionService
{
    public function sendConversion(Lead $lead, string $eventName = 'Lead')
    {
        $organization = $lead->organization;

        if (!$organization->isMetaConnected()) {
            return false;
        }

        try {
            $eventData = [
                'data' => [[
                    'event_name' => $eventName,
                    'event_time' => now()->timestamp,
                    'action_source' => 'website',
                    'user_data' => $this->getUserData($lead),
                    'custom_data' => [
                        'lead_id' => $lead->id,
                        'value' => $lead->value ?? 0,
                        'currency' => 'USD',
                    ],
                ]],
            ];

            $response = Http::post(
                "https://graph.facebook.com/v18.0/{$organization->meta_pixel_id}/events",
                $eventData
            )->withHeaders([
                'Authorization' => "Bearer {$organization->meta_access_token}",
            ]);

            if ($response->successful()) {
                Log::info("Meta conversion sent for lead {$lead->id}");
                return true;
            }

            Log::error("Meta conversion failed for lead {$lead->id}: " . $response->body());
            return false;

        } catch (\Exception $e) {
            Log::error("Meta conversion error: " . $e->getMessage());
            return false;
        }
    }

    private function getUserData(Lead $lead)
    {
        $userData = [];

        if ($lead->email) {
            $userData['em'] = [hash('sha256', strtolower($lead->email))];
        }

        if ($lead->phone) {
            $userData['ph'] = [hash('sha256', preg_replace('/[^0-9]/', '', $lead->phone))];
        }

        if ($lead->ip_address) {
            $userData['client_ip_address'] = $lead->ip_address;
        }

        if ($lead->user_agent) {
            $userData['client_user_agent'] = $lead->user_agent;
        }

        if ($lead->fbc) {
            $userData['fbc'] = $lead->fbc;
        }

        if ($lead->fbp) {
            $userData['fbp'] = $lead->fbp;
        }

        return $userData;
    }
}