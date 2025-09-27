@extends('layouts.app')

@section('title', 'Dashboard - Crowdfunding Tracker')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-lg text-gray-600 mt-2">Manage your campaigns and view your contributions</p>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- My Campaigns -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">My Campaigns</p>
                        <p class="text-3xl font-bold">{{ $stats['total_campaigns'] }}</p>
                    </div>
                    <div class="text-blue-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Raised -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Total Raised</p>
                        <p class="text-3xl font-bold">${{ number_format($stats['total_raised']) }}</p>
                    </div>
                    <div class="text-green-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- My Donations -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">My Donations</p>
                        <p class="text-3xl font-bold">${{ number_format($stats['total_donated']) }}</p>
                    </div>
                    <div class="text-purple-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-orange-100 text-sm font-medium uppercase tracking-wide">Success Rate</p>
                        <p class="text-3xl font-bold">{{ number_format($stats['success_rate'], 1) }}%</p>
                    </div>
                    <div class="text-orange-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18l-8-4a2 2 0 01-1-1.732V6.732a2 2 0 011-1.732l8-4a2 2 0 012 0l8 4a2 2 0 011 1.732v7.536a2 2 0 01-1 1.732l-8 4a2 2 0 01-2 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('campaigns.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
                    Create New Campaign
                </a>

                <a href="{{ route('campaigns.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200 text-center">
                    Browse Campaigns
                </a>

                <a href="{{ route('donations.user-history') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition duration-200 text-center">
                    My Donation History
                </a>

                <a href="{{ route('profile.edit') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200 text-center">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- My Campaigns Section -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">My Campaigns</h2>
                        <a href="{{ route('campaigns.create') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Create New →
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($campaigns->count() > 0)
                        <div class="space-y-4">
                            @foreach($campaigns->take(5) as $campaign)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-1">{{ $campaign->title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    ${{ number_format($campaign->current_amount) }} / ${{ number_format($campaign->goal_amount) }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $campaign->deadline->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($campaign->status === 'active') bg-green-100 text-green-800
                                            @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-800
                                            @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-3">
                                        @php
                                            $progressPercentage = $campaign->goal_amount > 0 ? ($campaign->current_amount / $campaign->goal_amount) * 100 : 0;
                                            $progressPercentage = min($progressPercentage, 100);
                                        @endphp
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                    </div>

                                    <!-- Campaign Actions -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">{{ number_format($progressPercentage, 1) }}% funded</span>
                                        <div class="flex space-x-4">
                                            <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                View
                                            </a>
                                            <a href="{{ route('campaigns.edit', $campaign) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($campaigns->count() > 5)
                                <div class="text-center pt-4">
                                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View All Campaigns ({{ $campaigns->count() }}) →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns yet</h3>
                            <p class="text-gray-600 mb-4">Start your first campaign and bring your ideas to life!</p>
                            <a href="{{ route('campaigns.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                                Create Your First Campaign
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- My Donations Section -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">My Donations</h2>
                        <a href="{{ route('donations.user-history') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            View All →
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($donations->count() > 0)
                        <div class="space-y-4">
                            @foreach($donations->take(5) as $donation)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-gray-900 mb-1">{{ $donation->campaign->title }}</h3>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    ${{ number_format($donation->amount, 2) }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $donation->created_at->format('M j, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </div>

                                    @if($donation->reward)
                                        <div class="mt-2 p-2 bg-blue-50 rounded text-sm">
                                            <span class="font-medium text-blue-900">Reward:</span>
                                            <span class="text-blue-700">{{ $donation->reward->title }}</span>
                                        </div>
                                    @endif

                                    <div class="flex justify-between items-center mt-3">
                                        <span class="text-sm text-gray-600">
                                            @if($donation->campaign->current_amount >= $donation->campaign->goal_amount)
                                                <span class="text-green-600 font-medium">✓ Goal Reached!</span>
                                            @else
                                                Campaign: {{ number_format(($donation->campaign->current_amount / $donation->campaign->goal_amount) * 100, 1) }}% funded
                                            @endif
                                        </span>
                                        <a href="{{ route('campaigns.show', $donation->campaign) }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                            View Campaign
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            @if($donations->count() > 5)
                                <div class="text-center pt-4">
                                    <a href="{{ route('donations.user-history') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        View All Donations ({{ $donations->count() }}) →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No donations yet</h3>
                            <p class="text-gray-600 mb-4">Start supporting amazing campaigns and make a difference!</p>
                            <a href="{{ route('campaigns.index') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                                Browse Campaigns
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Stats Section -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Campaign Performance -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Performance</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Active Campaigns:</span>
                        <span class="font-medium">{{ $stats['active_campaigns'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Backers:</span>
                        <span class="font-medium">{{ $stats['total_backers'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Avg. Campaign Goal:</span>
                        <span class="font-medium">${{ number_format($stats['avg_campaign_goal']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Donation Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Donation Summary</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Campaigns Supported:</span>
                        <span class="font-medium">{{ $stats['campaigns_supported'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Donated:</span>
                        <span class="font-medium">${{ number_format($stats['total_donated']) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Avg. Donation:</span>
                        <span class="font-medium">${{ number_format($stats['avg_donation']) }}</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    @forelse($recentActivity as $activity)
                        <div class="flex items-center space-x-3">
                            @if($activity['type'] === 'campaign')
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 truncate">Created <a href="{{ $activity['url'] }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $activity['title'] }}</a></p>
                                    <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                                </div>
                            @else
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900 truncate">Donated ${{ number_format($activity['amount']) }} to <a href="{{ $activity['url'] }}" class="font-medium text-green-600 hover:text-green-800">{{ $activity['title'] }}</a></p>
                                    <p class="text-xs text-gray-500">{{ $activity['date']->diffForHumans() }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No recent activity</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection