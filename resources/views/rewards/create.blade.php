@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Add New Reward</h1>
                    <p class="text-gray-600 mt-2">Create a reward to motivate backers for "{{ $campaign->title }}"</p>
                </div>
                <a href="{{ route('campaigns.show', $campaign) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Back to Campaign
                </a>
            </div>
        </div>

        <!-- Reward Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('rewards.store', $campaign) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Reward Title *</label>
                    <input type="text" id="title" name="title" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                           value="{{ old('title') }}" 
                           placeholder="e.g., Early Bird Special, Limited Edition Package"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                    <textarea id="description" name="description" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror" 
                              placeholder="Describe what backers will receive with this reward"
                              required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Minimum Amount -->
                <div>
                    <label for="minimum_amount" class="block text-sm font-medium text-gray-700 mb-2">Minimum Donation Amount *</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" id="minimum_amount" name="minimum_amount" 
                               class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('minimum_amount') border-red-500 @enderror" 
                               value="{{ old('minimum_amount') }}" 
                               min="1" step="0.01" 
                               placeholder="0.00"
                               required>
                    </div>
                    @error('minimum_amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Items Included -->
                <div>
                    <label for="items_included" class="block text-sm font-medium text-gray-700 mb-2">Items Included (Optional)</label>
                    <textarea id="items_included" name="items_included" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('items_included') border-red-500 @enderror" 
                              placeholder="List each item on a new line, e.g.:&#10;Digital download&#10;Thank you email&#10;Exclusive updates">{{ old('items_included') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">List each item on a separate line. These will be displayed as bullet points to backers.</p>
                    @error('items_included')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Delivery Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Estimated Delivery -->
                    <div>
                        <label for="estimated_delivery" class="block text-sm font-medium text-gray-700 mb-2">Estimated Delivery (Optional)</label>
                        <input type="date" id="estimated_delivery" name="estimated_delivery" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('estimated_delivery') border-red-500 @enderror" 
                               value="{{ old('estimated_delivery') }}" 
                               min="{{ date('Y-m-d') }}">
                        @error('estimated_delivery')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Shipping Required -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Required</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="shipping_required" value="0" 
                                       class="form-radio text-blue-600 focus:ring-blue-500" 
                                       {{ old('shipping_required', '0') == '0' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">No (Digital/Local)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="shipping_required" value="1" 
                                       class="form-radio text-blue-600 focus:ring-blue-500" 
                                       {{ old('shipping_required') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Yes (Physical Item)</span>
                            </label>
                        </div>
                        @error('shipping_required')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Quantity Limitations -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quantity Limitations</h3>
                    
                    <div class="space-y-4">
                        <!-- Limit Quantity Checkbox -->
                        <div class="flex items-center">
                            <input type="checkbox" id="limit_quantity_checkbox" name="limit_quantity_checkbox" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ old('limit_quantity') ? 'checked' : '' }}>
                            <label for="limit_quantity_checkbox" class="ml-2 text-sm text-gray-700">
                                Limit the number of this reward available
                            </label>
                        </div>

                        <!-- Quantity Input -->
                        <div id="quantity_input" class="hidden">
                            <label for="limit_quantity" class="block text-sm font-medium text-gray-700 mb-2">Maximum Available Quantity</label>
                            <input type="number" id="limit_quantity" name="limit_quantity" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('limit_quantity') border-red-500 @enderror" 
                                   value="{{ old('limit_quantity') }}" 
                                   min="1" step="1" 
                                   placeholder="e.g., 100">
                            <p class="mt-1 text-sm text-gray-500">Leave unchecked for unlimited quantity</p>
                            @error('limit_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('campaigns.show', $campaign) }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                        Create Reward
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const limitQuantityCheckbox = document.getElementById('limit_quantity_checkbox');
    const quantityInput = document.getElementById('quantity_input');
    const quantityField = document.getElementById('limit_quantity');

    limitQuantityCheckbox.addEventListener('change', function() {
        if (this.checked) {
            quantityInput.classList.remove('hidden');
            quantityField.required = true;
        } else {
            quantityInput.classList.add('hidden');
            quantityField.required = false;
            quantityField.value = '';
        }
    });

    // Initialize based on old input
    if (limitQuantityCheckbox.checked) {
        quantityInput.classList.remove('hidden');
        quantityField.required = true;
    }
});
</script>
@endsection