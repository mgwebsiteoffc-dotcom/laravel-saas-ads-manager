<?php
// app/Http/Middleware/CheckOrganizationActive.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizationActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            $organization = auth()->user()->organization;
            
            if (!$organization || !$organization->is_active) {
                auth()->logout();
                return redirect()->route('login')
                    ->withErrors(['error' => 'Your organization account is inactive.']);
            }
        }

        return $next($request);
    }
}