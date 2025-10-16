<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns for API
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            // Get query parameters for filtering
            $status = $request->get('status');
            $category = $request->get('category');
            $limit = $request->get('limit', 20);

            // Build query
            $query = Campaign::with('user:id,name')
                ->select(['id', 'title', 'goal_amount', 'current_amount', 'deadline', 'status', 'category', 'user_id']);

            // Apply filters
            if ($status) {
                $query->where('status', $status);
            }

            if ($category) {
                $query->where('category', $category);
            }

            // Get campaigns
            $campaigns = $query->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();

            // Transform data for API response
            $data = $campaigns->map(function ($campaign) {
                return [
                    'id' => $campaign->id,
                    'title' => $campaign->title,
                    'goal_amount' => $campaign->goal_amount,
                    'current_amount' => $campaign->current_amount,
                    'deadline' => $campaign->deadline,
                    'status' => $campaign->status,
                    'category' => $campaign->category,
                    'creator' => $campaign->user->name,
                    'progress_percentage' => $campaign->goal_amount > 0 
                        ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2) 
                        : 0
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Campaigns retrieved successfully',
                'data' => $data,
                'total' => $campaigns->count(),
                'filters_applied' => [
                    'status' => $status,
                    'category' => $category,
                    'limit' => $limit
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve campaigns',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified campaign for API
     * 
     * @param Campaign $campaign
     * @return JsonResponse
     */
    public function show(Campaign $campaign): JsonResponse
    {
        try {
            // Load relationships
            $campaign->load(['user:id,name,email', 'donations:id,campaign_id,amount,created_at']);

            // Transform data for API response
            $data = [
                'id' => $campaign->id,
                'title' => $campaign->title,
                'description' => $campaign->description,
                'short_description' => $campaign->short_description,
                'goal_amount' => $campaign->goal_amount,
                'current_amount' => $campaign->current_amount,
                'deadline' => $campaign->deadline,
                'status' => $campaign->status,
                'category' => $campaign->category,
                'backers_count' => $campaign->backers_count,
                'featured' => $campaign->featured,
                'created_at' => $campaign->created_at,
                'updated_at' => $campaign->updated_at,
                'creator' => [
                    'id' => $campaign->user->id,
                    'name' => $campaign->user->name,
                    'email' => $campaign->user->email
                ],
                'progress_percentage' => $campaign->goal_amount > 0 
                    ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2) 
                    : 0,
                'donations_count' => $campaign->donations->count(),
                'recent_donations' => $campaign->donations->take(5)->map(function ($donation) {
                    return [
                        'amount' => $donation->amount,
                        'date' => $donation->created_at
                    ];
                })
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Campaign retrieved successfully',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Campaign not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Get platform statistics for API
     * 
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'campaigns' => [
                    'total' => Campaign::count(),
                    'active' => Campaign::where('status', 'active')->count(),
                    'completed' => Campaign::where('status', 'completed')->count(),
                    'featured' => Campaign::where('featured', true)->count()
                ],
                'funding' => [
                    'total_raised' => Campaign::sum('current_amount'),
                    'total_goal' => Campaign::sum('goal_amount'),
                    'average_goal' => Campaign::avg('goal_amount'),
                    'highest_raised' => Campaign::max('current_amount')
                ],
                'users' => [
                    'total' => User::count(),
                    'creators' => User::has('campaigns')->count()
                ],
                'categories' => Campaign::select('category')
                    ->selectRaw('COUNT(*) as count')
                    ->selectRaw('SUM(current_amount) as total_raised')
                    ->groupBy('category')
                    ->orderBy('count', 'desc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'name' => $item->category,
                            'campaigns_count' => $item->count,
                            'total_raised' => $item->total_raised
                        ];
                    }),
                'recent_activity' => [
                    'campaigns_this_week' => Campaign::where('created_at', '>=', now()->subWeek())->count(),
                    'campaigns_this_month' => Campaign::where('created_at', '>=', now()->subMonth())->count()
                ]
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Platform statistics retrieved successfully',
                'data' => $stats,
                'generated_at' => now()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process donation via AJAX (for Lab 10)
     * 
     * @param Request $request
     * @param Campaign $campaign
     * @return JsonResponse
     */
    public function donate(Request $request, Campaign $campaign): JsonResponse
    {
        try {
            // Validate request
            $validated = $request->validate([
                'amount' => 'required|numeric|min:1|max:100000',
                'donor_name' => 'required|string|max:255',
                'donor_email' => 'required|email|max:255',
                'message' => 'nullable|string|max:500',
                'anonymous' => 'boolean',
                'reward_id' => 'nullable|exists:rewards,id'
            ]);

            // Check if campaign is still active
            if ($campaign->is_expired || $campaign->status !== 'active') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This campaign is no longer accepting donations.',
                ], 400);
            }

            // Validate reward if provided
            if (isset($validated['reward_id'])) {
                $reward = $campaign->rewards()->find($validated['reward_id']);
                if (!$reward || !$reward->is_available) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Selected reward is not available.',
                    ], 400);
                }

                if ($validated['amount'] < $reward->minimum_amount) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Minimum amount for this reward is $" . number_format($reward->minimum_amount, 2),
                    ], 400);
                }
            }

            // Process donation in transaction
            DB::beginTransaction();

            $donation = Donation::create([
                'campaign_id' => $campaign->id,
                'user_id' => auth()->id(),
                'amount' => $validated['amount'],
                'donor_name' => $validated['donor_name'],
                'donor_email' => $validated['donor_email'],
                'message' => $validated['message'] ?? null,
                'anonymous' => $validated['anonymous'] ?? false,
                'reward_id' => $validated['reward_id'] ?? null,
                'status' => 'completed', // For prototype
                'transaction_id' => 'TXN-' . uniqid(),
            ]);

            // Update campaign totals
            $campaign->increment('current_amount', $validated['amount']);
            $campaign->increment('backers_count');

            // Update reward backers count if reward selected
            if (isset($validated['reward_id'])) {
                $reward->increment('current_backers');
            }

            DB::commit();

            // Reload campaign with fresh data
            $campaign->refresh();

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for your donation!',
                'data' => [
                    'donation_id' => $donation->id,
                    'amount' => $donation->amount,
                    'transaction_id' => $donation->transaction_id,
                    'campaign' => [
                        'current_amount' => $campaign->current_amount,
                        'goal_amount' => $campaign->goal_amount,
                        'backers_count' => $campaign->backers_count,
                        'progress_percentage' => $campaign->goal_amount > 0 
                            ? round(($campaign->current_amount / $campaign->goal_amount) * 100, 2) 
                            : 0
                    ]
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process donation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}