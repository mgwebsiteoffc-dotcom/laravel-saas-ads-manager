{{-- resources/views/campaigns/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Campaign')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Campaign</h1>
            <p class="text-gray-600 mt-1">Update your campaign settings</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('campaigns.update', $campaign) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Campaign Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $campaign->name) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="draft" {{ old('status', $campaign->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status', $campaign->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="paused" {{ old('status', $campaign->status) === 'paused' ? 'selected' : '' }}>Paused</option>
                        <option value="completed" {{ old('status', $campaign->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

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
                        <option value="LEAD_GENERATION" {{ old('objective', $campaign->objective) === 'LEAD_GENERATION' ? 'selected' : '' }}>Lead Generation</option>
                        <option value="CONVERSIONS" {{ old('objective', $campaign->objective) === 'CONVERSIONS' ? 'selected' : '' }}>Conversions</option>
                        <option value="TRAFFIC" {{ old('objective', $campaign->objective) === 'TRAFFIC' ? 'selected' : '' }}>Traffic</option>
                        <option value="BRAND_AWARENESS" {{ old('objective', $campaign->objective) === 'BRAND_AWARENESS' ? 'selected' : '' }}>Brand Awareness</option>
                    </select>
                </div>

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
                            value="{{ old('budget', $campaign->budget) }}"
                            class="w-full pl-7 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center font-semibold">
                        Cancel
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                    >
                        Update Campaign
                    </button>
                </div>
            </form>

            <!-- Delete Campaign -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Danger Zone</h3>
                <p class="text-sm text-gray-600 mb-4">Once you delete a campaign, there is no going back.</p>
                <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                        Delete Campaign
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection