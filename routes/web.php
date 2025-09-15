<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Campaigns routes (placeholder for now)
Route::get('/campaigns', function () {
    return view('campaigns.index');
})->name('campaigns.index');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

require __DIR__.'/auth.php';
