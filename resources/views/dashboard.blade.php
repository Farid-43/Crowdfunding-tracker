@extends('layouts.app')@extends('layouts.app')@extends('layouts.app')



@section('content')

<div class="py-12">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">@section('content')@section('title', 'Dashboard - Crowdfunding Tracker')

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <div class="p-6 text-gray-900"><div class="py-12">

                <h2 class="text-2xl font-bold mb-6">Welcome to your Dashboard, {{ auth()->user()->name }}!</h2>

                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">@section('content')

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Quick Stats -->        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"><div class="bg-white py-8">

                    <div class="bg-blue-50 p-6 rounded-lg">

                        <h3 class="text-lg font-semibold text-blue-800 mb-2">My Campaigns</h3>            <div class="p-6 text-gray-900">    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                        <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->campaigns->count() }}</p>

                        <p class="text-sm text-blue-600">Active campaigns</p>                <h2 class="text-2xl font-bold mb-6">Welcome to your Dashboard, {{ auth()->user()->name }}!</h2>        <!-- Welcome Header -->

                    </div>

                        <div class="mb-8">

                    <div class="bg-green-50 p-6 rounded-lg">

                        <h3 class="text-lg font-semibold text-green-800 mb-2">Total Raised</h3>                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>

                        <p class="text-3xl font-bold text-green-600">${{ number_format(auth()->user()->campaigns->sum('current_amount')) }}</p>

                        <p class="text-sm text-green-600">Across all campaigns</p>                    <!-- Quick Stats -->            <p class="text-lg text-gray-600 mt-2">Manage your campaigns and view your contributions</p>

                    </div>

                    <div class="bg-blue-50 p-6 rounded-lg">        </div>

                    <div class="bg-purple-50 p-6 rounded-lg">

                        <h3 class="text-lg font-semibold text-purple-800 mb-2">Success Rate</h3>                        <h3 class="text-lg font-semibold text-blue-800 mb-2">My Campaigns</h3>

                        <p class="text-3xl font-bold text-purple-600">

                            @php                        <p class="text-3xl font-bold text-blue-600">{{ auth()->user()->campaigns->count() }}</p>        <!-- Quick Stats -->

                                $totalCampaigns = auth()->user()->campaigns->count();

                                $successfulCampaigns = auth()->user()->campaigns->filter(function($campaign) {                        <p class="text-sm text-blue-600">Active campaigns</p>        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                                    return $campaign->current_amount >= $campaign->goal_amount;

                                })->count();                    </div>            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">

                                $successRate = $totalCampaigns > 0 ? ($successfulCampaigns / $totalCampaigns) * 100 : 0;

                            @endphp                <div class="flex items-center">

                            {{ number_format($successRate, 1) }}%

                        </p>                    <div class="bg-green-50 p-6 rounded-lg">                    <div class="flex-1">

                        <p class="text-sm text-purple-600">Goals achieved</p>

                    </div>                        <h3 class="text-lg font-semibold text-green-800 mb-2">Total Raised</h3>                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">My Campaigns</p>

                </div>

                        <p class="text-3xl font-bold text-green-600">${{ number_format(auth()->user()->campaigns->sum('current_amount')) }}</p>                        <p class="text-3xl font-bold">0</p>

                <!-- Quick Actions -->

                <div class="mt-8">                        <p class="text-sm text-green-600">Across all campaigns</p>                    </div>

                    <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>

                    <div class="flex flex-wrap gap-4">                    </div>                    <div class="text-blue-200">

                        <a href="{{ route('campaigns.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">

                            Create New Campaign                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">

                        </a>

                        <a href="{{ route('campaigns.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200">                    <div class="bg-purple-50 p-6 rounded-lg">                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                            Browse Campaigns

                        </a>                        <h3 class="text-lg font-semibold text-purple-800 mb-2">Success Rate</h3>                        </svg>

                        <a href="{{ route('profile.edit') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">

                            Edit Profile                        <p class="text-3xl font-bold text-purple-600">                    </div>

                        </a>

                    </div>                            {{ auth()->user()->campaigns->count() > 0 ? number_format((auth()->user()->campaigns->where('current_amount', '>=', DB::raw('goal_amount'))->count() / auth()->user()->campaigns->count()) * 100, 1) : 0 }}%                </div>

                </div>

                        </p>            </div>

                <!-- Recent Campaigns -->

                @if(auth()->user()->campaigns->count() > 0)                        <p class="text-sm text-purple-600">Goals achieved</p>

                <div class="mt-8">

                    <h3 class="text-xl font-semibold mb-4">My Recent Campaigns</h3>                    </div>            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">

                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">

                        <table class="min-w-full divide-y divide-gray-200">                </div>                <div class="flex items-center">

                            <thead class="bg-gray-50">

                                <tr>                    <div class="flex-1">

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal</th>                <!-- Quick Actions -->                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Total Raised</p>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raised</th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>                <div class="mt-8">                        <p class="text-3xl font-bold">$0</p>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>

                                </tr>                    <h3 class="text-xl font-semibold mb-4">Quick Actions</h3>                    </div>

                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">                    <div class="flex flex-wrap gap-4">                    <div class="text-green-200">

                                @foreach(auth()->user()->campaigns->latest()->take(5) as $campaign)

                                <tr>                        <a href="{{ route('campaigns.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200">                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>                            Create New Campaign                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>

                                        <div class="text-sm text-gray-500">{{ Str::limit($campaign->description, 50) }}</div>

                                    </td>                        </a>                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"/>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">

                                        ${{ number_format($campaign->goal_amount) }}                        <a href="{{ route('campaigns.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition duration-200">                        </svg>

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">                            Browse Campaigns                    </div>

                                        ${{ number_format($campaign->current_amount) }}

                                    </td>                        </a>                </div>

                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="w-full bg-gray-200 rounded-full h-2">                        <a href="{{ route('profile.edit') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-200">            </div>

                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($campaign->current_amount / $campaign->goal_amount) * 100, 100) }}%"></div>

                                        </div>                            Edit Profile

                                        <span class="text-xs text-gray-500">{{ number_format(min(($campaign->current_amount / $campaign->goal_amount) * 100, 100), 1) }}%</span>

                                    </td>                        </a>            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                        <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>                    </div>                <div class="flex items-center">

                                        <a href="{{ route('campaigns.edit', $campaign) }}" class="text-green-600 hover:text-green-900">Edit</a>

                                    </td>                </div>                    <div class="flex-1">

                                </tr>

                                @endforeach                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">My Donations</p>

                            </tbody>

                        </table>                <!-- Recent Campaigns -->                        <p class="text-3xl font-bold">0</p>

                    </div>

                </div>                @if(auth()->user()->campaigns->count() > 0)                    </div>

                @else

                <div class="mt-8 text-center py-12 bg-gray-50 rounded-lg">                <div class="mt-8">                    <div class="text-purple-200">

                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>                    <h3 class="text-xl font-semibold mb-4">My Recent Campaigns</h3>                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">

                    </svg>

                    <h3 class="mt-2 text-sm font-medium text-gray-900">No campaigns yet</h3>                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>

                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first campaign.</p>

                    <div class="mt-6">                        <table class="min-w-full divide-y divide-gray-200">                        </svg>

                        <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">

                            Create Campaign                            <thead class="bg-gray-50">                    </div>

                        </a>

                    </div>                                <tr>                </div>

                </div>

                @endif                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>            </div>

            </div>

        </div>                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal</th>

    </div>

</div>                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raised</th>            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">

@endsection
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>                <div class="flex items-center">

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>                    <div class="flex-1">

                                </tr>                        <p class="text-orange-100 text-sm font-medium uppercase tracking-wide">Backers</p>

                            </thead>                        <p class="text-3xl font-bold">0</p>

                            <tbody class="bg-white divide-y divide-gray-200">                    </div>

                                @foreach(auth()->user()->campaigns->latest()->take(5) as $campaign)                    <div class="text-orange-200">

                                <tr>                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">

                                    <td class="px-6 py-4 whitespace-nowrap">                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>

                                        <div class="text-sm font-medium text-gray-900">{{ $campaign->title }}</div>                        </svg>

                                        <div class="text-sm text-gray-500">{{ Str::limit($campaign->description, 50) }}</div>                    </div>

                                    </td>                </div>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">            </div>

                                        ${{ number_format($campaign->goal_amount) }}        </div>

                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">        <!-- Action Buttons -->

                                        ${{ number_format($campaign->current_amount) }}        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                                    </td>            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-8 text-white">

                                    <td class="px-6 py-4 whitespace-nowrap">                <h3 class="text-2xl font-bold mb-4">Start a Campaign</h3>

                                        <div class="w-full bg-gray-200 rounded-full h-2">                <p class="text-indigo-100 mb-6">Turn your idea into reality. Create a campaign and get funding from the community.</p>

                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($campaign->current_amount / $campaign->goal_amount) * 100, 100) }}%"></div>                <a href="#" class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300 inline-block">

                                        </div>                    Create Campaign

                                        <span class="text-xs text-gray-500">{{ number_format(min(($campaign->current_amount / $campaign->goal_amount) * 100, 100), 1) }}%</span>                </a>

                                    </td>            </div>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">

                                        <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>            <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg p-8 text-white">

                                        <a href="{{ route('campaigns.edit', $campaign) }}" class="text-green-600 hover:text-green-900">Edit</a>                <h3 class="text-2xl font-bold mb-4">Discover Projects</h3>

                                    </td>                <p class="text-green-100 mb-6">Find amazing projects to support and help creators bring their dreams to life.</p>

                                </tr>                <a href="{{ route('campaigns.index') }}" class="bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300 inline-block">

                                @endforeach                    Browse Campaigns

                            </tbody>                </a>

                        </table>            </div>

                    </div>        </div>

                </div>

                @else        <!-- Recent Activity -->

                <div class="mt-8 text-center py-12 bg-gray-50 rounded-lg">        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">            <!-- My Campaigns -->

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>            <div class="bg-white rounded-lg shadow-md p-6">

                    </svg>                <h3 class="text-xl font-semibold text-gray-900 mb-4">My Campaigns</h3>

                    <h3 class="mt-2 text-sm font-medium text-gray-900">No campaigns yet</h3>                <div class="text-center py-8">

                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first campaign.</p>                    <div class="text-gray-400 text-6xl mb-4">📋</div>

                    <div class="mt-6">                    <p class="text-gray-500 mb-4">You haven't created any campaigns yet.</p>

                        <a href="{{ route('campaigns.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">

                            Create Campaign                        Create Your First Campaign

                        </a>                    </a>

                    </div>                </div>

                </div>            </div>

                @endif

            </div>            <!-- My Donations -->

        </div>            <div class="bg-white rounded-lg shadow-md p-6">

    </div>                <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Donations</h3>

</div>                <div class="text-center py-8">

@endsection                    <div class="text-gray-400 text-6xl mb-4">❤️</div>
                    <p class="text-gray-500 mb-4">You haven't made any donations yet.</p>
                    <a href="{{ route('campaigns.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Explore Campaigns
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
