<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    /**
     * Display a listing of rewards for a campaign
     */
    public function index(Campaign $campaign)
    {
        $rewards = $campaign->rewards()->ordered()->get();
        
        return view('rewards.index', compact('campaign', 'rewards'));
    }

    /**
     * Show the form for creating a new reward
     */
    public function create(Campaign $campaign)
    {
        // Check if user owns the campaign
        if ($campaign->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('rewards.create', compact('campaign'));
    }

    /**
     * Store a newly created reward in storage
     */
    public function store(Request $request, Campaign $campaign)
    {
        // Check if user owns the campaign
        if ($campaign->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'minimum_amount' => 'required|numeric|min:1',
            'maximum_backers' => 'nullable|integer|min:1',
            'estimated_delivery' => 'nullable|date|after:today',
            'included_items' => 'nullable|array',
            'included_items.*' => 'string|max:255',
            'shipping_info' => 'nullable|string|max:255',
        ]);

        // Convert included_items array to proper format
        if (isset($validated['included_items'])) {
            $validated['included_items'] = array_filter($validated['included_items']);
        }

        $reward = $campaign->rewards()->create($validated);

        return redirect()->route('rewards.index', $campaign)
                        ->with('success', 'Reward created successfully!');
    }

    /**
     * Display the specified reward
     */
    public function show(Campaign $campaign, Reward $reward)
    {
        // Ensure reward belongs to campaign
        if ($reward->campaign_id !== $campaign->id) {
            abort(404);
        }

        return view('rewards.show', compact('campaign', 'reward'));
    }

    /**
     * Show the form for editing the specified reward
     */
    public function edit(Campaign $campaign, Reward $reward)
    {
        // Check if user owns the campaign and reward belongs to campaign
        if ($campaign->user_id !== Auth::id() || $reward->campaign_id !== $campaign->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('rewards.edit', compact('campaign', 'reward'));
    }

    /**
     * Update the specified reward in storage
     */
    public function update(Request $request, Campaign $campaign, Reward $reward)
    {
        // Check if user owns the campaign and reward belongs to campaign
        if ($campaign->user_id !== Auth::id() || $reward->campaign_id !== $campaign->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'minimum_amount' => 'required|numeric|min:1',
            'maximum_backers' => 'nullable|integer|min:1',
            'estimated_delivery' => 'nullable|date|after:today',
            'included_items' => 'nullable|array',
            'included_items.*' => 'string|max:255',
            'shipping_info' => 'nullable|string|max:255',
            'is_available' => 'boolean',
        ]);

        // Convert included_items array to proper format
        if (isset($validated['included_items'])) {
            $validated['included_items'] = array_filter($validated['included_items']);
        }

        $reward->update($validated);

        return redirect()->route('rewards.index', $campaign)
                        ->with('success', 'Reward updated successfully!');
    }

    /**
     * Remove the specified reward from storage
     */
    public function destroy(Campaign $campaign, Reward $reward)
    {
        // Check if user owns the campaign and reward belongs to campaign
        if ($campaign->user_id !== Auth::id() || $reward->campaign_id !== $campaign->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if reward has any donations
        if ($reward->donations()->count() > 0) {
            return redirect()->route('rewards.index', $campaign)
                            ->with('error', 'Cannot delete reward that has been selected by donors.');
        }

        $reward->delete();

        return redirect()->route('rewards.index', $campaign)
                        ->with('success', 'Reward deleted successfully!');
    }
}
