@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Campaign Header -->
        <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center relative overflow-hidden">
            @if($campaign->image_path)
                <img src="{{ $campaign->image_path }}" 
                     alt="{{ $campaign->title }}" 
                     class="w-full h-full object-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <span class="text-white text-2xl font-bold hidden items-center justify-center w-full h-full absolute inset-0">{{ $campaign->category }}</span>
            @else
                <span class="text-white text-2xl font-bold">{{ $campaign->category }}</span>
            @endif
            
            <!-- Featured Badge -->
            @if($campaign->featured)
                <div class="absolute top-4 right-4">
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full">
                        ⭐ Featured
                    </span>
                </div>
            @endif
        </div>

        <!-- Campaign Content -->
        <div class="p-8">
            <!-- Display success message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
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

            <!-- Title and Creator -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $campaign->title }}</h1>
                <p class="text-gray-600">
                    by <span class="font-semibold text-blue-600">{{ $campaign->user->name }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-sm">{{ $campaign->category }}</span>
                </p>
            </div>

            <!-- Progress Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Amount Raised -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">${{ number_format($campaign->current_amount) }}</div>
                        <div class="text-sm text-gray-600">raised of ${{ number_format($campaign->goal_amount) }} goal</div>
                    </div>
                    
                    <!-- Progress Percentage -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $campaign->progress_percentage }}%</div>
                        <div class="text-sm text-gray-600">funded</div>
                    </div>
                    
                    <!-- Days Remaining -->
                    <div class="text-center">
                        <div class="text-3xl font-bold {{ $campaign->days_remaining > 7 ? 'text-gray-700' : 'text-red-600' }}">
                            {{ $campaign->days_remaining }}
                        </div>
                        <div class="text-sm text-gray-600">days to go</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, $campaign->progress_percentage) }}%"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-4">
                    @if(!$campaign->is_expired && $campaign->status === 'active')
                        <!-- Donate Button for Active Campaigns -->
                        <a href="{{ route('donations.create', $campaign) }}" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                            💚 Donate Now
                        </a>
                    @else
                        <!-- Campaign Ended -->
                        <div class="flex-1 bg-gray-400 text-white font-bold py-3 px-6 rounded-lg text-center cursor-not-allowed">
                            Campaign Ended
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                Edit Campaign (Admin)
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Donation History Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('donations.campaign-history', $campaign) }}" 
                       class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        View Donation History ({{ $campaign->donations_count ?? $campaign->donations->count() }} supporters)
                    </a>
                </div>

                <!-- Guest User Encouragement -->
                @guest
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Have an account? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Sign in</a> 
                        to track your donations
                    </p>
                </div>
                @endguest
            </div>

            <!-- Campaign Description -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Project</h2>
                
                <!-- Short Description -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-blue-800 font-medium">{{ $campaign->short_description }}</p>
                </div>
                
                <!-- Full Description -->
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $campaign->description }}</p>
                </div>
            </div>

            <!-- Campaign Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Campaign Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium capitalize 
                                {{ $campaign->status === 'active' ? 'text-green-600' : 
                                   ($campaign->status === 'completed' ? 'text-blue-600' : 'text-red-600') }}">
                                {{ $campaign->status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $campaign->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Deadline:</span>
                            <span class="font-medium">{{ $campaign->deadline->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Backers:</span>
                            <span class="font-medium">{{ number_format($campaign->backers_count) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Creator Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Creator</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($campaign->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold text-gray-900">{{ $campaign->user->name }}</div>
                                <div class="text-sm text-gray-600">Campaign Creator</div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">
                            {{ $campaign->user->campaigns->count() }} campaign(s) created
                        </p>
                    </div>
                </div>
            </div>

            <!-- Campaign Actions (Edit/Delete) -->
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="border-t pt-6 mb-6">
                        <div class="flex gap-4">
                            <!-- Edit button for admins only -->
                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                Edit Campaign (Admin)
                            </a>
                            
                            <!-- Delete button only for admins -->
                            <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone and will affect all associated donations.')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                    Delete Campaign (Admin)
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Navigation -->
            <div class="border-t pt-6">
                <a href="{{ route('campaigns.index') }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to All Campaigns
                </a>
            </div>
        </div>
    </div>
</div>
@endsection