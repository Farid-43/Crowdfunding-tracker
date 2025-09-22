@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <nav class="text-sm breadcrumbs mb-4">
            <a href="{{ route('campaigns.index') }}" class="text-blue-600 hover:text-blue-800">Campaigns</a>
            <span class="mx-2 text-gray-500">›</span>
            <a href="{{ route('campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-800">{{ Str::limit($campaign->title, 30) }}</a>
            <span class="mx-2 text-gray-500">›</span>
            <span class="text-gray-700">Comments</span>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900">Comments & Discussion</h1>
        <p class="text-gray-600 mt-2">
            All comments for <strong>{{ $campaign->title }}</strong>
        </p>
    </div>

    <!-- Campaign Summary -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $campaign->title }}</h2>
                <p class="text-gray-600 mt-1">by {{ $campaign->user->name }}</p>
                <div class="flex items-center mt-2 text-sm text-gray-600">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ ucfirst($campaign->category) }}</span>
                    <span class="mx-2">•</span>
                    <span>${{ number_format($campaign->current_amount) }} raised of ${{ number_format($campaign->goal_amount) }}</span>
                </div>
            </div>
            <div class="text-right">
                <a href="{{ route('campaigns.show', $campaign) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition duration-200">
                    View Campaign
                </a>
            </div>
        </div>
    </div>

    @auth
        <!-- Comment Form -->
        <div class="mb-8 bg-white border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Your Comment</h3>
            
            <form action="{{ route('comments.store', $campaign) }}" method="POST">
                @csrf
                <div class="mb-4">
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

    <!-- Comments -->
    <div class="space-y-6">
        @forelse($comments as $comment)
            <div class="bg-white border border-gray-200 rounded-lg p-6" id="comment-{{ $comment->id }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4 flex-1">
                        <!-- User Avatar -->
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
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
                            
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $comment->content }}</p>
                            
                            <div class="flex items-center mt-4 text-sm text-gray-500">
                                <span>{{ $comment->created_at->format('M j, Y \a\t g:i A') }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                                @if($comment->is_edited)
                                    <span class="mx-2">•</span>
                                    <span class="italic">Edited {{ $comment->edited_at->diffForHumans() }}</span>
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
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium"
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
                                        class="text-yellow-600 hover:text-yellow-800 text-sm font-medium"
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
                                        class="text-red-600 hover:text-red-800 text-sm font-medium"
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
                        <div id="edit-form-{{ $comment->id }}" class="hidden mt-6 pl-16">
                            <form action="{{ route('comments.update', $comment) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="border-t pt-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Edit your comment:</label>
                                    <textarea
                                        name="content"
                                        rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        maxlength="1000"
                                    >{{ $comment->content }}</textarea>
                                    
                                    <div class="flex justify-end space-x-3 mt-4">
                                        <button
                                            type="button"
                                            onclick="toggleEditComment({{ $comment->id }})"
                                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium transition duration-200"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm font-medium transition duration-200"
                                        >
                                            Update Comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        @empty
            <div class="text-center py-16 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No comments yet</h3>
                <p class="text-gray-600 mb-6">Be the first to share your thoughts about this campaign!</p>
                
                @auth
                    <button 
                        onclick="document.getElementById('content').focus()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200"
                    >
                        Write the First Comment
                    </button>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 inline-block">
                            Sign In to Comment
                        </a>
                        <a href="{{ route('register') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 inline-block">
                            Create Account
                        </a>
                    </div>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($comments->hasPages())
        <div class="mt-8">
            {{ $comments->links() }}
        </div>
    @endif

    <!-- Back to Campaign -->
    <div class="mt-8 text-center">
        <a href="{{ route('campaigns.show', $campaign) }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Campaign
        </a>
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
            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth' });
                element.classList.add('ring-2', 'ring-blue-500', 'ring-opacity-50');
                setTimeout(() => {
                    element.classList.remove('ring-2', 'ring-blue-500', 'ring-opacity-50');
                }, 3000);
            }, 100);
        }
    }
});
</script>

@endsection