{{-- resources/views/organization/settings.blade.php --}}
@extends('layouts.app')

@section('title', 'Organization Settings')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Organization Settings</h1>
            <p class="text-gray-600 mt-1">Manage your organization details and integrations</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-8">
            <form method="POST" action="{{ route('organization.update-settings') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Organization Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Organization Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name', $organization->name) }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Industry -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Industry</label>
                    <div class="px-4 py-3 bg-gray-50 rounded-lg">
                        @if($organization->industry)
                            <span class="inline-flex items-center text-lg">
                                {{ $organization->industry->icon }} {{ $organization->industry->name }}
                            </span>
                        @else
                            <span class="text-gray-500">Not set</span>
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Meta Integration</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="meta_access_token" class="block text-sm font-medium text-gray-700 mb-1">
                                Meta Access Token
                            </label>
                            <input 
                                type="text" 
                                name="meta_access_token" 
                                id="meta_access_token" 
                                value="{{ old('meta_access_token', $organization->meta_access_token ? '••••••••••••' : '') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="EAAxxxxxxxxxxxxx"
                            >
                        </div>

                        <div>
                            <label for="meta_ad_account_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Ad Account ID
                            </label>
                            <input 
                                type="text" 
                                name="meta_ad_account_id" 
                                id="meta_ad_account_id" 
                                value="{{ old('meta_ad_account_id', $organization->meta_ad_account_id) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="act_123456789"
                            >
                        </div>

                        <div>
                            <label for="meta_pixel_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Pixel ID
                            </label>
                            <input 
                                type="text" 
                                name="meta_pixel_id" 
                                id="meta_pixel_id" 
                                value="{{ old('meta_pixel_id', $organization->meta_pixel_id) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="123456789"
                            >
                        </div>

                        @if($organization->isMetaConnected())
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        Meta integration is active and working!
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                    >
                        Save Settings
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection