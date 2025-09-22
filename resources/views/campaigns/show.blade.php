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
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <span class="text-white text-2xl font-bold hidden items-center justify-center w-full h-full absolute inset-0">{{ $campaign->category }}</span>
            @else
                <span class="text-white text-2xl font-bold">{{ $campaign->category }}</span>
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
                <p class="text-gray-600">
                    by <span class="font-semibold text-blue-600">{{ $campaign->user->name }}</span>
                    <span class="text-gray-400">•</span>
                    <span class="text-sm">{{ $campaign->category }}</span>
                </p>
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
                        <!-- Donate Button for Active Campaigns -->
                        <a href="{{ route('donations.create', $campaign) }}" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                            💚 Donate Now
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

@endsection