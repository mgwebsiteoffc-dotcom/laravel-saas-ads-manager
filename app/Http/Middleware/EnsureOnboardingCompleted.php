<?php
// app/Http/Middleware/EnsureOnboardingCompleted.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOnboardingCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            $organization = auth()->user()->organization;
            
            if ($organization && $organization->onboarding_status !== 'completed') {
                // Allow access to onboarding routes
                if (!$request->routeIs('onboarding.*') && !$request->routeIs('logout')) {
                    return redirect()->route('onboarding.index');
                }
            }
        }

        return $next($request);
    }
}