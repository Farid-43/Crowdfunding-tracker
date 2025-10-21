@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Admin Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-800 text-white flex-shrink-0">
            <div class="p-6">
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
                    <a href="{{ route('admin.campaigns') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-lg text-white">
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

                    <a href="{{ route('admin.contacts') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Contact Messages
                    </a>

                    <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4zM4 8V6a1 1 0 011-1h2a1 1 0 011 1v2H4zM10 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4zM16 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4z"></path>
                        </svg>
                        Analytics
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
        <div class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">Campaign Management</h1>
                    <p class="text-gray-600 mt-2">Manage all campaigns on the platform</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

            <!-- Campaigns Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campaign</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Raised</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($campaigns as $campaign)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($campaign->image_path)
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ $campaign->image_path }}" alt="{{ $campaign->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-xs font-semibold">
                                                        {{ substr($campaign->category, 0, 2) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($campaign->title, 40) }}</div>
                                                <div class="text-sm text-gray-500">{{ $campaign->category }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $campaign->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $campaign->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ৳{{ number_format($campaign->goal_amount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ৳{{ number_format($campaign->current_amount) }}
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ min(100, $campaign->progress_percentage) }}%"></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($campaign->status === 'active') bg-green-100 text-green-800
                                                @elseif($campaign->status === 'paused') bg-yellow-100 text-yellow-800
                                                @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                            @if($campaign->featured)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    ⭐ Featured
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $campaign->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('campaigns.show', $campaign) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('campaigns.edit', $campaign) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            
                                            <!-- Toggle Featured Button -->
                                            <form method="POST" action="{{ route('admin.campaigns.toggle-featured', $campaign->id) }}" class="m-0">
                                                @csrf
                                                <button type="submit" class="{{ $campaign->featured ? 'text-orange-600 hover:text-orange-900' : 'text-blue-600 hover:text-blue-900' }}">
                                                    {{ $campaign->featured ? '★ Unfeature' : '☆ Feature' }}
                                                </button>
                                            </form>
                                            
                                            <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" class="m-0" 
                                                  onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $campaigns->links() }}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection