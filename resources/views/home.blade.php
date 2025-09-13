@extends('layouts.app')

@section('title', 'Home - Crowdfunding Tracker')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Fund Your Dreams,<br>
                <span class="text-yellow-300">Change the World</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-indigo-100">
                Join thousands of creators and backers making amazing projects happen
            </p>
            <div class="space-x-4">
                <a href="{{ route('campaigns.index') }}" 
                   class="bg-white text-indigo-600 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold text-lg transition duration-300">
                    Explore Campaigns
                </a>
                <a href="#" 
                   class="border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-lg font-semibold text-lg transition duration-300">
                    Start a Campaign
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-3xl font-bold text-indigo-600 mb-2">1,234</div>
                <div class="text-gray-600">Projects Funded</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-green-600 mb-2">$2.5M</div>
                <div class="text-gray-600">Raised</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-600 mb-2">45,678</div>
                <div class="text-gray-600">Backers</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-orange-600 mb-2">89%</div>
                <div class="text-gray-600">Success Rate</div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Campaigns Section -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Campaigns</h2>
            <p class="text-lg text-gray-600">Discover amazing projects from creators around the world</p>
        </div>

        <!-- Campaign Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Sample Campaign Card 1 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Technology</span>
                        <span class="text-sm text-gray-500">2 days left</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Smart Home Assistant</h3>
                    <p class="text-gray-600 text-sm mb-4">Revolutionary AI-powered home automation system that learns your preferences.</p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>$85,000 raised</span>
                            <span>85% funded</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Goal: $100,000</div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">234 backers</span>
                        <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back This Project
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sample Campaign Card 2 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="h-48 bg-gradient-to-r from-green-400 to-green-600"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Health</span>
                        <span class="text-sm text-gray-500">15 days left</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Medical Clinic for Remote Area</h3>
                    <p class="text-gray-600 text-sm mb-4">Building healthcare infrastructure for underserved communities.</p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>$45,000 raised</span>
                            <span>60% funded</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Goal: $75,000</div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">156 backers</span>
                        <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back This Project
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sample Campaign Card 3 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600"></div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded">Education</span>
                        <span class="text-sm text-gray-500">7 days left</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Online Learning Platform</h3>
                    <p class="text-gray-600 text-sm mb-4">Interactive education platform for students in developing countries.</p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>$92,000 raised</span>
                            <span>92% funded</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full" style="width: 92%"></div>
                        </div>
                        <div class="text-sm text-gray-600 mt-1">Goal: $100,000</div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">478 backers</span>
                        <a href="#" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Back This Project
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('campaigns.index') }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition duration-300">
                View All Campaigns
            </a>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
            <p class="text-lg text-gray-600">Simple steps to fund your project or support others</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-indigo-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🚀</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">1. Create Campaign</h3>
                <p class="text-gray-600">Tell your story, set your funding goal, and launch your campaign to the world.</p>
            </div>
            <div class="text-center">
                <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">💝</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">2. Get Backers</h3>
                <p class="text-gray-600">Share your campaign and attract supporters who believe in your vision.</p>
            </div>
            <div class="text-center">
                <div class="bg-yellow-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🎯</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">3. Reach Your Goal</h3>
                <p class="text-gray-600">Once funded, bring your project to life and reward your backers.</p>
            </div>
        </div>
    </div>
</div>
@endsection