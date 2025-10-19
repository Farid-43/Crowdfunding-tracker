<?php

use App\Http\Controllers\Api\CampaignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Lab 10: REST API Implementation
// TODO: Create API endpoint to return all campaigns as JSON
// Route: GET /api/campaigns
// Fields: id, title, goal_amount, current_amount, deadline

// Campaign API endpoints
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show']);

// Donation API endpoint (for AJAX) - guests can donate too
Route::post('/campaigns/{campaign}/donate', [CampaignController::class, 'donate']);

// Platform statistics API
Route::get('/stats', [CampaignController::class, 'stats']);

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working',
        'timestamp' => now()
    ]);
});