@extends('layouts.admin')

@section('content')
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
@endsection