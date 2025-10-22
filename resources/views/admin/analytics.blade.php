@extends('layouts.admin')

@section('content')
<!-- Header -->
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Platform Analytics</h1>
    <p class="text-gray-600 mt-2">Comprehensive insights into platform performance</p>
</div>

            <!-- Analytics Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Campaigns</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $analytics['total_campaigns'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $analytics['total_users'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Total Raised</p>
                            <p class="text-2xl font-bold text-gray-900">৳{{ number_format($analytics['total_raised'], 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Active Campaigns</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $analytics['active_campaigns'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Campaign Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Active Campaigns</span>
                            <span class="font-semibold">{{ $analytics['active_campaigns'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Completed Campaigns</span>
                            <span class="font-semibold">{{ $analytics['completed_campaigns'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Average Goal</span>
                            <span class="font-semibold">৳{{ number_format($analytics['average_campaign_goal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">This Month</span>
                            <span class="font-semibold">{{ $analytics['campaigns_this_month'] }} campaigns</span>
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">User Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Users</span>
                            <span class="font-semibold">{{ $analytics['total_users'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Admin Users</span>
                            <span class="font-semibold">{{ $analytics['admin_users'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Regular Users</span>
                            <span class="font-semibold">{{ $analytics['regular_users'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">New This Month</span>
                            <span class="font-semibold">{{ $analytics['users_this_month'] }} users</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Growth Trends -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">7-Day Growth Trends</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Campaigns</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Users</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($campaign_trends as $trend)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $trend['date'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trend['campaigns'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $trend['users'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection