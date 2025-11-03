{{-- resources/views/superadmin/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Super Admin Dashboard')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-crown text-yellow-500 text-2xl"></i>
                <h1 class="text-3xl font-bold text-gray-900">Super Admin Dashboard</h1>
            </div>
            <p class="text-gray-600">System-wide overview and management</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium opacity-90">Organizations</p>
                    <i class="fas fa-building text-2xl opacity-75"></i>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_organizations'] }}</p>
                <p class="text-xs opacity-75 mt-1">{{ $stats['active_organizations'] }} active</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium opacity-90">Total Users</p>
                    <i class="fas fa-users text-2xl opacity-75"></i>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
                <p class="text-xs opacity-75 mt-1">All tenants</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium opacity-90">Total Campaigns</p>
                    <i class="fas fa-bullhorn text-2xl opacity-75"></i>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_campaigns'] }}</p>
                <p class="text-xs opacity-75 mt-1">System-wide</p>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium opacity-90">Total Leads</p>
                    <i class="fas fa-user-plus text-2xl opacity-75"></i>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_leads'] }}</p>
                <p class="text-xs opacity-75 mt-1">All organizations</p>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium opacity-90">Avg per Org</p>
                    <i class="fas fa-chart-line text-2xl opacity-75"></i>
                </div>
                <p class="text-3xl font-bold">{{ $stats['total_organizations'] > 0 ? round($stats['total_leads'] / $stats['total_organizations']) : 0 }}</p>
                <p class="text-xs opacity-75 mt-1">Leads/Organization</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('superadmin.organizations') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-building text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Manage</p>
                        <p class="text-lg font-semibold text-gray-900">Organizations</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('superadmin.industries') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-industry text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Master</p>
                        <p class="text-lg font-semibold text-gray-900">Industries</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('superadmin.lead-statuses') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tasks text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Master</p>
                        <p class="text-lg font-semibold text-gray-900">Lead Status</p>
                    </div>
                </div>
            </a>

            <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow opacity-50 cursor-not-allowed">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-gray-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">System</p>
                        <p class="text-lg font-semibold text-gray-900">Settings</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Organizations -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Recent Organizations</h3>
                <a href="{{ route('superadmin.organizations') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    View All →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organization</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentOrganizations as $org)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $org->name }}</div>
                                <div class="text-sm text-gray-500">{{ $org->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($org->industry)
                                    <span class="inline-flex items-center">
                                        <span class="mr-2">{{ $org->industry->icon }}</span>
                                        <span class="text-sm text-gray-900">{{ $org->industry->name }}</span>
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">Not set</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($org->is_active)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $org->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-blue-600 hover:text-blue-900">View</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                No organizations yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- All Organizations Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">All Organizations</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organization</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industry</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campaigns</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Leads</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Onboarding</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($organizations as $org)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $org->name }}</div>
                                <div class="text-xs text-gray-500">{{ $org->slug }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($org->industry)
                                    <span class="inline-flex items-center text-sm">
                                        {{ $org->industry->icon }} {{ $org->industry->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $org->users_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $org->campaigns_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $org->leads_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $org->getOnboardingProgress() }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $org->getOnboardingProgress() }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($org->is_active)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                No organizations found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($organizations->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                {{ $organizations->links() }}
            </div>
            @endif
        </div>

    </div>
</div>
@endsection