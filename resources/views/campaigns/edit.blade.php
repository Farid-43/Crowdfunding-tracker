@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Campaign</h1>
            <p class="text-gray-600 mt-2">Update your campaign details</p>
        </div>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="text-red-400">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

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

        <form method="POST" action="{{ route('campaigns.update', $campaign) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Campaign Image URL -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Image URL (Optional)
                </label>
                <input type="url" 
                       id="image_url" 
                       name="image_url" 
                       value="{{ old('image_url', $campaign->image_path) }}"
                       placeholder="https://example.com/your-campaign-image.jpg"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror"
                       onchange="previewImageUrl(this.value)">
                
                <!-- Image Preview -->
                <div id="image-preview" class="{{ $campaign->image_path ? '' : 'hidden' }} mt-4">
                    <div class="relative inline-block">
                        <img id="preview-img" src="{{ $campaign->image_path }}" alt="Preview" class="max-w-xs max-h-48 rounded-lg shadow-md object-cover">
                        <button type="button" onclick="removeImageUrl()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                            ×
                        </button>
                    </div>
                </div>
                
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Add a link to an image to make your campaign stand out (optional)</p>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Title *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $campaign->title) }}"
                       placeholder="Enter a compelling title for your campaign"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Short Description *
                </label>
                <textarea id="short_description" 
                          name="short_description" 
                          rows="3"
                          placeholder="A brief summary of your campaign (max 500 characters)"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('short_description') border-red-500 @enderror"
                          maxlength="500"
                          required>{{ old('short_description', $campaign->short_description) }}</textarea>
                @error('short_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">This will appear on campaign cards and search results</p>
            </div>

            <!-- Full Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Description *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="8"
                          placeholder="Tell your story! Explain your project, why it matters, and how funds will be used (minimum 100 characters)"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                          required>{{ old('description', $campaign->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Goal Amount and Category Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goal Amount -->
                <div>
                    <label for="goal_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Funding Goal ($) *
                    </label>
                    <input type="number" 
                           id="goal_amount" 
                           name="goal_amount" 
                           value="{{ old('goal_amount', $campaign->goal_amount) }}"
                           placeholder="10000"
                           min="100"
                           max="1000000"
                           step="1"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('goal_amount') border-red-500 @enderror"
                           required>
                    @error('goal_amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-sm mt-1">Minimum $100, Maximum $1,000,000</p>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Category *
                    </label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror"
                            required>
                        <option value="">Select a category</option>
                        <option value="Technology" {{ old('category', $campaign->category) == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Art" {{ old('category', $campaign->category) == 'Art' ? 'selected' : '' }}>Art</option>
                        <option value="Music" {{ old('category', $campaign->category) == 'Music' ? 'selected' : '' }}>Music</option>
                        <option value="Film" {{ old('category', $campaign->category) == 'Film' ? 'selected' : '' }}>Film</option>
                        <option value="Games" {{ old('category', $campaign->category) == 'Games' ? 'selected' : '' }}>Games</option>
                        <option value="Publishing" {{ old('category', $campaign->category) == 'Publishing' ? 'selected' : '' }}>Publishing</option>
                        <option value="Fashion" {{ old('category', $campaign->category) == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Food" {{ old('category', $campaign->category) == 'Food' ? 'selected' : '' }}>Food</option>
                        <option value="Health" {{ old('category', $campaign->category) == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Education" {{ old('category', $campaign->category) == 'Education' ? 'selected' : '' }}>Education</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Categories Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Additional Categories (Optional)
                    </label>
                    <p class="text-gray-500 text-sm mb-3">Select up to 3 categories that best describe your campaign</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($categories as $category)
                        <label class="relative flex items-start p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg cursor-pointer transition duration-200">
                            <input type="checkbox" 
                                   name="categories[]" 
                                   value="{{ $category->id }}" 
                                   class="category-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                                   {{ in_array($category->id, old('categories', $campaign->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <div class="ml-3 flex-grow">
                                <div class="flex items-center">
                                    @if($category->icon)
                                    <i class="{{ $category->icon }} mr-2" style="color: {{ $category->color }}"></i>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                </div>
                                @if($category->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $category->description }}</p>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                    
                    <div id="category-limit-warning" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-yellow-700 text-sm">
                        You can select a maximum of 3 categories.
                    </div>
                    
                    @error('categories')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('categories.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deadline -->
            <div>
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Deadline *
                </label>
                <input type="date" 
                       id="deadline" 
                       name="deadline" 
                       value="{{ old('deadline', $campaign->deadline) }}"
                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                       max="{{ date('Y-m-d', strtotime('+1 year')) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deadline') border-red-500 @enderror"
                       required>
                @error('deadline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">Campaign must run for at least 1 day, maximum 1 year</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-6">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    Update Campaign
                </button>
                <a href="{{ route('campaigns.show', $campaign) }}" 
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Category limit enforcement
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const warningDiv = document.getElementById('category-limit-warning');
    const maxCategories = 3;

    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
            
            if (checkedCount >= maxCategories) {
                // Disable unchecked boxes
                categoryCheckboxes.forEach(cb => {
                    if (!cb.checked) {
                        cb.disabled = true;
                        cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
                warningDiv.classList.remove('hidden');
            } else {
                // Enable all boxes
                categoryCheckboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
                });
                warningDiv.classList.add('hidden');
            }
        });
    });
    
    // Initial check
    const initialCheckedCount = document.querySelectorAll('.category-checkbox:checked').length;
    if (initialCheckedCount >= maxCategories) {
        categoryCheckboxes.forEach(cb => {
            if (!cb.checked) {
                cb.disabled = true;
                cb.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
        warningDiv.classList.remove('hidden');
    }
});

function previewImageUrl(url) {
    if (url && url.trim() !== '') {
        const img = document.getElementById('preview-img');
        const preview = document.getElementById('image-preview');
        
        // Test if the URL loads a valid image
        const testImg = new Image();
        testImg.onload = function() {
            img.src = url;
            preview.classList.remove('hidden');
        };
        testImg.onerror = function() {
            // Hide preview if image fails to load
            preview.classList.add('hidden');
        };
        testImg.src = url;
    } else {
        document.getElementById('image-preview').classList.add('hidden');
    }
}

function removeImageUrl() {
    document.getElementById('image_url').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('preview-img').src = '';
}
</script>
@endsection