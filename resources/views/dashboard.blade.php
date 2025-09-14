@extends('layouts.app')

@section('title', 'Dashboard - Crowdfunding Tracker')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-lg text-gray-600 mt-2">Manage your campaigns and view your contributions</p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">My Campaigns</p>
                        <p class="text-3xl font-bold">0</p>
                    </div>
                    <div class="text-blue-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Total Raised</p>
                        <p class="text-3xl font-bold">$0</p>
                    </div>
                    <div class="text-green-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">My Donations</p>
                        <p class="text-3xl font-bold">0</p>
                    </div>
                    <div class="text-purple-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-orange-100 text-sm font-medium uppercase tracking-wide">Backers</p>
                        <p class="text-3xl font-bold">0</p>
                    </div>
                    <div class="text-orange-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">Start a Campaign</h3>
                <p class="text-indigo-100 mb-6">Turn your idea into reality. Create a campaign and get funding from the community.</p>
                <a href="#" class="bg-white text-indigo-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300 inline-block">
                    Create Campaign
                </a>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">Discover Projects</h3>
                <p class="text-green-100 mb-6">Find amazing projects to support and help creators bring their dreams to life.</p>
                <a href="{{ route('campaigns.index') }}" class="bg-white text-green-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-semibold transition duration-300 inline-block">
                    Browse Campaigns
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- My Campaigns -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">My Campaigns</h3>
                <div class="text-center py-8">
                    <div class="text-gray-400 text-6xl mb-4">📋</div>
                    <p class="text-gray-500 mb-4">You haven't created any campaigns yet.</p>
                    <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Create Your First Campaign
                    </a>
                </div>
            </div>

            <!-- My Donations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Recent Donations</h3>
                <div class="text-center py-8">
                    <div class="text-gray-400 text-6xl mb-4">❤️</div>
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
