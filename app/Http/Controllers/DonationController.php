<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use App\Http\Requests\DonationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Show the donation form for a specific campaign
     */
    public function create(Campaign $campaign)
    {
        // Check if campaign is still active and not expired
        if ($campaign->is_expired || $campaign->status !== 'active') {
            return redirect()->route('campaigns.show', $campaign)
                ->with('error', 'This campaign is no longer accepting donations.');
        }

        return view('donations.create', compact('campaign'));
    }

    /**
     * Process the donation (prototype - no real payment)
     */
    public function store(DonationRequest $request, Campaign $campaign)
    {
        // Get validated data
        $validated = $request->validated();

        // Check if campaign is still active
        if ($campaign->is_expired || $campaign->status !== 'active') {
            return redirect()->route('campaigns.show', $campaign)
                ->with('error', 'This campaign is no longer accepting donations.');
        }

        // Use database transaction to ensure data consistency
        DB::beginTransaction();
        
        try {
            // Create the donation record
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'campaign_id' => $campaign->id,
                'amount' => $validated['amount'],
                'donor_name' => $validated['donor_name'] ?? null,
                'donor_email' => $validated['donor_email'] ?? null,
                'message' => $validated['message'] ?? null,
                'anonymous' => $validated['anonymous'] ?? false,
                'status' => 'completed', // Prototype - auto-complete
                'payment_method' => 'prototype',
                'transaction_id' => 'PROTO_' . uniqid(),
            ]);

            // Update campaign totals
            $campaign->increment('current_amount', $donation->amount);
            $campaign->increment('backers_count');

            DB::commit();

            // Redirect to thank you page
            return redirect()->route('donations.thankyou', [
                'campaign' => $campaign,
                'donation' => $donation
            ])->with('success', 'Thank you for your donation!');

        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'There was an error processing your donation. Please try again.');
        }
    }

    /**
     * Show thank you page after successful donation
     */
    public function thankyou(Campaign $campaign, Donation $donation)
    {
        // Ensure the donation belongs to this campaign
        if ($donation->campaign_id !== $campaign->id) {
            abort(404);
        }

        return view('donations.thankyou', compact('campaign', 'donation'));
    }
}
