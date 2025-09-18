<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Campaign creation and editing requires authentication (must come before resource routes)
Route::middleware('auth')->group(function () {
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');
});

// Campaign deletion - Admin only
Route::middleware(['auth', 'admin'])->group(function () {
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/campaigns', [AdminController::class, 'campaigns'])->name('admin.campaigns');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
});

// Campaign resource routes (public routes)
Route::resource('campaigns', CampaignController::class)->only(['index', 'show']);

// Logout page
Route::get('/logout-page', function () {
    return view('logout');
})->name('logout.page');

// GET logout route for convenience
Route::get('/logout-now', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/')->with('status', 'You have been logged out successfully.');
})->middleware('auth')->name('logout.get');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/test', function () {
        return '<h1>🎉 Admin Access Granted!</h1><p>You are logged in as: ' . auth()->user()->name . ' (Role: ' . auth()->user()->role . ')</p>';
    })->name('admin.test');
});

// Test Campaign models and relationships
Route::get('/test-campaigns', function () {
    $campaigns = \App\Models\Campaign::with('user')->take(5)->get();
    
    $html = '<h1>🎯 Campaign Models Test</h1>';
    
    foreach ($campaigns as $campaign) {
        $html .= '<div style="border:1px solid #ccc; margin:10px; padding:15px;">';
        $html .= '<h3>' . $campaign->title . '</h3>';
        $html .= '<p><strong>Creator:</strong> ' . $campaign->user->name . '</p>';
        $html .= '<p><strong>Goal:</strong> $' . number_format($campaign->goal_amount, 2) . '</p>';
        $html .= '<p><strong>Raised:</strong> $' . number_format($campaign->current_amount, 2) . '</p>';
        $html .= '<p><strong>Progress:</strong> ' . $campaign->progress_percentage . '%</p>';
        $html .= '<p><strong>Days Remaining:</strong> ' . $campaign->days_remaining . '</p>';
        $html .= '<p><strong>Status:</strong> ' . $campaign->status . '</p>';
        $html .= '<p><strong>Category:</strong> ' . $campaign->category . '</p>';
        $html .= '</div>';
    }
    
    // Test User→Campaign relationship
    $html .= '<h2>👤 User→Campaign Relationships</h2>';
    $users = \App\Models\User::with('campaigns')->whereIn('email', ['admin@crowdfunder.com', 'user@crowdfunder.com'])->get();
    
    foreach ($users as $user) {
        $html .= '<div style="border:2px solid #007acc; margin:10px; padding:15px;">';
        $html .= '<h3>' . $user->name . ' (' . $user->email . ')</h3>';
        $html .= '<p><strong>Role:</strong> ' . $user->role . '</p>';
        $html .= '<p><strong>Campaigns Created:</strong> ' . $user->campaigns->count() . '</p>';
        
        foreach ($user->campaigns->take(3) as $campaign) {
            $html .= '<p style="margin-left:20px;">• ' . $campaign->title . ' ($' . number_format($campaign->goal_amount) . ' goal)</p>';
        }
        
        $html .= '</div>';
    }
    
    // Quick verification of user names
    $html .= '<h2>✅ User Name Verification</h2>';
    $admin = \App\Models\User::where('email', 'admin@crowdfunder.com')->first();
    $user = \App\Models\User::where('email', 'user@crowdfunder.com')->first();
    $html .= '<p><strong>Admin user name:</strong> ' . $admin->name . '</p>';
    $html .= '<p><strong>Regular user name:</strong> ' . $user->name . '</p>';
    
    return $html;
})->name('test.campaigns');

require __DIR__.'/auth.php';
