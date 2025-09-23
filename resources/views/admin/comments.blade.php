@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-800 min-h-screen p-6">
            <div class="text-white">
                <div class="flex items-center mb-8">
                    <div class="bg-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Dashboard</h2>
                        <p class="text-slate-400 text-sm">Welcome, {{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('admin.campaigns') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Campaigns
                    </a>

                    <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        Users
                    </a>

                    <a href="{{ route('admin.comments') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-lg text-white">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"></path>
                        </svg>
                        Comments
                    </a>

                    <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4zM4 8V6a1 1 0 011-1h2a1 1 0 011 1v2H4zM10 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4zM16 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4z"></path>
                        </svg>
                        Analytics
                    </a>

                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        Reports
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        Settings
                    </a>

                    <a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Categories
                    </a>

                    <div class="border-t border-slate-700 my-4"></div>

                    <a href="{{ route('campaigns.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11H7a1 1 0 100-2H2.586l3.707-3.707a1 1 0 00-1.414-1.414l-5.414 5.414a1 1 0 000 1.414l5.414 5.414a1 1 0 001.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        View Site
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200 w-full text-left">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Page Header -->
                <div class="mb-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">🗨️ Comment Management</h1>
                            <p class="mt-2 text-gray-600">Manage all platform comments and interactions</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                Admin Panel
                            </span>
                        </div>
                    </div>
                </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 text-sm font-semibold">📝</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Comments</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-green-600 text-sm font-semibold">🆕</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Today</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['today']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-purple-600 text-sm font-semibold">📅</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">This Week</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['this_week']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-yellow-600 text-sm font-semibold">📌</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pinned</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['pinned']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                        <span class="text-orange-600 text-sm font-semibold">✏️</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Edited</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['edited']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.comments') }}" class="space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Comments</label>
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Search by content, user, or campaign..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Sort -->
                    <div class="sm:w-48">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sort" 
                                name="sort" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="campaign" {{ request('sort') == 'campaign' ? 'selected' : '' }}>Campaign A-Z</option>
                            <option value="user" {{ request('sort') == 'user' ? 'selected' : '' }}>User A-Z</option>
                        </select>
                    </div>

                    <!-- Filter -->
                    <div class="sm:w-48">
                        <label for="filter" class="block text-sm font-medium text-gray-700 mb-1">Filter</label>
                        <select id="filter" 
                                name="filter" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Comments</option>
                            <option value="pinned" {{ request('filter') == 'pinned' ? 'selected' : '' }}>Pinned Only</option>
                            <option value="edited" {{ request('filter') == 'edited' ? 'selected' : '' }}>Edited Only</option>
                            <option value="recent" {{ request('filter') == 'recent' ? 'selected' : '' }}>Recent (7 days)</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200">
                        🔍 Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['search', 'sort', 'filter']))
                        <a href="{{ route('admin.comments') }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 text-center">
                            🗑️ Clear Filters
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Comments List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">
                Comments 
                <span class="text-gray-500 text-sm font-normal">
                    ({{ $comments->total() }} total, showing {{ $comments->firstItem() }}-{{ $comments->lastItem() }})
                </span>
            </h2>

            @if($comments->count() > 0)
                <div class="space-y-4">
                    @foreach($comments as $comment)
                        <div class="border border-gray-200 rounded-lg p-4 {{ $comment->is_pinned ? 'bg-yellow-50 border-yellow-200' : '' }}">
                            <!-- Comment Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=4F46E5&color=fff&size=40" 
                                         alt="{{ $comment->user->name }}" 
                                         class="w-8 h-8 rounded-full">
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            on <a href="{{ route('campaigns.show', $comment->campaign) }}" class="text-blue-600 hover:text-blue-800">{{ $comment->campaign->title }}</a>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    @if($comment->is_pinned)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            📌 Pinned
                                        </span>
                                    @endif
                                    
                                    @if($comment->is_edited)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            ✏️ Edited
                                        </span>
                                    @endif
                                    
                                    <span class="text-xs text-gray-500">
                                        {{ $comment->created_at->format('M j, Y g:i A') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Comment Content -->
                            <div class="mb-3">
                                <p class="text-gray-800">{{ $comment->content }}</p>
                            </div>

                            <!-- Admin Actions -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Comment ID: #{{ $comment->id }}</span>
                                    @if($comment->updated_at != $comment->created_at)
                                        <span>Last edited: {{ $comment->updated_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('campaigns.show', $comment->campaign) }}#comment-{{ $comment->id }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        👁️ View in Context
                                    </a>
                                    
                                    <form method="POST" action="{{ route('comments.toggle-pin', $comment) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                            {{ $comment->is_pinned ? '📌 Unpin' : '📍 Pin' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('comments.destroy', $comment) }}" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this comment? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $comments->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 text-4xl mb-4">💬</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No comments found</h3>
                    <p class="text-gray-500">
                        @if(request()->hasAny(['search', 'filter']))
                            Try adjusting your search or filter criteria.
                        @else
                            No comments have been posted yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
        </div>
    </div>
</div>
@endsection