@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Donation History</h1>
            <p class="text-gray-600 mt-2">Track all your contributions and see the impact you've made</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">${{ number_format($totalDonated, 2) }}</div>
                <div class="text-gray-600">Total Donated</div>
                <div class="text-sm text-gray-500 mt-1">Across all campaigns</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $campaignsSupported }}</div>
                <div class="text-gray-600">Campaigns Supported</div>
                <div class="text-sm text-gray-500 mt-1">Different projects</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $donations->total() }}</div>
                <div class="text-gray-600">Total Donations</div>
                <div class="text-sm text-gray-500 mt-1">Individual contributions</div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('dashboard') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
                ← Back to Dashboard
            </a>
            
            <a href="{{ route('campaigns.index') }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 text-center">
                Browse More Campaigns
            </a>
        </div>

        <!-- Donation History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Your Donations</h2>
                <p class="text-gray-600 mt-1">Chronological list of your contributions</p>
            </div>

            @if($donations->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($donations as $donation)
                        <div class="p-6 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="mb-3">
                                        <h3 class="font-semibold text-gray-900 hover:text-blue-600">
                                            <a href="{{ route('campaigns.show', $donation->campaign) }}">
                                                {{ $donation->campaign->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $donation->created_at->format('M j, Y \a\t g:i A') }} • 
                                            {{ $donation->created_at->diffForHumans() }}
                                        </p>
                                    </div>

                                    @if($donation->message)
                                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                            <p class="text-gray-700 italic text-sm">"{{ $donation->message }}"</p>
                                        </div>
                                    @endif

                                    <!-- Campaign Progress at time of donation -->
                                    <div class="">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span>Campaign Progress: {{ $donation->campaign->progress_percentage }}%</span>
                                            <span class="mx-2">•</span>
                                            <span>${{ number_format($donation->campaign->current_amount) }} / ${{ number_format($donation->campaign->goal_amount) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right ml-4">
                                    <div class="text-2xl font-bold text-green-600 mb-1">
                                        ${{ number_format($donation->amount, 2) }}
                                    </div>
                                    
                                    <div class="flex flex-col gap-1">
                                        @if($donation->anonymous)
                                            <span class="inline-block bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                                Anonymous
                                            </span>
                                        @endif
                                        
                                        <span class="inline-block bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="mt-3 flex flex-col gap-1">
                                        <a href="{{ route('campaigns.show', $donation->campaign) }}" 
                                           class="text-xs text-blue-600 hover:text-blue-800">
                                            View Campaign
                                        </a>
                                        <a href="{{ route('donations.campaign-history', $donation->campaign) }}" 
                                           class="text-xs text-gray-600 hover:text-gray-800">
                                            See All Donations
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $donations->links() }}
                </div>
            @else
                <!-- No Donations Yet -->
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No donations yet</h3>
                    <p class="text-gray-600 mb-6">Start supporting amazing campaigns and make a difference!</p>
                    
                    <a href="{{ route('campaigns.index') }}" 
                       class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                        Browse Campaigns
                    </a>
                </div>
            @endif
        </div>

        <!-- Impact Summary -->
        @if($donations->count() > 0)
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Your Impact</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-700">
                        <strong>Total Contribution:</strong> ${{ number_format($totalDonated, 2) }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Average Donation:</strong> ${{ number_format($donations->total() > 0 ? $totalDonated / $donations->total() : 0, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-700">
                        <strong>Campaigns Supported:</strong> {{ $campaignsSupported }}
                    </p>
                    <p class="text-gray-700">
                        <strong>Member Since:</strong> {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <p class="text-gray-600 italic">Thank you for being an amazing supporter of innovative projects!</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection