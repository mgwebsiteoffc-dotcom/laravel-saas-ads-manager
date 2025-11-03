{{-- resources/views/campaigns/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Campaigns')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Campaigns</h1>
                <p class="text-gray-600 mt-1">Manage your ad campaigns</p>
            </div>
            <a href="{{ route('campaigns.create') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold flex items-center gap-2">
                <i class="fas fa-plus"></i> Create Campaign
            </a>
        </div>

        @if($campaigns->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-12 bg-white rounded-xl shadow">
            <div class="text-6xl mb-4">📢</div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No campaigns yet</h3>
            <p class="text-gray-500 mb-6">Create your first campaign to start generating leads</p>
            <a href="{{ route('campaigns.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                Create Your First Campaign
            </a>
        </div>
        @else
        <!-- Campaigns Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($campaigns as $campaign)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 flex-1">{{ $campaign->name }}</h3>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($campaign->status === 'active') bg-green-100 text-green-700
                            @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-700
                            @elseif($campaign->status === 'completed') bg-blue-100 text-blue-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                    
                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Budget:</span>
                            <span class="font-semibold">${{ number_format($campaign->budget, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Leads:</span>
                            <span class="font-semibold">{{ $campaign->leads_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Spent:</span>
                            <span class="font-semibold">${{ number_format($campaign->spent, 2) }}</span>
                        </div>
                        @if($campaign->objective)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Objective:</span>
                            <span class="font-semibold text-xs">{{ str_replace('_', ' ', $campaign->objective) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Progress Bar -->
                    @if($campaign->budget > 0)
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>Spent</span>
                            <span>{{ number_format(($campaign->spent / $campaign->budget) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($campaign->spent / $campaign->budget) * 100, 100) }}%"></div>
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-2 pt-4 border-t border-gray-200">
                        <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold">
                            View Details
                        </a>
                        <a href="{{ route('campaigns.edit', $campaign) }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-sm font-semibold">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
        @endif

    </div>
</div>
@endsection