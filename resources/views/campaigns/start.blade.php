@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Start Your Campaign</h1>
        <p class="text-xl text-gray-600 mb-8">Turn your ideas into reality with crowdfunding</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Ready to Launch?</h2>
                <p class="text-gray-600 mb-6">To create a campaign, you'll need to log in to your account first. This helps us keep campaigns secure and connected to their creators.</p>
                
                <div class="space-y-4">
                    <a href="{{ $loginUrl }}" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-200 text-center block">
                        Log In to Create Campaign
                    </a>
                    
                    <div class="text-center">
                        <span class="text-gray-500">Don't have an account?</span>
                        <a href="{{ $registerUrl }}" class="text-blue-600 hover:text-blue-800 font-medium ml-1">Sign up here</a>
                    </div>
                </div>
            </div>
            
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Why Create a Campaign?</h3>
                <ul class="space-y-3 text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Reach thousands of potential backers
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Easy-to-use campaign management tools
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Secure payment processing
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Track your progress with analytics
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">How It Works</h3>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <span class="text-blue-600 font-semibold">1</span>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">Create Your Campaign</h4>
                <p class="text-gray-600 text-sm">Tell your story, set your goal, and add rewards for backers.</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <span class="text-blue-600 font-semibold">2</span>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">Share & Promote</h4>
                <p class="text-gray-600 text-sm">Share your campaign with friends, family, and social networks.</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3">
                    <span class="text-blue-600 font-semibold">3</span>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">Reach Your Goal</h4>
                <p class="text-gray-600 text-sm">Collect donations and bring your project to life.</p>
            </div>
        </div>
    </div>
</div>
@endsection