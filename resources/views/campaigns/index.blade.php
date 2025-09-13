@extends('layouts.app')

@section('title', 'All Campaigns - Crowdfunding Tracker')

@section('content')
<div class="bg-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">All Campaigns</h1>
            <p class="text-lg text-gray-600 mb-8">
                Discover amazing projects and help bring them to life
            </p>
            
            <!-- Search and Filter Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-center">
                    <input type="text" 
                           placeholder="Search campaigns..." 
                           class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <select class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Categories</option>
                        <option value="technology">Technology</option>
                        <option value="health">Health</option>
                        <option value="education">Education</option>
                        <option value="charity">Charity</option>
                    </select>
                    <button class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium">
                        Search
                    </button>
                </div>
            </div>

            <!-- Placeholder message -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
                <div class="text-6xl mb-4">🚧</div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">Coming Soon!</h2>
                <p class="text-gray-600">
                    Campaign listing will be implemented in Day 6. 
                    For now, check out the featured campaigns on the <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 underline">home page</a>!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection