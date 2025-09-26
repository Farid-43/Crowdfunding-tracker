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
    public function index(Request $request)
    {
        $query = Campaign::with(['user', 'categories'])
            ->active()
            ->notExpired();

        // Text search across title, description, and short_description
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('short_description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Category filtering
        if ($request->filled('categories')) {
            $categoryIds = $request->get('categories');
            if (is_array($categoryIds) && !empty($categoryIds)) {
                $query->whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }
        }

        // Sorting
        $sortBy = $request->get('sort', 'featured_and_date');
        switch ($sortBy) {
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'goal_high':
                $query->orderBy('goal_amount', 'desc');
                break;
            case 'goal_low':
                $query->orderBy('goal_amount', 'asc');
                break;
            case 'ending_soon':
                $query->orderBy('deadline', 'asc');
                break;
            default:
                $query->orderBy('featured', 'desc')
                      ->orderBy('created_at', 'desc');
        }

        $campaigns = $query->paginate(12)->withQueryString();

        // Get all active categories for the filter dropdown
        $categories = \App\Models\Category::active()->ordered()->get();

        // Get filter/search parameters for the view
        $filters = [
            'search' => $request->get('search'),
            'categories' => $request->get('categories', []),
            'sort' => $sortBy
        ];

        return view('campaigns.index', compact('campaigns', 'categories', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::active()->ordered()->get();
        return view('campaigns.create', compact('categories'));
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
            'categories' => 'nullable|array|min:1|max:3',
            'categories.*' => 'exists:categories,id',
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

        // Attach selected categories
        if (!empty($validated['categories'])) {
            $campaign->categories()->attach($validated['categories']);
        }

        \Log::info('Campaign created successfully', ['campaign_id' => $campaign->id]);

        return redirect()->route('campaigns.show', $campaign)
                        ->with('success', 'Campaign created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        $campaign->load(['user', 'categories', 'rewards' => function($query) {
            $query->available()->ordered();
        }]);
        return view('campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        // Check authorization: only admin can edit
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Only administrators can edit campaigns.');
        }

        $categories = \App\Models\Category::active()->ordered()->get();
        return view('campaigns.edit', compact('campaign', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        // Check authorization: only admin can update
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Only administrators can update campaigns.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string|min:100',
            'goal_amount' => 'required|numeric|min:100|max:1000000',
            'deadline' => 'required|date|after:today',
            'category' => 'required|string|in:Technology,Art,Music,Film,Games,Publishing,Fashion,Food,Health,Education',
            'categories' => 'nullable|array|min:1|max:3',
            'categories.*' => 'exists:categories,id',
            'image_url' => 'nullable|url|max:2048'
        ]);

        $campaign->update([
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'description' => $validated['description'],
            'goal_amount' => $validated['goal_amount'],
            'deadline' => $validated['deadline'],
            'category' => $validated['category'],
            'image_path' => $validated['image_url'] ?? $campaign->image_path,
        ]);

        // Sync selected categories (remove old, add new)
        if (isset($validated['categories'])) {
            $campaign->categories()->sync($validated['categories']);
        } else {
            $campaign->categories()->detach();
        }

        return redirect()->route('campaigns.show', $campaign)
                        ->with('success', 'Campaign updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        // Check authorization: only admin can delete campaigns
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action. Only administrators can delete campaigns.');
        }

        $campaignTitle = $campaign->title;
        $campaign->delete();

        return redirect()->route('campaigns.index')
                        ->with('success', "Campaign '{$campaignTitle}' has been deleted successfully!");
    }
}
