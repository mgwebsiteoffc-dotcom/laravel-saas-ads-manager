{{-- resources/views/onboarding/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Welcome Onboarding')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl p-8">
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                @for($i = 1; $i <= 3; $i++)
                <div class="flex items-center flex-1">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $i <= $step ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                        {{ $i }}
                    </div>
                    @if($i < 3)
                    <div class="flex-1 h-1 mx-2 {{ $i < $step ? 'bg-blue-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
                @endfor
            </div>
            <div class="flex justify-between text-sm text-gray-600">
                <span>Choose Industry</span>
                <span>Connect Meta</span>
                <span>All Set!</span>
            </div>
        </div>

        <!-- Step 1: Industry Selection -->
        @if($step === 1)
        <div class="text-center">
            <h2 class="text-3xl font-bold mb-2">What's your industry?</h2>
            <p class="text-gray-600 mb-8">We'll customize your experience based on your industry</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="industry-grid">
                @foreach($industries as $industry)
                <button 
                    onclick="selectIndustry({{ $industry->id }})"
                    class="industry-card p-6 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:shadow-lg transition-all group cursor-pointer"
                >
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-3xl" 
                         style="background-color: {{ $industry->color }}20;">
                        {{ $industry->icon }}
                    </div>
                    <div class="font-semibold text-gray-700 group-hover:text-blue-600">
                        {{ $industry->name }}
                    </div>
                </button>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Step 2: Meta Connection -->
        @if($step === 2)
        <div>
            <h2 class="text-3xl font-bold mb-2 text-center">Connect Your Meta Account</h2>
            <p class="text-gray-600 mb-8 text-center">Link your Facebook Ads account to track conversions</p>
            
            <form id="meta-form" class="max-w-md mx-auto space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Meta Access Token <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="meta_access_token"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="EAAxxxxxxxxxxxxx"
                        required
                    >
                    <a href="https://developers.facebook.com/tools/explorer/" target="_blank" class="text-xs text-blue-600 hover:underline">
                        Get your access token →
                    </a>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Ad Account ID
                    </label>
                    <input
                        type="text"
                        name="meta_ad_account_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="act_123456789"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pixel ID
                    </label>
                    <input
                        type="text"
                        name="meta_pixel_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="123456789"
                    >
                </div>

                <div class="flex gap-3 pt-4">
                    <button
                        type="button"
                        onclick="skipMeta()"
                        class="flex-1 px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-semibold"
                    >
                        Skip for Now
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold"
                        id="connect-btn"
                    >
                        Connect Meta
                    </button>
                </div>
            </form>
        </div>
        @endif

        <!-- Step 3: Complete -->
        @if($step === 3)
        <div class="text-center py-8">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold mb-2">You're All Set! 🎉</h2>
            <p class="text-gray-600 mb-8">
                Start creating campaigns and capturing leads
            </p>

            <form method="POST" action="{{ route('onboarding.complete') }}">
                @csrf
                <button
                    type="submit"
                    class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-semibold"
                >
                    Go to Dashboard
                </button>
            </form>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
function selectIndustry(industryId) {
    const btn = event.currentTarget;
    btn.disabled = true;
    btn.innerHTML = '<div class="text-center">Loading...</div>';
    
    fetch('{{ route("onboarding.industry") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ industry_id: industryId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
        btn.disabled = false;
    });
}

@if($step === 2)
document.getElementById('meta-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.getElementById('connect-btn');
    btn.disabled = true;
    btn.textContent = 'Connecting...';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("onboarding.meta") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message || 'Failed to connect. Please check your credentials.');
            btn.disabled = false;
            btn.textContent = 'Connect Meta';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Something went wrong. Please try again.');
        btn.disabled = false;
        btn.textContent = 'Connect Meta';
    });
});

function skipMeta() {
    if (confirm('Are you sure you want to skip Meta connection? You can set it up later.')) {
        fetch('{{ route("onboarding.skip") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
}
@endif
</script>
@endpush
@endsection