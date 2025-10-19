@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-8 text-center mb-8">
            <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h1 class="text-3xl font-bold text-green-800 mb-2">Thank You!</h1>
            <p class="text-lg text-green-700">Your donation has been successfully processed.</p>
        </div>

        <!-- Donation Details -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Donation Details</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount:</span>
                    <span class="font-semibold text-gray-900">৳{{ number_format($donation->amount, 2) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Donor:</span>
                    <span class="font-semibold text-gray-900">{{ $donation->donor_name }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Campaign:</span>
                    <span class="font-semibold text-gray-900">{{ $campaign->title }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Transaction ID:</span>
                    <span class="font-mono text-sm text-gray-600">{{ $donation->transaction_id }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Date:</span>
                    <span class="text-gray-900">{{ $donation->created_at->format('M j, Y \a\t g:i A') }}</span>
                </div>

                @if($donation->message)
                <div class="pt-3 border-t">
                    <span class="text-gray-600">Your Message:</span>
                    <p class="mt-1 text-gray-900 italic">"{{ $donation->message }}"</p>
                </div>
                @endif

                @if($donation->reward)
                <div class="pt-3 border-t">
                    <span class="text-gray-600">Selected Reward:</span>
                    <div class="mt-2 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900">{{ $donation->reward->title }}</h4>
                        <p class="text-sm text-blue-700 mt-1">{{ $donation->reward->description }}</p>
                        
                        @if($donation->reward->items_included)
                        <div class="mt-2">
                            <p class="text-xs text-blue-600 font-medium">Includes:</p>
                            <ul class="text-xs text-blue-600 ml-2 mt-1">
                                @foreach(explode("\n", $donation->reward->items_included) as $item)
                                <li>• {{ trim($item) }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        @if($donation->reward->estimated_delivery)
                        <div class="mt-2">
                            <p class="text-xs text-blue-600">
                                <span class="font-medium">Estimated delivery:</span> 
                                {{ \Carbon\Carbon::parse($donation->reward->estimated_delivery)->format('M Y') }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Updated Campaign Progress -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Campaign Progress</h2>
            
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <span>৳{{ number_format($campaign->current_amount) }} raised</span>
                    <span>৳{{ number_format($campaign->goal_amount) }} goal</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-green-500 h-4 rounded-full transition-all duration-500" style="width: {{ $campaign->progress_percentage }}%"></div>
                </div>
                <div class="flex justify-between text-sm text-gray-500 mt-1">
                    <span>{{ $campaign->progress_percentage }}% funded</span>
                    <span>{{ $campaign->backers_count }} backers</span>
                </div>
            </div>

            @if($campaign->progress_percentage >= 100)
                <div class="bg-green-100 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Goal Reached! 🎉</h3>
                            <p class="mt-1 text-sm text-green-700">This campaign has successfully reached its funding goal!</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Impact Message -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">Your Impact</h3>
            <p class="text-blue-700">
                Your generous donation of ৳{{ number_format($donation->amount, 2) }} brings this campaign 
                ৳{{ number_format($campaign->goal_amount - $campaign->current_amount + $donation->amount, 2) }} closer to its goal.
                @if($campaign->progress_percentage >= 100)
                    Thanks to supporters like you, this campaign has reached its funding goal!
                @else
                    Every contribution makes a difference in helping this project become a reality.
                @endif
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('campaigns.show', $campaign) }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-md text-center hover:bg-blue-700 transition duration-200">
                Back to Campaign
            </a>
            
            <a href="{{ route('campaigns.index') }}" 
               class="bg-indigo-600 text-white px-6 py-3 rounded-md text-center hover:bg-indigo-700 transition duration-200">
                Browse More Campaigns
            </a>

            @auth
                <a href="{{ route('dashboard') }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-md text-center hover:bg-green-700 transition duration-200">
                    My Dashboard
                </a>
            @endauth
        </div>

        <!-- Social Sharing -->
        <div class="mt-8 text-center">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Help Spread the Word</h3>
            <p class="text-gray-600 mb-4">Share this campaign with your friends and family to help it reach its goal.</p>
            
            <div class="flex justify-center space-x-4">
                <a href="https://twitter.com/intent/tweet?text=I%20just%20supported%20{{ urlencode($campaign->title) }}%20on%20our%20crowdfunding%20platform!&url={{ urlencode(route('campaigns.show', $campaign)) }}" 
                   target="_blank" 
                   class="bg-blue-400 text-white px-4 py-2 rounded-md hover:bg-blue-500 transition duration-200">
                    Share on Twitter
                </a>
                
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('campaigns.show', $campaign)) }}" 
                   target="_blank" 
                   class="bg-blue-700 text-white px-4 py-2 rounded-md hover:bg-blue-800 transition duration-200">
                    Share on Facebook
                </a>
                
                <button onclick="copyToClipboard('{{ route('campaigns.show', $campaign) }}')" 
                        class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition duration-200">
                    Copy Link
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Campaign link copied to clipboard!');
    });
}
</script>
@endsection