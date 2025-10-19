@extends('layouts.app')

@section('title', 'Home - Crowdfunding Tracker')

@section('content')
<!-- Hero Section with Enhanced Gradients -->
<div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden">
    <!-- Animated Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')]"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 animate-fade-in">
                Fund Your Dreams,<br>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-orange-400">
                    Change the World
                </span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-indigo-50 max-w-3xl mx-auto">
                Join thousands of creators and backers making amazing projects happen
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('campaigns.index') }}" 
                   class="inline-flex items-center justify-center bg-white text-indigo-600 hover:bg-gray-50 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Explore Campaigns
                </a>
                <a href="{{ route('campaigns.start') }}" 
                   class="inline-flex items-center justify-center border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Start a Campaign
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section with Enhanced Cards -->
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Projects Created -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-75 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($stats['total_campaigns']) }}</div>
                    <div class="text-gray-600 font-semibold">Projects Created</div>
                </div>
            </div>

            <!-- Total Raised -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 rounded-2xl opacity-75 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">৳{{ number_format($stats['total_raised'], 0) }}</div>
                    <div class="text-gray-600 font-semibold">Total Raised</div>
                </div>
            </div>

            <!-- Backers -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-pink-500 rounded-2xl opacity-75 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ number_format($stats['total_backers']) }}</div>
                    <div class="text-gray-600 font-semibold">Backers</div>
                </div>
            </div>

            <!-- Success Rate -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-red-500 rounded-2xl opacity-75 group-hover:opacity-100 transition duration-300 blur"></div>
                <div class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-orange-100 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-gray-900 mb-2">{{ $stats['success_rate'] }}%</div>
                    <div class="text-gray-600 font-semibold">Success Rate</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Campaigns Section -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Featured Campaigns
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover amazing projects from creators around the world
            </p>
        </div>

        <!-- Campaign Cards Grid with Enhanced Design -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredCampaigns as $campaign)
                <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <!-- Campaign Image with Overlay -->
                    <div class="h-56 relative overflow-hidden">
                        @if($campaign->image_path)
                            <img src="{{ $campaign->image_path }}" 
                                 alt="{{ $campaign->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=800&h=600&fit=crop';">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 flex items-center justify-center transition-transform duration-700 group-hover:scale-110">
                                <span class="text-white text-3xl font-bold drop-shadow-lg">{{ $campaign->category }}</span>
                            </div>
                        @endif
                        
                        <!-- Gradient Overlay on Hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        @if($campaign->featured)
                            <div class="absolute top-4 right-4 z-10">
                                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1 backdrop-blur-sm">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Featured
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <!-- Category and Days Remaining -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-xs font-bold px-3 py-1.5 rounded-full">
                                {{ $campaign->category }}
                            </span>
                            <span class="flex items-center text-sm text-gray-500 font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $campaign->days_remaining }} days
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                            {{ $campaign->title }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {{ $campaign->short_description }}
                        </p>
                        
                        <!-- Enhanced Progress Bar -->
                        <div class="mb-5">
                            <div class="flex justify-between text-sm font-semibold mb-2">
                                <span class="text-gray-700">৳{{ number_format($campaign->current_amount, 0) }}</span>
                                <span class="text-indigo-600">{{ $campaign->progress_percentage }}%</span>
                            </div>
                            <div class="relative w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 shadow-lg" 
                                     style="width: {{ min($campaign->progress_percentage, 100) }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1.5 font-medium">
                                Goal: ৳{{ number_format($campaign->goal_amount, 0) }}
                            </div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="flex items-center text-sm text-gray-600 font-medium">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                {{ $campaign->backers_count }} backers
                            </span>
                            <a href="{{ route('campaigns.show', $campaign) }}" 
                               class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-xl">
                                View
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20">
                    <div class="bg-gray-100 rounded-2xl p-12 max-w-md mx-auto">
                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-600 text-lg font-semibold mb-6">No campaigns available yet.</p>
                        <a href="{{ route('campaigns.create') }}" 
                           class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Campaign
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-16">
            <a href="{{ route('campaigns.index') }}" 
               class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-10 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                View All Campaigns
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</div>

<!-- How It Works Section with Enhanced Design -->
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                How It Works
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Simple steps to fund your project or support others
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Step 1 -->
            <div class="relative text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full blur-2xl opacity-25 group-hover:opacity-40 transition duration-500"></div>
                    <div class="relative bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl w-24 h-24 flex items-center justify-center mx-auto transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <span class="text-5xl">🚀</span>
                    </div>
                    <div class="absolute -top-3 -right-3 bg-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-2xl text-indigo-600 shadow-lg border-4 border-indigo-100">
                        1
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Create Campaign</h3>
                <p class="text-gray-600 leading-relaxed">
                    Tell your story, set your funding goal, and launch your campaign to the world with our easy-to-use tools.
                </p>
            </div>

            <!-- Step 2 -->
            <div class="relative text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full blur-2xl opacity-25 group-hover:opacity-40 transition duration-500"></div>
                    <div class="relative bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl w-24 h-24 flex items-center justify-center mx-auto transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <span class="text-5xl">💝</span>
                    </div>
                    <div class="absolute -top-3 -right-3 bg-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-2xl text-green-600 shadow-lg border-4 border-green-100">
                        2
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Get Backers</h3>
                <p class="text-gray-600 leading-relaxed">
                    Share your campaign and attract supporters who believe in your vision and want to help you succeed.
                </p>
            </div>

            <!-- Step 3 -->
            <div class="relative text-center group">
                <div class="relative mb-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-600 rounded-full blur-2xl opacity-25 group-hover:opacity-40 transition duration-500"></div>
                    <div class="relative bg-gradient-to-br from-yellow-500 to-orange-600 rounded-3xl w-24 h-24 flex items-center justify-center mx-auto transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 shadow-xl">
                        <span class="text-5xl">🎯</span>
                    </div>
                    <div class="absolute -top-3 -right-3 bg-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-2xl text-orange-600 shadow-lg border-4 border-orange-100">
                        3
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Reach Your Goal</h3>
                <p class="text-gray-600 leading-relaxed">
                    Once funded, bring your project to life and reward your backers with exclusive perks and updates.
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-20 text-center">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-12 shadow-2xl">
                <h3 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Ready to Start Your Journey?
                </h3>
                <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Join our community of creators and backers making dreams come true
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('campaigns.start') }}" 
                       class="inline-flex items-center justify-center bg-white text-indigo-600 hover:bg-gray-50 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105 shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Start Your Campaign
                    </a>
                    <a href="{{ route('campaigns.index') }}" 
                       class="inline-flex items-center justify-center border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Browse Campaigns
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection