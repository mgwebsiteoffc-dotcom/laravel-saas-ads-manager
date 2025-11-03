{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Campaigns -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                        <i class="fas fa-bullhorn text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Campaigns</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_campaigns'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">{{ $stats['active_campaigns'] }} active</span>
                </div>
            </div>

            <!-- Total Leads -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Leads</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_leads'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-green-600">{{ $stats['new_leads'] }} new</span>
                </div>
            </div>

            <!-- Converted -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Converted</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['converted_leads'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    @if($stats['total_leads'] > 0)
                        <span class="text-sm text-gray-500">{{ number_format(($stats['converted_leads'] / $stats['total_leads']) * 100, 1) }}% conversion</span>
                    @else
                        <span class="text-sm text-gray-500">0% conversion</span>
                    @endif
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-500 rounded-lg p-3">
                        <i class="fas fa-dollar-sign text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Spent</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_spent'], 2) }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-sm text-gray-500">This month</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Recent Leads -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Leads</h3>
                    <a href="{{ route('leads.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                        View All →
                    </a>
                </div>
                <div class="p-6">
                    @forelse($recentLeads as $lead)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">{{ $lead->name }}</p>
                                <p class="text-sm text-gray-500">{{ $lead->email ?? $lead->phone }}</p>
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
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>No leads yet</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Leads by Status -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Leads by Status</h3>
                </div>
                <div class="p-6">
                    @forelse($leadsByStatus as $item)
                    <div class="mb-4 last:mb-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-medium text-gray-700">{{ $item->status->name ?? 'Unknown' }}</span>
                            <span class="font-bold text-gray-900">{{ $item->count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full" 
                                 style="width: {{ $stats['total_leads'] > 0 ? ($item->count / $stats['total_leads']) * 100 : 0 }}%; background-color: {{ $item->status->color ?? '#3B82F6' }};"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <p>No data available</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Recent Campaigns -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Active Campaigns</h3>
                <a href="{{ route('campaigns.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i> New Campaign
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaign</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Budget</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Leads</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($campaigns as $campaign)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $campaign->name }}</div>
                                <div class="text-sm text-gray-500">{{ $campaign->objective }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                ${{ number_format($campaign->budget, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    {{ $campaign->leads_count }} leads
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    @if($campaign->status === 'active') bg-green-100 text-green-800
                                    @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                    View →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-bullhorn text-4xl mb-2"></i>
                                <p>No campaigns yet. Create your first campaign to get started!</p>
                                <a href="{{ route('campaigns.create') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Create Campaign
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection