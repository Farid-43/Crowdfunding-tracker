@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Campaign Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/4">
                    @if($campaign->image_path)
                        <img src="{{ $campaign->image_path }}" alt="{{ $campaign->title }}" class="w-full h-32 object-cover rounded-lg">
                    @else
                        <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="md:w-3/4">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $campaign->title }}</h1>
                    <p class="text-gray-600 mb-4">by {{ $campaign->user->name }}</p>
                    
                    <!-- Progress Info -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-blue-600">${{ number_format($campaign->current_amount) }}</div>
                            <div class="text-sm text-gray-600">Raised</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-green-600">{{ $campaign->progress_percentage }}%</div>
                            <div class="text-sm text-gray-600">Funded</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-purple-600">{{ $totalDonations }}</div>
                            <div class="text-sm text-gray-600">Donations</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-orange-600">{{ $campaign->days_remaining }}</div>
                            <div class="text-sm text-gray-600">Days Left</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('campaigns.show', $campaign) }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
                ← Back to Campaign
            </a>
            
            @if(!$campaign->is_expired && $campaign->status === 'active')
                <a href="{{ route('donations.create', $campaign) }}" 
                   class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 text-center">
                    💚 Support This Campaign
                </a>
            @endif
        </div>

        <!-- Donation History -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Donation History</h2>
                <p class="text-gray-600 mt-1">Recent donations from our amazing supporters</p>
            </div>

            @if($donations->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($donations as $donation)
                        <div class="p-6 hover:bg-gray-50 transition duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="mb-3">
                                        <h3 class="font-semibold text-gray-900">{{ $donation->donor_name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                    </div>

                                    @if($donation->message)
                                        <div class="bg-gray-50 rounded-lg p-3 mb-3">
                                            <p class="text-gray-700 italic text-sm">"{{ $donation->message }}"</p>
                                        </div>
                                    @endif

                                    <div class="flex items-center text-sm text-gray-600">
                                        <span>{{ $donation->created_at->format('M j, Y \a\t g:i A') }}</span>
                                        @if($donation->anonymous)
                                            <span class="mx-2">•</span>
                                            <span class="text-gray-500">Anonymous donation</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right">
                                    <div class="text-2xl font-bold text-green-600 mb-1">
                                        ${{ number_format($donation->amount, 2) }}
                                    </div>
                                    
                                    <span class="inline-block bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst($donation->status) }}
                                    </span>
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
                    <p class="text-gray-600 mb-6">Be the first to support this amazing campaign!</p>
                    
                    @if(!$campaign->is_expired && $campaign->status === 'active')
                        <a href="{{ route('donations.create', $campaign) }}" 
                           class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">
                            Make the First Donation
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Donation Statistics -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">${{ number_format($totalAmount, 2) }}</div>
                <div class="text-gray-600">Total Raised</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $totalDonations }}</div>
                <div class="text-gray-600">Total Donations</div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">
                    ${{ $totalDonations > 0 ? number_format($totalAmount / $totalDonations, 2) : '0.00' }}
                </div>
                <div class="text-gray-600">Average Donation</div>
            </div>
        </div>
    </div>
</div>
@endsection