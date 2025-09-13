<?php

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Campaigns routes 
Route::get('/campaigns', function () {
    return view('campaigns.index');
})->name('campaigns.index');
