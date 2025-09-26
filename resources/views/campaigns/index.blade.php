@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">All Campaigns</h1>
            <p class="text-gray-600 mt-2">Discover and support amazing projects</p>
        </div>
        @auth
            <a href="{{ route('campaigns.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                Create Campaign
            </a>
        @endauth
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('campaigns.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                <!-- Search Input -->
                <div class="lg:col-span-4">
                    <label for="search" class="flex items-center text-sm font-medium text-gray-700 mb-2">
                        <svg class="h-4 w-4 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Campaigns
                    </label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Search by title or description..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Category Filter -->
                <div class="lg:col-span-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                    <div class="relative" x-data="{ open: false, selectedCategories: {{ json_encode($filters['categories'] ?? []) }} }">
                        <!-- Category Dropdown Button -->
                        <button type="button" 
                                @click="open = !open"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-white text-left focus:ring-2 focus:ring-blue-500 focus:border-blue-500 flex items-center justify-between">
                            <span class="block truncate">
                                <span x-show="selectedCategories.length === 0" class="text-gray-500">Select categories...</span>
                                <span x-show="selectedCategories.length > 0" x-text="selectedCategories.length + ' categor' + (selectedCategories.length === 1 ? 'y' : 'ies') + ' selected'"></span>
                            </span>
                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" 
                                 :class="{ 'rotate-180': open }" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Category Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                            
                            <!-- Select All / Clear All -->
                            <div class="px-3 py-2 border-b border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <button type="button" 
                                            @click="selectedCategories = {{ json_encode($categories->pluck('id')->toArray()) }}"
                                            class="text-sm text-blue-600 hover:text-blue-800">
                                        Select All
                                    </button>
                                    <button type="button" 
                                            @click="selectedCategories = []"
                                            class="text-sm text-gray-600 hover:text-gray-800">
                                        Clear All
                                    </button>
                                </div>
                            </div>

                            <!-- Category Options -->
                            @foreach($categories as $category)
                                <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           :checked="selectedCategories.includes({{ $category->id }})"
                                           @change="if ($event.target.checked) { 
                                                        if (!selectedCategories.includes({{ $category->id }})) {
                                                            selectedCategories.push({{ $category->id }});
                                                        }
                                                    } else { 
                                                        selectedCategories = selectedCategories.filter(id => id !== {{ $category->id }});
                                                    }"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <div class="ml-3 flex items-center flex-1">
                                        <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }};"></span>
                                        <span class="text-sm text-gray-900">{{ $category->name }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Click to select multiple categories</p>
                </div>

                <!-- Sort Options -->
                <div class="lg:col-span-3">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select id="sort" 
                            name="sort" 
                            class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="featured_and_date" {{ ($filters['sort'] ?? '') == 'featured_and_date' ? 'selected' : '' }}>Featured & Newest</option>
                        <option value="newest" {{ ($filters['sort'] ?? '') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ ($filters['sort'] ?? '') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="goal_high" {{ ($filters['sort'] ?? '') == 'goal_high' ? 'selected' : '' }}>Highest Goal</option>
                        <option value="goal_low" {{ ($filters['sort'] ?? '') == 'goal_low' ? 'selected' : '' }}>Lowest Goal</option>
                        <option value="ending_soon" {{ ($filters['sort'] ?? '') == 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="lg:col-span-1 flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
                        Search
                    </button>
                </div>
            </div>

            <!-- Active Filters Display -->
            @if(!empty($filters['search']) || !empty($filters['categories']) || ($filters['sort'] ?? '') != 'featured_and_date')
                <div class="border-t pt-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Active filters:</span>
                        
                        @if(!empty($filters['search']))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Search: "{{ $filters['search'] }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-2 text-blue-600 hover:text-blue-800">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </span>
                        @endif

                        @if(!empty($filters['categories']))
                            @foreach($categories->whereIn('id', $filters['categories']) as $selectedCategory)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium" 
                                      style="background-color: {{ $selectedCategory->color }}20; color: {{ $selectedCategory->color }};">
                                    {{ $selectedCategory->name }}
                                    <a href="{{ request()->fullUrlWithQuery(['categories' => array_diff($filters['categories'], [$selectedCategory->id])]) }}" 
                                       class="ml-2 hover:opacity-80">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                </span>
                            @endforeach
                        @endif

                        @if(($filters['sort'] ?? '') != 'featured_and_date')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Sort: {{ ucwords(str_replace('_', ' ', $filters['sort'])) }}
                                <a href="{{ request()->fullUrlWithQuery(['sort' => null]) }}" class="ml-2 text-gray-600 hover:text-gray-800">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </span>
                        @endif

                        <a href="{{ route('campaigns.index') }}" 
                           class="inline-flex items-center px-3 py-1 text-xs font-medium text-gray-600 hover:text-gray-800 border border-gray-300 rounded-full hover:bg-gray-50">
                            Clear all
                        </a>
                    </div>
                </div>
            @endif
        </form>
    </div>

    <!-- Results Summary -->
    <div class="flex justify-between items-center mb-6">
        <div>
            @if(!empty($filters['search']) || !empty($filters['categories']))
                <p class="text-gray-600">
                    Found {{ $campaigns->total() }} campaign{{ $campaigns->total() != 1 ? 's' : '' }}
                    @if(!empty($filters['search']))
                        for "<strong>{{ $filters['search'] }}</strong>"
                    @endif
                    @if(!empty($filters['categories']))
                        in selected categories
                    @endif
                </p>
            @else
                <p class="text-gray-600">Showing {{ $campaigns->total() }} campaigns</p>
            @endif
        </div>
    </div>

    <!-- Display success message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
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

    <!-- Campaign Grid -->
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($campaigns as $campaign)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200 flex flex-col h-full">
                    <!-- Campaign Image - Fixed Height -->
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center flex-shrink-0">
                        @if($campaign->image_path)
                            <img src="{{ $campaign->image_path }}" 
                                 alt="{{ $campaign->title }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="text-white text-lg font-semibold hidden items-center justify-center w-full h-full">{{ $campaign->category }}</span>
                        @else
                            <span class="text-white text-lg font-semibold">{{ $campaign->category }}</span>
                        @endif
                    </div>
                    
                    <!-- Campaign Content -->
                    <div class="p-6 flex flex-col flex-grow">
                        <!-- Featured Badge -->
                        @if($campaign->featured)
                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mb-3 self-start">
                                ⭐ Featured
                            </span>
                        @endif
                        
                        <!-- Title - Natural height with more space -->
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 leading-tight">
                            {{ $campaign->title }}
                        </h3>
                        
                        <!-- Short Description - Natural height -->
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed flex-grow">
                            {{ $campaign->short_description }}
                        </p>
                        
                        <!-- Bottom section always at bottom -->
                        <div class="mt-auto">
                            <!-- Creator -->
                            <p class="text-xs text-gray-500 mb-2">
                                by <span class="font-medium">{{ $campaign->user->name }}</span>
                            </p>
                            
                            <!-- Categories -->
                            @if($campaign->categories->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-4">
                                @foreach($campaign->categories->take(2) as $category)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium border"
                                      style="background-color: {{ $category->color }}15; border-color: {{ $category->color }}; color: {{ $category->color }};">
                                    @if($category->icon)
                                    <i class="{{ $category->icon }} mr-1 text-xs"></i>
                                    @endif
                                    {{ $category->name }}
                                </span>
                                @endforeach
                                @if($campaign->categories->count() > 2)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    +{{ $campaign->categories->count() - 2 }} more
                                </span>
                                @endif
                            </div>
                            @endif
                            
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>${{ number_format($campaign->current_amount) }} raised</span>
                                    <span>{{ $campaign->progress_percentage }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" 
                                         style="width: {{ min(100, $campaign->progress_percentage) }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Campaign Stats -->
                            <div class="flex justify-between text-sm text-gray-600 mb-4">
                                <span>${{ number_format($campaign->goal_amount) }} goal</span>
                                <span>{{ $campaign->days_remaining }} days left</span>
                            </div>
                            
                            <!-- View Button -->
                            <a href="{{ route('campaigns.show', $campaign) }}" 
                               class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded transition duration-200">
                                View Campaign
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    @if(!empty($filters['search']) || !empty($filters['categories']))
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    @else
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    @endif
                </div>
                
                @if(!empty($filters['search']) || !empty($filters['categories']))
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns found</h3>
                    <p class="text-gray-600 mb-4">
                        We couldn't find any campaigns matching your search criteria. 
                        Try adjusting your filters or search terms.
                    </p>
                    <div class="space-y-2">
                        <a href="{{ route('campaigns.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                            View All Campaigns
                        </a>
                        <br>
                        <button onclick="document.getElementById('search').value=''; document.querySelector('form').submit();" 
                                class="text-blue-600 hover:text-blue-800 text-sm">
                            Clear search and try again
                        </button>
                    </div>
                @else
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No campaigns yet</h3>
                    <p class="text-gray-600 mb-4">Be the first to create a campaign and start fundraising!</p>
                    @auth
                        <a href="{{ route('campaigns.create') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-200">
                            Create First Campaign
                        </a>
                    @else
                        <p class="text-sm text-gray-500">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in</a> to create a campaign
                        </p>
                    @endauth
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when sort changes
    const sortSelect = document.getElementById('sort');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Enhanced category selection with new dropdown
    // Auto-submit when categories change with delay
    let categorySubmitTimeout;
    document.addEventListener('change', function(e) {
        if (e.target.name === 'categories[]') {
            clearTimeout(categorySubmitTimeout);
            categorySubmitTimeout = setTimeout(() => {
                e.target.form.submit();
            }, 800); // Longer delay for multiple selections
        }
    });

    // Search input enhancements
    const searchInput = document.getElementById('search');
    if (searchInput) {
        // Add live search with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            // Show loading state
            const form = this.form;
            const submitBtn = form.querySelector('button[type="submit"]');
            
            if (this.value.length >= 3 || this.value.length === 0) {
                searchTimeout = setTimeout(() => {
                    form.submit();
                }, 1000); // 1 second delay
            }
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Focus search with Ctrl+F or Cmd+F (when not in input)
        if ((e.ctrlKey || e.metaKey) && e.key === 'f' && e.target.tagName !== 'INPUT') {
            e.preventDefault();
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }
        
        // Clear filters with Escape
        if (e.key === 'Escape') {
            const activeFilters = document.querySelector('.border-t');
            if (activeFilters) {
                window.location.href = '{{ route("campaigns.index") }}';
            }
        }
    });

    // Enhanced filter chips interaction
    document.querySelectorAll('.inline-flex.items-center.px-3.py-1.rounded-full').forEach(chip => {
        chip.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        chip.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Loading states for better UX
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Searching...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
@endpush

@endsection