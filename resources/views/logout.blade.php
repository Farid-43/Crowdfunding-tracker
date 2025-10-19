@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-16 p-6 bg-white rounded-lg shadow-md">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Logout</h2>
        <p class="text-gray-600 mb-6">Choose how you'd like to logout from your account.</p>
        
        <!-- Standard POST logout (recommended) -->
        <form method="POST" action="{{ route('logout') }}" class="mb-4">
            @csrf
            <button type="submit" 
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Logout Now (POST)
            </button>
        </form>
        
        <!-- Alternative GET logout -->
        <a href="{{ route('logout.get') }}" 
           class="block w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">
            Quick Logout (GET)
        </a>
        
        <a href="{{ route('home') }}" 
           class="block mt-4 text-blue-600 hover:text-blue-800 text-sm">
            Cancel and return to home
        </a>
    </div>
</div>
@endsection