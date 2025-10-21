<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the main admin dashboard
     */
    public function dashboard()
    {
        // Get key statistics
        $stats = [
            'total_users' => User::count(),
            'total_campaigns' => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'completed_campaigns' => Campaign::where('status', 'completed')->count(),
            'total_raised' => Campaign::sum('current_amount'),
            'total_goal' => Campaign::sum('goal_amount'),
        ];

        // Get recent campaigns
        $recentCampaigns = Campaign::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get top campaigns by amount raised
        $topCampaigns = Campaign::orderBy('current_amount', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCampaigns', 'recentUsers', 'topCampaigns'));
    }

    /**
     * Display all campaigns for admin management
     */
    public function campaigns()
    {
        $campaigns = Campaign::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.campaigns', compact('campaigns'));
    }

    /**
     * Display all users for admin management
     */
    public function users()
    {
        // Get all users with their campaign count
        $users = User::withCount('campaigns')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Display platform analytics
     */
    public function analytics()
    {
        $analytics = [
            'total_campaigns' => Campaign::count(),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'completed_campaigns' => Campaign::where('status', 'completed')->count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'total_raised' => Campaign::sum('current_amount'),
            'average_campaign_goal' => Campaign::avg('goal_amount'),
            'campaigns_this_month' => Campaign::whereMonth('created_at', now()->month)->count(),
            'users_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];

        // Get campaign creation trends (last 7 days)
        $campaign_trends = collect(range(6, 0))->map(function ($days_ago) {
            $date = now()->subDays($days_ago);
            return [
                'date' => $date->format('M j'),
                'campaigns' => Campaign::whereDate('created_at', $date)->count(),
                'users' => User::whereDate('created_at', $date)->count(),
            ];
        });

        return view('admin.analytics', compact('analytics', 'campaign_trends'));
    }

    /**
     * Display platform reports
     */
    public function reports()
    {
        $reports = [
            'top_categories' => Campaign::selectRaw('category, COUNT(*) as count, SUM(current_amount) as total_raised')
                ->groupBy('category')
                ->orderBy('total_raised', 'desc')
                ->get(),
            
            'top_creators' => User::withCount('campaigns')
                ->with(['campaigns' => function($query) {
                    $query->selectRaw('user_id, SUM(current_amount) as total_raised')
                        ->groupBy('user_id');
                }])
                ->having('campaigns_count', '>', 0)
                ->orderBy('campaigns_count', 'desc')
                ->limit(10)
                ->get(),
                
            'recent_activity' => Campaign::with('user')
                ->latest()
                ->limit(20)
                ->get(),
        ];

        return view('admin.reports', compact('reports'));
    }

    /**
     * Display platform settings
     */
    public function settings()
    {
        $settings = [
            'platform_name' => 'CrowdFunder',
            'maintenance_mode' => false,
            'registration_enabled' => true,
            'campaign_approval_required' => false,
            'max_campaign_duration' => 90, // days
            'min_campaign_goal' => 100,
            'max_campaign_goal' => 1000000,
            'featured_campaigns_count' => 6,
        ];

        return view('admin.settings', compact('settings'));
    }

    /**
     * Display category management
     */
    public function categories()
    {
        $categories = [
            'Technology' => Campaign::where('category', 'Technology')->count(),
            'Art' => Campaign::where('category', 'Art')->count(),
            'Music' => Campaign::where('category', 'Music')->count(),
            'Film' => Campaign::where('category', 'Film')->count(),
            'Games' => Campaign::where('category', 'Games')->count(),
            'Publishing' => Campaign::where('category', 'Publishing')->count(),
            'Fashion' => Campaign::where('category', 'Fashion')->count(),
            'Food' => Campaign::where('category', 'Food')->count(),
            'Health' => Campaign::where('category', 'Health')->count(),
            'Education' => Campaign::where('category', 'Education')->count(),
        ];

        return view('admin.categories', compact('categories'));
    }

    /**
     * Comment Management (Admin only)
     */
    public function comments(Request $request)
    {
        $this->authorize('admin');
        
        $query = Comment::with(['user', 'campaign']);

        // Handle search
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('content', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhereHas('campaign', function($subQ) use ($search) {
                      $subQ->where('title', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        // Handle filtering
        $filter = $request->get('filter');
        if ($filter) {
            switch ($filter) {
                case 'pinned':
                    $query->where('is_pinned', true);
                    break;
                case 'edited':
                    $query->where('is_edited', true);
                    break;
                case 'recent':
                    $query->where('created_at', '>=', now()->subDays(7));
                    break;
            }
        }

        // Handle sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'campaign':
                $query->join('campaigns', 'comments.campaign_id', '=', 'campaigns.id')
                      ->orderBy('campaigns.title', 'asc')
                      ->select('comments.*');
                break;
            case 'user':
                $query->join('users', 'comments.user_id', '=', 'users.id')
                      ->orderBy('users.name', 'asc')
                      ->select('comments.*');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $comments = $query->paginate(25)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Comment::count(),
            'today' => Comment::whereDate('created_at', today())->count(),
            'this_week' => Comment::where('created_at', '>=', now()->subDays(7))->count(),
            'pinned' => Comment::where('is_pinned', true)->count(),
            'edited' => Comment::where('is_edited', true)->count(),
        ];

        return view('admin.comments', compact('comments', 'stats', 'search', 'filter', 'sort'));
    }

    /**
     * Display all contact messages
     */
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total' => Contact::count(),
            'pending' => Contact::where('status', 'pending')->count(),
            'read' => Contact::where('status', 'read')->count(),
        ];

        return view('admin.contacts', compact('contacts', 'stats'));
    }

    /**
     * Mark contact as read
     */
    public function markContactAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'read']);

        return redirect()->back()->with('success', 'Contact marked as read');
    }

    /**
     * Toggle campaign featured status
     */
    public function toggleFeatured($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->featured = !$campaign->featured;
        $campaign->save();

        $status = $campaign->featured ? 'featured' : 'unfeatured';
        return redirect()->back()->with('success', "Campaign has been {$status} successfully!");
    }
} 
