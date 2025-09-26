<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Test route for categories
Route::get('/test-categories', function () {
    $categories = \App\Models\Category::active()->ordered()->get();
    $campaignsWithCategories = \App\Models\Campaign::with('categories')->take(5)->get();
    
    return view('test-categories', compact('categories', 'campaignsWithCategories'));
})->name('test.categories');

// Public campaign routes (viewing)
Route::resource('campaigns', CampaignController::class)->only(['index', 'show']);

// Donation routes (both auth and guest can donate)
Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])->name('donations.create');
Route::post('/campaigns/{campaign}/donate', [DonationController::class, 'store'])->name('donations.store');
Route::get('/campaigns/{campaign}/donations/{donation}/thankyou', [DonationController::class, 'thankyou'])->name('donations.thankyou');

// Donation history routes
Route::get('/campaigns/{campaign}/donations', [DonationController::class, 'campaignHistory'])->name('donations.campaign-history');
Route::get('/my-donations', [DonationController::class, 'userHistory'])->middleware('auth')->name('donations.user-history');

// Comment routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/campaigns/{campaign}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/campaigns/{campaign}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::patch('/comments/{comment}/toggle-pin', [CommentController::class, 'togglePin'])->name('comments.toggle-pin');
});

// Reward routes (require authentication for management)
Route::get('/campaigns/{campaign}/rewards', [RewardController::class, 'index'])->name('rewards.index');
Route::middleware('auth')->group(function () {
    Route::get('/campaigns/{campaign}/rewards/create', [RewardController::class, 'create'])->name('rewards.create');
    Route::post('/campaigns/{campaign}/rewards', [RewardController::class, 'store'])->name('rewards.store');
    Route::get('/campaigns/{campaign}/rewards/{reward}', [RewardController::class, 'show'])->name('rewards.show');
    Route::get('/campaigns/{campaign}/rewards/{reward}/edit', [RewardController::class, 'edit'])->name('rewards.edit');
    Route::put('/campaigns/{campaign}/rewards/{reward}', [RewardController::class, 'update'])->name('rewards.update');
    Route::delete('/campaigns/{campaign}/rewards/{reward}', [RewardController::class, 'destroy'])->name('rewards.destroy');
});

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
    Route::get('/comments', [AdminController::class, 'comments'])->name('admin.comments');
});

// Campaign resource routes (public routes)
Route::resource('campaigns', CampaignController::class)->only(['index', 'show']);

// Dashboard route - redirect admins to admin dashboard, users to user dashboard
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.campaigns');
    }
    return view('dashboard');
})->middleware('auth')->name('dashboard');

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

// Test Donation models and relationships
Route::get('/test-donations', function () {
    $donations = \App\Models\Donation::with(['user', 'campaign'])->get();
    
    $html = '<h1>💰 Donation Models Test</h1>';
    
    foreach ($donations as $donation) {
        $html .= '<div style="border:1px solid #ccc; margin:10px; padding:15px;">';
        $html .= '<h3>Donation #' . $donation->id . '</h3>';
        $html .= '<p><strong>Amount:</strong> $' . number_format($donation->amount, 2) . '</p>';
        $html .= '<p><strong>Donor:</strong> ' . $donation->donor_name . '</p>';
        $html .= '<p><strong>Campaign:</strong> ' . $donation->campaign->title . '</p>';
        $html .= '<p><strong>Message:</strong> ' . ($donation->message ?: 'No message') . '</p>';
        $html .= '<p><strong>Anonymous:</strong> ' . ($donation->anonymous ? 'Yes' : 'No') . '</p>';
        $html .= '<p><strong>Status:</strong> ' . $donation->status . '</p>';
        $html .= '</div>';
    }
    
    // Test Campaign→Donation relationship
    $html .= '<h2>📊 Campaign Donation Totals</h2>';
    $campaigns = \App\Models\Campaign::with('donations')->get();
    
    foreach ($campaigns as $campaign) {
        $totalDonations = $campaign->donations->sum('amount');
        $donorCount = $campaign->donations->count();
        
        $html .= '<div style="border:2px solid #28a745; margin:10px; padding:15px;">';
        $html .= '<h3>' . $campaign->title . '</h3>';
        $html .= '<p><strong>Goal:</strong> $' . number_format($campaign->goal_amount, 2) . '</p>';
        $html .= '<p><strong>Current Amount:</strong> $' . number_format($campaign->current_amount, 2) . '</p>';
        $html .= '<p><strong>Donation Total:</strong> $' . number_format($totalDonations, 2) . '</p>';
        $html .= '<p><strong>Number of Donors:</strong> ' . $donorCount . '</p>';
        $html .= '<p><strong>Progress:</strong> ' . $campaign->progress_percentage . '%</p>';
        $html .= '</div>';
    }
    
    // Test User→Donation relationship
    $html .= '<h2>👤 User Donation History</h2>';
    $users = \App\Models\User::with('donations.campaign')->get();
    
    foreach ($users as $user) {
        if ($user->donations->count() > 0) {
            $html .= '<div style="border:2px solid #007acc; margin:10px; padding:15px;">';
            $html .= '<h3>' . $user->name . ' (' . $user->email . ')</h3>';
            $html .= '<p><strong>Total Donated:</strong> $' . number_format($user->total_donated, 2) . '</p>';
            $html .= '<p><strong>Campaigns Supported:</strong> ' . $user->campaigns_supported_count . '</p>';
            
            foreach ($user->donations as $donation) {
                $html .= '<p style="margin-left:20px;">• $' . number_format($donation->amount, 2) . ' to "' . $donation->campaign->title . '"</p>';
            }
            
            $html .= '</div>';
        }
    }
    
    return $html;
})->name('test.donations');

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

// Test Reward models and relationships
Route::get('/test-rewards', function () {
    $rewards = \App\Models\Reward::with('campaign')->get();
    
    $html = '<h1>🎁 Reward Models Test</h1>';
    $html .= '<p><strong>Total Rewards:</strong> ' . $rewards->count() . '</p>';
    
    foreach ($rewards as $reward) {
        $html .= '<div style="border:1px solid #ccc; margin:10px; padding:15px;">';
        $html .= '<h3>🎁 ' . $reward->title . '</h3>';
        $html .= '<p><strong>Campaign:</strong> ' . $reward->campaign->title . '</p>';
        $html .= '<p><strong>Min Amount:</strong> $' . number_format($reward->minimum_amount, 2) . '</p>';
        $html .= '<p><strong>Backers:</strong> ' . $reward->current_backers;
        if ($reward->maximum_backers) {
            $html .= ' / ' . $reward->maximum_backers;
        } else {
            $html .= ' (unlimited)';
        }
        $html .= '</p>';
        $html .= '<p><strong>Description:</strong> ' . $reward->description . '</p>';
        $html .= '<p><strong>Included Items:</strong> ' . implode(', ', $reward->included_items ?? []) . '</p>';
        $html .= '<p><strong>Shipping:</strong> ' . $reward->shipping_info . '</p>';
        $html .= '<p><strong>Delivery:</strong> ' . ($reward->estimated_delivery ? $reward->estimated_delivery->format('M j, Y') : 'TBD') . '</p>';
        $html .= '<p><strong>Available:</strong> ' . ($reward->isAvailable() ? '✅ Yes' : '❌ No') . '</p>';
        $html .= '<p><strong>Status:</strong> ' . $reward->availability_status . '</p>';
        $html .= '</div>';
    }
    
    // Test Campaign→Reward relationship
    $html .= '<h2>📊 Campaign→Reward Relationships</h2>';
    $campaigns = \App\Models\Campaign::with('rewards')->get();
    
    foreach ($campaigns as $campaign) {
        $html .= '<div style="border:2px solid #007acc; margin:10px; padding:15px;">';
        $html .= '<h3>' . $campaign->title . '</h3>';
        $html .= '<p><strong>Total Rewards:</strong> ' . $campaign->rewards->count() . '</p>';
        $html .= '<p><strong>Available Rewards:</strong> ' . $campaign->availableRewards()->count() . '</p>';
        
        foreach ($campaign->rewards->take(3) as $reward) {
            $html .= '<p style="margin-left:20px;">• ' . $reward->title . ' ($' . number_format($reward->minimum_amount) . '+)</p>';
        }
        
        $html .= '</div>';
    }
    
    return $html;
})->name('test.rewards');

require __DIR__.'/auth.php';
