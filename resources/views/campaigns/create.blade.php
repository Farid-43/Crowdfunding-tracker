@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Create Your Campaign</h1>
            <p class="text-gray-600 mt-2">Tell the world about your amazing project</p>
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

        <form method="POST" action="{{ route('campaigns.store') }}" class="space-y-6">
            @csrf

            <!-- Campaign Image URL -->
            <div>
                <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Image URL (Optional)
                </label>
                <input type="url" 
                       id="image_url" 
                       name="image_url" 
                       value="{{ old('image_url') }}"
                       placeholder="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=800"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror"
                       onchange="previewImageUrl(this.value)">
                
                <!-- Image Preview -->
                <div id="image-preview" class="hidden mt-4">
                    <div class="relative inline-block">
                        <img id="preview-img" src="" alt="Preview" class="max-w-xs max-h-48 rounded-lg shadow-md object-cover">
                        <button type="button" onclick="removeImageUrl()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                            ×
                        </button>
                    </div>
                </div>
                
                @error('image_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-sm mt-1">
                    Add a link to an image to make your campaign stand out. Try 
                    <a href="https://unsplash.com" target="_blank" class="text-blue-600 hover:underline">Unsplash</a> for free images.
                    <br>
                    <span class="text-xs">Example: https://images.unsplash.com/photo-1533090161767-e6ffed986c88?w=800</span>
                </p>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Title *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
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
                          required>{{ old('short_description') }}</textarea>
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
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Goal Amount and Legacy Category Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Goal Amount -->
                <div>
                    <label for="goal_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Funding Goal ($) *
                    </label>
                    <input type="number" 
                           id="goal_amount" 
                           name="goal_amount" 
                           value="{{ old('goal_amount') }}"
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

                <!-- Legacy Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Legacy Category (Optional)
                    </label>
                    <select id="category" 
                            name="category" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('category') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Art" {{ old('category') == 'Art' ? 'selected' : '' }}>Art</option>
                        <option value="Music" {{ old('category') == 'Music' ? 'selected' : '' }}>Music</option>
                        <option value="Film" {{ old('category') == 'Film' ? 'selected' : '' }}>Film</option>
                        <option value="Games" {{ old('category') == 'Games' ? 'selected' : '' }}>Games</option>
                        <option value="Publishing" {{ old('category') == 'Publishing' ? 'selected' : '' }}>Publishing</option>
                        <option value="Fashion" {{ old('category') == 'Fashion' ? 'selected' : '' }}>Fashion</option>
                        <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                        <option value="Health" {{ old('category') == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Education" {{ old('category') == 'Education' ? 'selected' : '' }}>Education</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- New Categories Selection (Full Width) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Categories * (Required)
                </label>
                <p class="text-gray-500 text-sm mb-3">Select up to 3 categories that best describe your campaign</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @forelse($categories as $category)
                    <label class="relative flex items-start p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg cursor-pointer transition duration-200">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="{{ $category->id }}" 
                               class="category-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1"
                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
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
                    @empty
                    <div class="col-span-full p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-yellow-700">No categories available. Please contact the administrator.</p>
                    </div>
                    @endforelse
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

            <!-- Deadline -->
            <div>
                <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Deadline *
                </label>
                <input type="date" 
                       id="deadline" 
                       name="deadline" 
                       value="{{ old('deadline') }}"
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
                    Create Campaign
                </button>
                <a href="{{ route('campaigns.index') }}" 
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg transition duration-200 text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Category limit enforcement and required validation
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const warningDiv = document.getElementById('category-limit-warning');
    const form = document.querySelector('form');
    const maxCategories = 3;

    // Form submission validation
    form.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
        
        if (checkedCount === 0) {
            e.preventDefault();
            alert('Please select at least one category for your campaign.');
            // Scroll to categories section
            document.querySelector('.category-checkbox').closest('div').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
        
        if (checkedCount > maxCategories) {
            e.preventDefault();
            alert(`Please select maximum ${maxCategories} categories.`);
            return false;
        }
    });

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