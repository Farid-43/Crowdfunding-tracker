@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Campaign Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/3">
                    @if($campaign->image_path)
                        <img src="{{ $campaign->image_path }}" alt="{{ $campaign->title }}" class="w-full h-48 object-cover rounded-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif
                </div>
                <div class="md:w-2/3">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Support: {{ $campaign->title }}</h1>
                    <p class="text-gray-600 mb-4">{{ $campaign->short_description }}</p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>${{ number_format($campaign->current_amount) }} raised</span>
                            <span>${{ number_format($campaign->goal_amount) }} goal</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $campaign->progress_percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500 mt-1">
                            <span>{{ $campaign->progress_percentage }}% funded</span>
                            <span>{{ $campaign->days_remaining }} days left</span>
                        </div>
                    </div>

                    <div class="flex gap-4 text-sm text-gray-600">
                        <span><strong>{{ $campaign->backers_count }}</strong> backers</span>
                        <span><strong>{{ $campaign->category }}</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Donation Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Make a Donation</h2>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('donations.store', $campaign) }}" class="space-y-6">
                @csrf

                <!-- Amount Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Choose your donation amount</label>
                    
                    <!-- Preset Amounts -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <button type="button" class="preset-amount bg-gray-100 hover:bg-blue-100 border-2 border-gray-200 hover:border-blue-500 rounded-lg p-4 text-center transition duration-200" data-amount="25">
                            <div class="text-lg font-bold text-gray-900">$25</div>
                            <div class="text-xs text-gray-500">Supporter</div>
                        </button>
                        <button type="button" class="preset-amount bg-gray-100 hover:bg-blue-100 border-2 border-gray-200 hover:border-blue-500 rounded-lg p-4 text-center transition duration-200" data-amount="50">
                            <div class="text-lg font-bold text-gray-900">$50</div>
                            <div class="text-xs text-gray-500">Contributor</div>
                        </button>
                        <button type="button" class="preset-amount bg-gray-100 hover:bg-blue-100 border-2 border-gray-200 hover:border-blue-500 rounded-lg p-4 text-center transition duration-200" data-amount="100">
                            <div class="text-lg font-bold text-gray-900">$100</div>
                            <div class="text-xs text-gray-500">Backer</div>
                        </button>
                        <button type="button" class="preset-amount bg-gray-100 hover:bg-blue-100 border-2 border-gray-200 hover:border-blue-500 rounded-lg p-4 text-center transition duration-200" data-amount="250">
                            <div class="text-lg font-bold text-gray-900">$250</div>
                            <div class="text-xs text-gray-500">Sponsor</div>
                        </button>
                    </div>

                    <!-- Custom Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Or enter a custom amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" name="amount" id="amount" min="1" max="100000" step="0.01" 
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" 
                                   placeholder="0.00" value="{{ old('amount') }}">
                        </div>
                    </div>
                </div>

                <!-- Personal Information (for guests) -->
                @guest
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="donor_name" class="block text-sm font-medium text-gray-700">Your Name *</label>
                        <input type="text" name="donor_name" id="donor_name" required 
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                               value="{{ old('donor_name') }}">
                    </div>
                    <div>
                        <label for="donor_email" class="block text-sm font-medium text-gray-700">Your Email *</label>
                        <input type="email" name="donor_email" id="donor_email" required 
                               class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                               value="{{ old('donor_email') }}">
                    </div>
                </div>
                @endguest

                <!-- Authenticated user can override their name -->
                @auth
                <div>
                    <label for="donor_name" class="block text-sm font-medium text-gray-700">Display Name (optional)</label>
                    <input type="text" name="donor_name" id="donor_name" 
                           class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                           placeholder="{{ auth()->user()->name }}" value="{{ old('donor_name') }}">
                    <p class="mt-1 text-sm text-gray-500">Leave blank to use your account name</p>
                </div>
                @endauth

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message (optional)</label>
                    <textarea name="message" id="message" rows="3" 
                              class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" 
                              placeholder="Leave a message of support...">{{ old('message') }}</textarea>
                </div>

                <!-- Anonymous Option -->
                <div class="flex items-center">
                    <input type="hidden" name="anonymous" value="0">
                    <input type="checkbox" name="anonymous" id="anonymous" value="1" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                           {{ old('anonymous') ? 'checked' : '' }}>
                    <label for="anonymous" class="ml-2 block text-sm text-gray-700">
                        Make this donation anonymous (your name won't be displayed publicly)
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="text-gray-600 hover:text-gray-800">
                        ← Back to Campaign
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                        Donate Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const presetButtons = document.querySelectorAll('.preset-amount');
    const amountInput = document.getElementById('amount');

    presetButtons.forEach(button => {
        button.addEventListener('click', function() {
            const amount = this.dataset.amount;
            amountInput.value = amount;
            
            // Update button styles
            presetButtons.forEach(btn => {
                btn.classList.remove('bg-blue-100', 'border-blue-500');
                btn.classList.add('bg-gray-100', 'border-gray-200');
            });
            
            this.classList.remove('bg-gray-100', 'border-gray-200');
            this.classList.add('bg-blue-100', 'border-blue-500');
        });
    });

    // Clear preset selection when custom amount is entered
    amountInput.addEventListener('input', function() {
        presetButtons.forEach(btn => {
            btn.classList.remove('bg-blue-100', 'border-blue-500');
            btn.classList.add('bg-gray-100', 'border-gray-200');
        });
    });
});
</script>
@endsection