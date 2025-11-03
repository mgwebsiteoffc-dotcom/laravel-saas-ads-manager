{{-- resources/views/campaigns/show.blade.php --}}
@extends('layouts.app')

@section('title', $campaign->name)

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $campaign->name }}</h1>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($campaign->status === 'active') bg-green-100 text-green-700
                        @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-700
                        @elseif($campaign->status === 'completed') bg-blue-100 text-blue-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>
                <p class="text-gray-600">Campaign details and performance</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('campaigns.edit', $campaign) }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <a href="{{ route('campaigns.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-1">Total Leads</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_leads'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-1">New Leads</p>
                <p class="text-3xl font-bold text-blue-600">{{ $stats['new_leads'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-1">Converted</p>
                <p class="text-3xl font-bold text-green-600">{{ $stats['converted'] }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-600 mb-1">Conversion Rate</p>
                <p class="text-3xl font-bold text-purple-600">
                    {{ $stats['total_leads'] > 0 ? number_format(($stats['converted'] / $stats['total_leads']) * 100, 1) : 0 }}%
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Campaign Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Objective</p>
                            <p class="font-semibold text-gray-900">{{ $campaign->objective ? str_replace('_', ' ', $campaign->objective) : 'N/A' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Daily Budget</p>
                            <p class="font-semibold text-gray-900">${{ number_format($campaign->budget, 2) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Total Spent</p>
                            <p class="font-semibold text-gray-900">${{ number_format($campaign->spent, 2) }}</p>
                        </div>

                        @if($campaign->budget > 0)
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Budget Usage</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($campaign->spent / $campaign->budget) * 100, 100) }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ number_format(($campaign->spent / $campaign->budget) * 100, 1) }}% used</p>
                        </div>
                        @endif
                        
                        @if($campaign->start_date)
                        <div>
                            <p class="text-sm text-gray-600">Start Date</p>
                            <p class="font-semibold text-gray-900">{{ $campaign->start_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        
                        @if($campaign->end_date)
                        <div>
                            <p class="text-sm text-gray-600">End Date</p>
                            <p class="font-semibold text-gray-900">{{ $campaign->end_date->format('M d, Y') }}</p>
                        </div>
                        @endif
                        
                        <div>
                            <p class="text-sm text-gray-600">Created</p>
                            <p class="font-semibold text-gray-900">{{ $campaign->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Leads -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Leads</h3>
                        <a href="{{ route('leads.index', ['campaign' => $campaign->id]) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            View All →
                        </a>
                    </div>
                    <div class="p-6">
                        @forelse($campaign->leads->take(10) as $lead)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex items-center flex-1">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $lead->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $lead->email ?? $lead->phone ?? 'No contact' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($lead->status)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $lead->status->color }}20; color: {{ $lead->status->color }};">
                                    {{ $lead->status->name }}
                                </span>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ $lead->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('leads.show', $lead) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>No leads captured yet</p>
                            <p class="text-sm mt-1">Leads will appear here once your campaign starts generating them</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection