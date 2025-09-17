<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::with('user')
            ->active()
            ->notExpired()
            ->orderBy('featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log the incoming request for debugging
        \Log::info('Campaign creation attempt', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string|min:100',
            'goal_amount' => 'required|numeric|min:100|max:1000000',
            'deadline' => 'required|date|after:today',
            'category' => 'required|string|in:Technology,Art,Music,Film,Games,Publishing,Fashion,Food,Health,Education',
            'image_url' => 'nullable|url|max:2048' // URL validation
        ]);

        \Log::info('Campaign validation passed', $validated);

        $campaign = Campaign::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'goal_amount' => $validated['goal_amount'],
            'deadline' => $validated['deadline'],
            'category' => $validated['category'],
            'image_path' => $validated['image_url'] ?? null, // Store URL in image_path field
            'status' => 'active'
        ]);

        \Log::info('Campaign created successfully', ['campaign_id' => $campaign->id]);

        return redirect()->route('campaigns.show', $campaign)
                        ->with('success', 'Campaign created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $campaign->load('user');
        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
