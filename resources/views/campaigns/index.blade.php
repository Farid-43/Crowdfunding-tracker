@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">All Campaigns</h1>
            <p class="text-gray-600 mt-2">Discover and support amazing projects</p>
        </div>
        @auth
            <a href="{{ route('campaigns.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Create Campaign
            </a>
        @endauth
    </div>

    <!-- Display success message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
            <div class="flex">
                <div class="text-green-400">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Campaign Grid -->
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($campaigns as $campaign)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 flex flex-col h-full">
                    <!-- Campaign Image - Fixed Height -->
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                        @if($campaign->image_path)
                            <img src="{{ $campaign->image_path }}" 
                                 alt="{{ $campaign->title }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="text-white text-lg font-semibold hidden items-center justify-center w-full h-full">{{ $campaign->category }}</span>
                        @else
                            <span class="text-white text-lg font-semibold">{{ $campaign->category }}</span>
                        @endif
                    </div>
                    
                    <!-- Campaign Content -->
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Featured Badge -->
                        @if($campaign->featured)
                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mb-3 self-start">
                                ⭐ Featured
                            </span>
                        @endif
                        
                        <!-- Title - Natural height with more space -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                            {{ $campaign->title }}
                        </h3>
                        
                        <!-- Short Description - Natural height -->
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">
                            {{ $campaign->short_description }}
                        </p>
                        
                        <!-- Bottom section always at bottom -->
                        <div class="mt-auto">
                            <!-- Creator -->
                            <p class="text-xs text-gray-500 mb-4">
                                by <span class="font-medium">{{ $campaign->user->name }}</span>
                            </p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>${{ number_format($campaign->current_amount) }} raised</span>
                                    <span>{{ $campaign->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" 
                                         style="width: {{ min(100, $campaign->progress_percentage) }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Campaign Stats -->
                            <div class="flex justify-between text-sm text-gray-600 mb-4">
                                <span>${{ number_format($campaign->goal_amount) }} goal</span>
                                <span>{{ $campaign->days_remaining }} days left</span>
                            </div>
                            
                            <!-- View Button -->
                            <a href="{{ route('campaigns.show', $campaign) }}" 
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded transition duration-200">
                                View Campaign
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns yet</h3>
                <p class="text-gray-600 mb-4">Be the first to create a campaign and start fundraising!</p>
                @auth
                    <a href="{{ route('campaigns.create') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                        Create First Campaign
                    </a>
                @else
                    <p class="text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in</a> to create a campaign
                    </p>
                @endauth
            </div>
        </div>
    @endif
</div>
@endsection