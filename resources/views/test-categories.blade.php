@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Categories System Test</h1>
        
        <!-- Categories Test -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Available Categories ({{ $categories->count() }})</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($categories as $category)
                <div class="border border-gray-200 rounded-lg p-4" style="border-color: {{ $category->color }};">
                    <div class="flex items-center mb-2">
                        @if($category->icon)
                        <i class="{{ $category->icon }} mr-2" style="color: {{ $category->color }};"></i>
                        @endif
                        <h3 class="font-semibold text-gray-900">{{ $category->name }}</h3>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-2">{{ $category->description }}</p>
                    
                    <div class="text-xs text-gray-500">
                        <div>Slug: {{ $category->slug }}</div>
                        <div>Color: {{ $category->color }}</div>
                        <div>Active: {{ $category->is_active ? 'Yes' : 'No' }}</div>
                        <div>Sort Order: {{ $category->sort_order }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Campaign-Category Relationships Test -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Campaign-Category Relationships Test</h2>
            
            @if($campaignsWithCategories->count() > 0)
                @foreach($campaignsWithCategories as $campaign)
                <div class="border-b border-gray-200 pb-4 mb-4 last:border-0">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $campaign->title }}</h3>
                    
                    @if($campaign->categories->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-2">
                        @foreach($campaign->categories as $category)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                              style="background-color: {{ $category->color }}20; border: 1px solid {{ $category->color }}; color: {{ $category->color }};">
                            @if($category->icon)
                            <i class="{{ $category->icon }} mr-1"></i>
                            @endif
                            {{ $category->name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">No categories assigned</p>
                    @endif
                    
                    <p class="text-sm text-gray-600">
                        Old Category: {{ $campaign->category }} | 
                        New Categories: {{ $campaign->categories->count() }}
                    </p>
                </div>
                @endforeach
            @else
                <p class="text-gray-500">No campaigns found to test relationships.</p>
            @endif
        </div>

        <!-- Test Links -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Test Links</h3>
            <div class="space-y-2">
                <div><a href="{{ route('campaigns.index') }}" class="text-blue-600 hover:text-blue-800">View Campaigns Index (check category badges)</a></div>
                <div><a href="{{ route('campaigns.create') }}" class="text-blue-600 hover:text-blue-800">Create Campaign (test category selection)</a></div>
                @if($campaignsWithCategories->first())
                <div><a href="{{ route('campaigns.show', $campaignsWithCategories->first()) }}" class="text-blue-600 hover:text-blue-800">View Campaign Details (check category display)</a></div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection