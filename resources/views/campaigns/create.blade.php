{{-- resources/views/campaigns/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Create Campaign')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create New Campaign</h1>
            <p class="text-gray-600 mt-1">Set up your advertising campaign</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('campaigns.store') }}" class="space-y-6">
                @csrf

                <!-- Campaign Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Campaign Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                        placeholder="e.g., Summer Sale 2024"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Objective -->
                <div>
                    <label for="objective" class="block text-sm font-medium text-gray-700 mb-1">
                        Campaign Objective
                    </label>
                    <select 
                        name="objective" 
                        id="objective"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="">Select Objective</option>
                        <option value="LEAD_GENERATION" {{ old('objective') === 'LEAD_GENERATION' ? 'selected' : '' }}>Lead Generation</option>
                        <option value="CONVERSIONS" {{ old('objective') === 'CONVERSIONS' ? 'selected' : '' }}>Conversions</option>
                        <option value="TRAFFIC" {{ old('objective') === 'TRAFFIC' ? 'selected' : '' }}>Traffic</option>
                        <option value="BRAND_AWARENESS" {{ old('objective') === 'BRAND_AWARENESS' ? 'selected' : '' }}>Brand Awareness</option>
                        <option value="ENGAGEMENT" {{ old('objective') === 'ENGAGEMENT' ? 'selected' : '' }}>Engagement</option>
                        <option value="APP_INSTALLS" {{ old('objective') === 'APP_INSTALLS' ? 'selected' : '' }}>App Installs</option>
                    </select>
                    @error('objective')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">
                        Daily Budget (USD)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input 
                            type="number" 
                            name="budget" 
                            id="budget" 
                            step="0.01"
                            min="0"
                            value="{{ old('budget') }}"
                            class="w-full pl-7 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('budget') border-red-500 @enderror"
                            placeholder="100.00"
                        >
                    </div>
                    @error('budget')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date
                        </label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ old('start_date', date('Y-m-d')) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            End Date
                        </label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ old('end_date') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Your campaign will be created in draft mode. You can activate it after setup.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4 pt-4">
                    <a href="{{ route('campaigns.index') }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center font-semibold">
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                    >
                        Create Campaign
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection