<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        
        // Get user's campaigns
        $myCampaigns = Campaign::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get user's donations
        $myDonations = Donation::where('user_id', $user->id)
            ->with('campaign')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get campaigns user has backed
        $backedCampaigns = Campaign::whereHas('donations', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->distinct()->get();
        
        // Calculate statistics
        $campaignsCreated = $myCampaigns->count();
        $totalDonated = $myDonations->sum('amount');
        $campaignsBacked = $backedCampaigns->count();
        $commentsCount = $user->comments()->count();
        
        return view('profile.show', compact(
            'myCampaigns',
            'myDonations',
            'backedCampaigns',
            'campaignsCreated',
            'totalDonated',
            'campaignsBacked',
            'commentsCount'
        ));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
