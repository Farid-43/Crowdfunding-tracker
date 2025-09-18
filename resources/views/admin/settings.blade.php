@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Admin Sidebar -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-800 text-white min-h-screen">
            <div class="p-6">
                <div class="flex items-center mb-8">
                    <div class="bg-blue-600 p-2 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Dashboard</h2>
                        <p class="text-slate-400 text-sm">Welcome, {{ auth()->user()->name }}</p>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('admin.campaigns') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Campaigns
                    </a>

                    <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        Users
                    </a>

                    <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4zM4 8V6a1 1 0 011-1h2a1 1 0 011 1v2H4zM10 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4zM16 8V6a1 1 0 011-1h2a1 1 0 011 1v2h-4z"></path>
                        </svg>
                        Analytics
                    </a>

                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                        Reports
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 bg-blue-600 rounded-lg text-white">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        Settings
                    </a>

                    <a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Categories
                    </a>

                    <div class="border-t border-slate-700 my-4"></div>

                    <a href="{{ route('campaigns.index') }}" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.586 11H7a1 1 0 100-2H2.586l3.707-3.707a1 1 0 00-1.414-1.414l-5.414 5.414a1 1 0 000 1.414l5.414 5.414a1 1 0 001.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        View Site
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center px-4 py-3 text-slate-300 hover:bg-slate-700 rounded-lg transition duration-200 w-full text-left">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Platform Settings</h1>
                <p class="text-gray-600 mt-2">Configure platform-wide settings and policies</p>
            </div>

            <!-- Settings Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- General Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">General Settings</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Platform Name</p>
                                <p class="text-sm text-gray-600">Current site name and branding</p>
                            </div>
                            <span class="text-blue-600 font-semibold">{{ $settings['platform_name'] }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Maintenance Mode</p>
                                <p class="text-sm text-gray-600">Put site under maintenance</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $settings['maintenance_mode'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $settings['maintenance_mode'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">User Registration</p>
                                <p class="text-sm text-gray-600">Allow new user signups</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $settings['registration_enabled'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $settings['registration_enabled'] ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Campaign Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Campaign Settings</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Campaign Approval</p>
                                <p class="text-sm text-gray-600">Require admin approval for new campaigns</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $settings['campaign_approval_required'] ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $settings['campaign_approval_required'] ? 'Required' : 'Auto-approve' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Max Duration</p>
                                <p class="text-sm text-gray-600">Maximum campaign duration</p>
                            </div>
                            <span class="text-blue-600 font-semibold">{{ $settings['max_campaign_duration'] }} days</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Min Goal Amount</p>
                                <p class="text-sm text-gray-600">Minimum funding goal</p>
                            </div>
                            <span class="text-blue-600 font-semibold">${{ number_format($settings['min_campaign_goal']) }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Max Goal Amount</p>
                                <p class="text-sm text-gray-600">Maximum funding goal</p>
                            </div>
                            <span class="text-blue-600 font-semibold">${{ number_format($settings['max_campaign_goal']) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Content Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Content Settings</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Featured Campaigns</p>
                                <p class="text-sm text-gray-600">Number of campaigns on homepage</p>
                            </div>
                            <span class="text-blue-600 font-semibold">{{ $settings['featured_campaigns_count'] }} campaigns</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Content Moderation</p>
                                <p class="text-sm text-gray-600">Review content before publishing</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security Settings</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Two-Factor Auth</p>
                                <p class="text-sm text-gray-600">Require 2FA for admin users</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Recommended</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Session Timeout</p>
                                <p class="text-sm text-gray-600">Auto-logout inactive users</p>
                            </div>
                            <span class="text-blue-600 font-semibold">30 minutes</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-900">Password Policy</p>
                                <p class="text-sm text-gray-600">Minimum security requirements</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Strong</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <button class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition duration-200">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-900">Edit Site Settings</p>
                            <p class="text-xs text-gray-500">Modify platform configuration</p>
                        </div>
                    </button>

                    <button class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500 hover:bg-yellow-50 transition duration-200">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-900">Maintenance Mode</p>
                            <p class="text-xs text-gray-500">Enable/disable site access</p>
                        </div>
                    </button>

                    <button class="p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500 hover:bg-green-50 transition duration-200">
                        <div class="text-center">
                            <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-900">Backup System</p>
                            <p class="text-xs text-gray-500">Create system backup</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection