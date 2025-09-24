@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">🎁 Campaign Rewards</h1>
                <p class="mt-2 text-gray-600">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-800">{{ $campaign->title }}</a>
                </p>
            </div>
            @auth
                @if($campaign->user_id === auth()->id())
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('rewards.create', $campaign) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                            ➕ Add New Reward
                        </a>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    @if($rewards->count() > 0)
        <!-- Rewards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rewards as $reward)
                <div class="bg-white rounded-lg shadow-md overflow-hidden {{ $reward->isAvailable() ? '' : 'opacity-75' }}">
                    <!-- Reward Header -->
                    <div class="p-6 pb-4">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $reward->title }}</h3>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-blue-600">
                                    ${{ number_format($reward->minimum_amount, 0) }}+
                                </div>
                                <div class="text-sm text-gray-500">minimum</div>
                            </div>
                        </div>

                        <!-- Availability Status -->
                        <div class="mb-4">
                            @if($reward->isAvailable())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ {{ $reward->availability_status }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    ❌ {{ $reward->availability_status }}
                                </span>
                            @endif
                        </div>

                        <!-- Description -->
                        <p class="text-gray-700 mb-4">{{ $reward->description }}</p>

                        <!-- Included Items -->
                        @if($reward->included_items && count($reward->included_items) > 0)
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-800 mb-2">📦 Includes:</h4>
                                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                    @foreach($reward->included_items as $item)
                                        <li>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Delivery & Shipping Info -->
                        <div class="space-y-2 text-sm text-gray-600">
                            @if($reward->estimated_delivery)
                                <div class="flex items-center">
                                    <span class="mr-2">📅</span>
                                    <span><strong>Estimated Delivery:</strong> {{ $reward->estimated_delivery->format('M Y') }}</span>
                                </div>
                            @endif
                            
                            @if($reward->shipping_info)
                                <div class="flex items-center">
                                    <span class="mr-2">🚚</span>
                                    <span><strong>Shipping:</strong> {{ $reward->shipping_info }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reward Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <!-- Backer Count -->
                            <div class="text-sm text-gray-600">
                                <strong>{{ $reward->current_backers }}</strong> backer{{ $reward->current_backers != 1 ? 's' : '' }}
                                @if($reward->maximum_backers)
                                    of <strong>{{ $reward->maximum_backers }}</strong>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                @if($reward->isAvailable())
                                    <a href="{{ route('donations.create', $campaign) }}?reward_id={{ $reward->id }}" 
                                       class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                                        💰 Select Reward
                                    </a>
                                @endif

                                @auth
                                    @if($campaign->user_id === auth()->id())
                                        <a href="{{ route('rewards.edit', [$campaign, $reward]) }}" 
                                           class="bg-gray-300 text-gray-700 px-3 py-2 rounded-md text-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                            ✏️ Edit
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 text-center">
            <a href="{{ route('campaigns.show', $campaign) }}" 
               class="bg-gray-300 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 mr-4">
                ← Back to Campaign
            </a>
            
            <a href="{{ route('donations.create', $campaign) }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                💰 Donate Now
            </a>
        </div>

    @else
        <!-- No Rewards State -->
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">🎁</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Rewards Available</h3>
            <p class="text-gray-500 mb-6">This campaign doesn't have any rewards set up yet.</p>
            
            @auth
                @if($campaign->user_id === auth()->id())
                    <a href="{{ route('rewards.create', $campaign) }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                        ➕ Create First Reward
                    </a>
                @else
                    <a href="{{ route('donations.create', $campaign) }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                        💰 Donate Anyway
                    </a>
                @endif
            @else
                <div>
                    <a href="{{ route('donations.create', $campaign) }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                        💰 Donate to Campaign
                    </a>
                </div>
            @endauth
        </div>
    @endif
</div>
@endsection