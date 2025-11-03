{{-- resources/views/leads/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Lead Details')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $lead->name }}</h1>
                <p class="text-gray-600 mt-1">Lead Details</p>
            </div>
            <a href="{{ route('leads.index') }}" class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
                <i class="fas fa-arrow-left mr-2"></i> Back to Leads
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Lead Information -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Contact Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Full Name</p>
                            <p class="font-semibold text-gray-900">{{ $lead->name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Email</p>
                            @if($lead->email)
                                <a href="mailto:{{ $lead->email }}" class="font-semibold text-blue-600 hover:text-blue-800">
                                    {{ $lead->email }}
                                </a>
                            @else
                                <p class="text-gray-400">Not provided</p>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Phone</p>
                            @if($lead->phone)
                                <a href="tel:{{ $lead->phone }}" class="font-semibold text-blue-600 hover:text-blue-800">
                                    {{ $lead->phone }}
                                </a>
                            @else
                                <p class="text-gray-400">Not provided</p>
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Source Campaign</p>
                            @if($lead->campaign)
                                <a href="{{ route('campaigns.show', $lead->campaign) }}" class="font-semibold text-blue-600 hover:text-blue-800">
                                    {{ $lead->campaign->name }}
                                </a>
                            @else
                                <p class="text-gray-400">Direct</p>
                            @endif
                        </div>
                    </div>

                    @if($lead->message)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-2">Message</p>
                        <p class="text-gray-900">{{ $lead->message }}</p>
                    </div>
                    @endif
                </div>

                <!-- Tracking Data -->
                @if($lead->fbclid || $lead->fbp || $lead->fbc || $lead->ip_address)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tracking Data</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($lead->ip_address)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">IP Address</p>
                            <p class="font-mono text-sm text-gray-900">{{ $lead->ip_address }}</p>
                        </div>
                        @endif
                        
                        @if($lead->fbclid)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">FB Click ID</p>
                            <p class="font-mono text-xs text-gray-900 break-all">{{ $lead->fbclid }}</p>
                        </div>
                        @endif
                        
                        @if($lead->fbp)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">FB Browser ID</p>
                            <p class="font-mono text-xs text-gray-900 break-all">{{ $lead->fbp }}</p>
                        </div>
                        @endif
                        
                        @if($lead->fbc)
                        <div>
                            <p class="text-sm text-gray-600 mb-1">FB Click Param</p>
                            <p class="font-mono text-xs text-gray-900 break-all">{{ $lead->fbc }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                    
                    <div class="space-y-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">Lead Created</p>
                                <p class="text-sm text-gray-500">{{ $lead->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        
                        @if($lead->contacted_at)
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">Contacted</p>
                                <p class="text-sm text-gray-500">{{ $lead->contacted_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($lead->converted_at)
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check-circle text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-gray-900">Converted</p>
                                <p class="text-sm text-gray-500">{{ $lead->converted_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Sidebar Actions -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Update Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                    
                    <form method="POST" action="{{ route('leads.update-status', $lead) }}">
                        @csrf
                        @method('PUT')
                        
                        <select 
                            name="lead_status_id" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4"
                        >
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ $lead->lead_status_id == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Assign Lead -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Assigned To</h3>
                    
                    @if($lead->assignedUser)
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-semibold">{{ strtoupper(substr($lead->assignedUser->name, 0, 1)) }}</span>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">{{ $lead->assignedUser->name }}</p>
                                <p class="text-sm text-gray-500">{{ $lead->assignedUser->email }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 mb-4">Not assigned yet</p>
                    @endif
                    
                    <form method="POST" action="{{ route('leads.assign', $lead) }}">
                        @csrf
                        @method('PUT')
                        
                        <select 
                            name="assigned_to" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4"
                        >
                            <option value="">Unassigned</option>
                            @foreach(auth()->user()->organization->users as $user)
                                <option value="{{ $user->id }}" {{ $lead->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
                            Assign Lead
                        </button>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-2">
                        @if($lead->email)
                        <a href="mailto:{{ $lead->email }}" class="block w-full px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-center font-medium">
                            <i class="fas fa-envelope mr-2"></i> Send Email
                        </a>
                        @endif
                        
                        @if($lead->phone)
                        <a href="tel:{{ $lead->phone }}" class="block w-full px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 text-center font-medium">
                            <i class="fas fa-phone mr-2"></i> Call
                        </a>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection