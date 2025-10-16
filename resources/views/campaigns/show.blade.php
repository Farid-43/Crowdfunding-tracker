@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Campaign Header -->
        <div class="h-64 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center relative overflow-hidden">
            @if($campaign->image_path)
                <img src="{{ $campaign->image_path }}" 
                     alt="{{ $campaign->title }}" 
                     class="w-full h-full object-cover"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=1200&h=600&fit=crop';">
            @else
                <img src="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=1200&h=600&fit=crop" 
                     alt="{{ $campaign->title }}" 
                     class="w-full h-full object-cover opacity-50">
                <span class="text-white text-2xl font-bold absolute">{{ $campaign->category }}</span>
            @endif
            
            <!-- Featured Badge -->
            @if($campaign->featured)
                <div class="absolute top-4 right-4">
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full">
                        ⭐ Featured
                    </span>
                </div>
            @endif
        </div>

        <!-- Campaign Content -->
        <div class="p-8">
            <!-- Display success message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="text-green-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Title and Creator -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $campaign->title }}</h1>
                <p class="text-gray-600 mb-3">
                    by <span class="font-semibold text-blue-600">{{ $campaign->user->name }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-sm">{{ $campaign->category }}</span>
                </p>
                
                <!-- Categories -->
                @if($campaign->categories->count() > 0)
                <div class="flex flex-wrap gap-2">
                    @foreach($campaign->categories as $category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border"
                          style="background-color: {{ $category->color }}20; border-color: {{ $category->color }}; color: {{ $category->color }};">
                        @if($category->icon)
                        <i class="{{ $category->icon }} mr-1"></i>
                        @endif
                        {{ $category->name }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Progress Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Amount Raised -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">${{ number_format($campaign->current_amount) }}</div>
                        <div class="text-sm text-gray-600">raised of ${{ number_format($campaign->goal_amount) }} goal</div>
                    </div>
                    
                    <!-- Progress Percentage -->
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $campaign->progress_percentage }}%</div>
                        <div class="text-sm text-gray-600">funded</div>
                    </div>
                    
                    <!-- Days Remaining -->
                    <div class="text-center">
                        <div class="text-3xl font-bold {{ $campaign->days_remaining > 7 ? 'text-gray-700' : 'text-red-600' }}">
                            {{ $campaign->days_remaining }}
                        </div>
                        <div class="text-sm text-gray-600">days to go</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, $campaign->progress_percentage) }}%"></div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-4">
                    @if(!$campaign->is_expired && $campaign->status === 'active')
                        <!-- Quick Donate Button (AJAX) -->
                        <button onclick="openDonateModal()" 
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                            💚 Quick Donate
                        </button>
                        
                        <!-- Full Donate Page Link -->
                        <a href="{{ route('donations.create', $campaign) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 text-center">
                            Full Form
                        </a>
                    @else
                        <!-- Campaign Ended -->
                        <div class="flex-1 bg-gray-400 text-white font-bold py-3 px-6 rounded-lg text-center cursor-not-allowed">
                            Campaign Ended
                        </div>
                    @endif

                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                Edit Campaign (Admin)
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin' || auth()->user()->id === $campaign->user_id)
                            <a href="{{ route('rewards.create', $campaign) }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition duration-200 ml-2">
                                Add Reward
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Donation History Link -->
                <div class="mt-4 text-center">
                    <a href="{{ route('donations.campaign-history', $campaign) }}" 
                       class="inline-flex items-center text-purple-600 hover:text-purple-800 font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        View Donation History ({{ $campaign->donations_count ?? $campaign->donations->count() }} supporters)
                    </a>
                </div>

                <!-- Guest User Encouragement -->
                @guest
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Have an account? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Sign in</a> 
                        to track your donations
                    </p>
                </div>
                @endguest
            </div>

            <!-- Campaign Description -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">About This Project</h2>
                
                <!-- Short Description -->
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                    <p class="text-blue-800 font-medium">{{ $campaign->short_description }}</p>
                </div>
                
                <!-- Full Description -->
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $campaign->description }}</p>
                </div>
            </div>

            <!-- Campaign Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Campaign Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Details</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium capitalize 
                                {{ $campaign->status === 'active' ? 'text-green-600' : 
                                   ($campaign->status === 'completed' ? 'text-blue-600' : 'text-red-600') }}">
                                {{ $campaign->status }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $campaign->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Deadline:</span>
                            <span class="font-medium">{{ $campaign->deadline->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Backers:</span>
                            <span class="font-medium">{{ number_format($campaign->backers_count) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Creator Info -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Creator</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($campaign->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <div class="font-semibold text-gray-900">{{ $campaign->user->name }}</div>
                                <div class="text-sm text-gray-600">Campaign Creator</div>
                            </div>
                        </div>
                        <p class="text-gray-600 text-sm">
                            {{ $campaign->user->campaigns->count() }} campaign(s) created
                        </p>
                    </div>
                </div>
            </div>

            <!-- Campaign Actions (Edit/Delete) -->
            @auth
                @if(auth()->user()->role === 'admin')
                    <div class="border-t pt-6 mb-6">
                        <div class="flex gap-4">
                            <!-- Edit button for admins only -->
                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                Edit Campaign (Admin)
                            </a>
                            
                            <!-- Delete button only for admins -->
                            <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}" 
                                  onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone and will affect all associated donations.')"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                                    Delete Campaign (Admin)
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Rewards Section -->
            @if($campaign->rewards->count() > 0)
                <div class="border-t pt-8 mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">🎁 Campaign Rewards</h2>
                        <a href="{{ route('rewards.index', $campaign) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            View All Rewards →
                        </a>
                    </div>
                    
                    <!-- Featured Rewards (show first 3) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        @foreach($campaign->availableRewards()->take(3)->get() as $reward)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-900">{{ $reward->title }}</h3>
                                    <span class="text-lg font-bold text-blue-600">
                                        ${{ number_format($reward->minimum_amount, 0) }}+
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($reward->description, 80) }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        {{ $reward->current_backers }} backer{{ $reward->current_backers != 1 ? 's' : '' }}
                                    </span>
                                    <a href="{{ route('donations.create', $campaign) }}?reward_id={{ $reward->id }}" 
                                       class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-200">
                                        Select
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($campaign->rewards->count() > 3)
                        <div class="text-center">
                            <a href="{{ route('rewards.index', $campaign) }}" 
                               class="inline-flex items-center bg-gray-100 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-200 transition duration-200">
                                View All {{ $campaign->rewards->count() }} Rewards
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Comments Section -->
            <div class="border-t pt-8 mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Comments & Discussion</h2>
                
                @auth
                    <!-- Comment Form -->
                    <div class="mb-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Comment</h3>
                        
                        <form action="{{ route('comments.store', $campaign) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                    Your Comment
                                </label>
                                <textarea
                                    id="content"
                                    name="content"
                                    rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror"
                                    placeholder="Share your thoughts about this campaign..."
                                    maxlength="1000"
                                >{{ old('content') }}</textarea>
                                
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                
                                <!-- Character counter -->
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-sm text-gray-500">
                                        Be respectful and constructive in your comments.
                                    </p>
                                    <span class="text-sm text-gray-500" id="char-count">0/1000</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">
                                        Commenting as {{ auth()->user()->name }}
                                    </span>
                                </div>
                                
                                <button
                                    type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200"
                                >
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Login prompt for guests -->
                    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <div>
                                <p class="text-blue-800 font-medium">Join the conversation!</p>
                                <p class="text-blue-700 text-sm">
                                    <a href="{{ route('login') }}" class="underline hover:text-blue-900">Sign in</a> 
                                    or 
                                    <a href="{{ route('register') }}" class="underline hover:text-blue-900">create an account</a> 
                                    to comment on this campaign.
                                </p>
                            </div>
                        </div>
                    </div>
                @endauth

                <!-- Comments Display -->
                <div class="space-y-6">
                    @forelse($campaign->comments()->with('user')->ordered()->take(5)->get() as $comment)
                        <div class="bg-white border border-gray-200 rounded-lg p-6" id="comment-{{ $comment->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- User Avatar -->
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h4 class="font-semibold text-gray-900">{{ $comment->user->name }}</h4>
                                            @if($comment->user->role === 'admin')
                                                <span class="ml-2 bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Admin</span>
                                            @endif
                                            @if($comment->campaign->user_id === $comment->user_id)
                                                <span class="ml-2 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Creator</span>
                                            @endif
                                            @if($comment->is_pinned)
                                                <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">📌 Pinned</span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                                        
                                        <div class="flex items-center mt-3 text-sm text-gray-500">
                                            <span>{{ $comment->created_at->format('M j, Y \a\t g:i A') }}</span>
                                            @if($comment->is_edited)
                                                <span class="mx-2">•</span>
                                                <span>Edited {{ $comment->edited_at->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Comment Actions -->
                                @auth
                                    <div class="flex items-center space-x-4">
                                        @if($comment->canBeEditedBy(auth()->user()))
                                            <button 
                                                onclick="toggleEditComment({{ $comment->id }})"
                                                class="text-blue-600 hover:text-blue-800 text-sm"
                                            >
                                                Edit
                                            </button>
                                        @endif
                                        
                                        @if(auth()->user()->isAdmin() || $campaign->user_id === auth()->id())
                                            <form action="{{ route('comments.toggle-pin', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button 
                                                    type="submit"
                                                    class="text-yellow-600 hover:text-yellow-800 text-sm"
                                                >
                                                    {{ $comment->is_pinned ? 'Unpin' : 'Pin' }}
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($comment->canBeDeletedBy(auth()->user()))
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this comment?')"
                                                    class="text-red-600 hover:text-red-800 text-sm"
                                                >
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                            
                            <!-- Edit Form (hidden by default) -->
                            @auth
                                @if($comment->canBeEditedBy(auth()->user()))
                                    <div id="edit-form-{{ $comment->id }}" class="hidden mt-4">
                                        <form action="{{ route('comments.update', $comment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <textarea
                                                name="content"
                                                rows="3"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                maxlength="1000"
                                            >{{ $comment->content }}</textarea>
                                            
                                            <div class="flex justify-end space-x-2 mt-3">
                                                <button
                                                    type="button"
                                                    onclick="toggleEditComment({{ $comment->id }})"
                                                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg text-sm"
                                                >
                                                    Cancel
                                                </button>
                                                <button
                                                    type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm"
                                                >
                                                    Update Comment
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No comments yet</h3>
                            <p class="text-gray-600">Be the first to share your thoughts about this campaign!</p>
                        </div>
                    @endforelse
                </div>

                @if($campaign->comments()->count() > 5)
                    <div class="text-center mt-6">
                        <a href="{{ route('comments.index', $campaign) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            View all {{ $campaign->comments()->count() }} comments
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Navigation -->
            <div class="border-t pt-6">
                <a href="{{ route('campaigns.index') }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to All Campaigns
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Character counter for comment form
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('char-count');
    
    if (textarea && charCount) {
        function updateCharCount() {
            const count = textarea.value.length;
            charCount.textContent = count + '/1000';
            
            if (count > 950) {
                charCount.classList.add('text-red-500');
                charCount.classList.remove('text-gray-500');
            } else {
                charCount.classList.add('text-gray-500');
                charCount.classList.remove('text-red-500');
            }
        }
        
        textarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count
    }
});

// Toggle edit form for comments
function toggleEditComment(commentId) {
    const editForm = document.getElementById('edit-form-' + commentId);
    if (editForm) {
        editForm.classList.toggle('hidden');
    }
}

// Scroll to comment if there's a fragment
document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash && window.location.hash.startsWith('#comment-')) {
        const element = document.querySelector(window.location.hash);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
            element.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
            setTimeout(() => {
                element.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
            }, 3000);
        }
    }
});
</script>

<!-- AJAX Donation Modal -->
<div id="donationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Quick Donate</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="donationForm" class="space-y-4">
                @csrf
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount ($)</label>
                    <input type="number" id="amount" name="amount" min="1" step="0.01" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="donor_name" class="block text-sm font-medium text-gray-700">Your Name</label>
                    <input type="text" id="donor_name" name="donor_name" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ auth()->user()->name ?? '' }}">
                </div>
                
                <div>
                    <label for="donor_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="donor_email" name="donor_email" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           value="{{ auth()->user()->email ?? '' }}">
                </div>
                
                <div class="form-check">
                    <input type="checkbox" id="anonymous" name="anonymous" value="1"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="anonymous" class="ml-2 text-sm text-gray-700">Make this donation anonymous</label>
                </div>
                
                @if($campaign->rewards->isNotEmpty())
                <div>
                    <label for="reward_id" class="block text-sm font-medium text-gray-700">Select Reward (Optional)</label>
                    <select id="reward_id" name="reward_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">No reward</option>
                        @foreach($campaign->rewards as $reward)
                            <option value="{{ $reward->id }}" data-amount="{{ $reward->minimum_amount }}">
                                ${{ number_format($reward->minimum_amount, 2) }} - {{ $reward->title }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Selecting a reward will set the minimum amount required</p>
                </div>
                @endif
                
                <div id="errorMessages" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"></div>
                <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"></div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelDonation" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" id="submitDonation" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span id="submitText">Donate Now</span>
                        <span id="submitSpinner" class="hidden">Processing...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// AJAX Donation Modal Functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('donationModal');
    const quickDonateBtn = document.getElementById('quickDonateBtn');
    const closeModalBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelDonation');
    const donationForm = document.getElementById('donationForm');
    const rewardSelect = document.getElementById('reward_id');
    const amountInput = document.getElementById('amount');
    
    // Open modal
    if (quickDonateBtn) {
        quickDonateBtn.addEventListener('click', function(e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            amountInput.focus();
        });
    }
    
    // Close modal
    function closeModal() {
        modal.classList.add('hidden');
        donationForm.reset();
        hideMessages();
    }
    
    closeModalBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    
    // Handle reward selection - update minimum amount
    if (rewardSelect) {
        rewardSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.dataset.amount) {
                const minAmount = parseFloat(selectedOption.dataset.amount);
                amountInput.min = minAmount;
                if (parseFloat(amountInput.value) < minAmount) {
                    amountInput.value = minAmount;
                }
            } else {
                amountInput.min = 1;
            }
        });
    }
    
    // Handle form submission
    donationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitDonation');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        
        // Show loading state
        submitBtn.disabled = true;
        submitText.classList.add('hidden');
        submitSpinner.classList.remove('hidden');
        hideMessages();
        
        // Prepare form data
        const formData = new FormData(this);
        
        // Make AJAX request
        fetch(`/api/campaigns/{{ $campaign->id }}/donate`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccess(data.message);
                updateCampaignProgress(data.data);
                
                // Reset form and close modal after short delay
                setTimeout(() => {
                    closeModal();
                    location.reload(); // Refresh to show updated totals
                }, 2000);
            } else {
                showErrors(data.errors || [data.message || 'An error occurred']);
            }
        })
        .catch(error => {
            console.error('Donation error:', error);
            showErrors(['Network error. Please try again.']);
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitSpinner.classList.add('hidden');
        });
    });
    
    function showErrors(errors) {
        const errorDiv = document.getElementById('errorMessages');
        if (Array.isArray(errors)) {
            errorDiv.innerHTML = errors.map(error => `<div>${error}</div>`).join('');
        } else {
            errorDiv.innerHTML = `<div>${errors}</div>`;
        }
        errorDiv.classList.remove('hidden');
    }
    
    function showSuccess(message) {
        const successDiv = document.getElementById('successMessage');
        successDiv.innerHTML = `<div>${message}</div>`;
        successDiv.classList.remove('hidden');
    }
    
    function hideMessages() {
        document.getElementById('errorMessages').classList.add('hidden');
        document.getElementById('successMessage').classList.add('hidden');
    }
    
    function updateCampaignProgress(donation) {
        // Update progress bar and amounts in real-time
        const progressBar = document.querySelector('.bg-blue-600');
        const raisedAmount = document.querySelector('[data-raised-amount]');
        
        if (progressBar && raisedAmount) {
            // This would require updating the campaign totals
            // For now, we'll just show success and reload
            console.log('Donation successful:', donation);
        }
    }
});
</script>

@endsection