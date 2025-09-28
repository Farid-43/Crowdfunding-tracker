@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                <p class="text-gray-600 mt-2">Manage your crowdfunding platform</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.campaigns') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                    Manage Campaigns
                </a>
                <a href="{{ route('admin.users') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Campaigns -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Campaigns</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_campaigns'] }}</p>
                </div>
            </div>
        </div>

        <!-- Active Campaigns -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Campaigns</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_campaigns'] }}</p>
                </div>
            </div>
        </div>

        <!-- Total Raised -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Raised</p>
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($stats['total_raised']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Campaigns -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Campaigns</h3>
                    <a href="{{ route('admin.campaigns') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentCampaigns->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentCampaigns as $campaign)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ Str::limit($campaign->title, 30) }}</h4>
                                    <p class="text-sm text-gray-600">by {{ $campaign->user->name }}</p>
                                    <div class="flex items-center mt-2">
                                        <span class="text-sm font-medium text-gray-900">
                                            ${{ number_format($campaign->current_amount) }} / ${{ number_format($campaign->goal_amount) }}
                                        </span>
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full
                                            @if($campaign->status === 'active') bg-green-100 text-green-800
                                            @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $campaign->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No campaigns yet</p>
                @endif
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Users</h3>
                    <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View All →
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentUsers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($user->role === 'admin') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No users yet</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Performing Campaigns -->
    <div class="mt-8 bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Top Performing Campaigns</h3>
        </div>
        <div class="p-6">
            @if($topCampaigns->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raised</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topCampaigns as $campaign)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($campaign->title, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $campaign->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">${{ number_format($campaign->current_amount) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">${{ number_format($campaign->goal_amount) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $percentage = $campaign->goal_amount > 0 ? ($campaign->current_amount / $campaign->goal_amount) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($percentage, 100) }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-900">{{ number_format($percentage, 1) }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($campaign->status === 'active') bg-green-100 text-green-800
                                            @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($campaign->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No campaigns yet</p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.campaigns') }}" class="bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-6 transition duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Manage Campaigns</h3>
                    <p class="text-sm text-gray-600">View, edit, and moderate all campaigns</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.users') }}" class="bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-6 transition duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Manage Users</h3>
                    <p class="text-sm text-gray-600">View and manage user accounts</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.analytics') }}" class="bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-6 transition duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">View Analytics</h3>
                    <p class="text-sm text-gray-600">Platform performance and insights</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection