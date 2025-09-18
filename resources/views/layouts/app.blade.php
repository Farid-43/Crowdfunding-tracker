<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Crowdfunding Tracker')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                        💰 CrowdFunder
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        Campaigns
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                        About
                    </a>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Register
                        </a>
                    @else
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.campaigns') }}" class="text-orange-600 hover:text-orange-800 px-3 py-2 text-sm font-medium">
                                Dashboard
                            </a>
                        @endif
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700 px-3 py-2 text-sm font-medium">
                                {{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="ml-1 px-2 py-0.5 text-xs bg-orange-100 text-orange-800 rounded-full">Admin</span>
                                @endif
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.campaigns') }}" class="block px-4 py-2 text-sm text-orange-600 hover:bg-orange-50">Dashboard</a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">CrowdFunder</h3>
                    <p class="text-gray-300 text-sm">
                        Empowering dreams through collective funding. Start your campaign today!
                    </p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white">How It Works</a></li>
                        <li><a href="#" class="hover:text-white">Success Stories</a></li>
                        <li><a href="#" class="hover:text-white">Categories</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white">Help Center</a></li>
                        <li><a href="#" class="hover:text-white">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white">Safety</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white">Technology</a></li>
                        <li><a href="#" class="hover:text-white">Health</a></li>
                        <li><a href="#" class="hover:text-white">Education</a></li>
                        <li><a href="#" class="hover:text-white">Charity</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-sm text-gray-300">
                <p>&copy; {{ date('Y') }} CrowdFunder. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
