<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get campaigns with basic sorting
        $campaigns = $user->campaigns()->with(['categories', 'donations'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Get donations with basic sorting
        $donations = $user->completedDonations()->with(['campaign', 'reward'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $stats = [
            'total_campaigns' => $user->campaigns->count(),
            'total_raised' => $user->campaigns->sum('current_amount'),
            'total_donated' => $user->total_donated_amount,
            'success_rate' => $this->calculateSuccessRate($user),
            'active_campaigns' => $user->campaigns->where('status', 'active')->count(),
            'total_backers' => $this->getTotalBackers($user),
            'avg_campaign_goal' => $user->campaigns->count() > 0 ? $user->campaigns->avg('goal_amount') : 0,
            'campaigns_supported' => $user->campaigns_supported_count,
            'avg_donation' => $user->completedDonations->count() > 0 ? $user->completedDonations->avg('amount') : 0,
        ];
        
        // Get recent activity
        $recentActivity = $this->getRecentActivity($user);
        
        return view('dashboard', compact('campaigns', 'donations', 'stats', 'recentActivity'));
    }
    
    /**
     * Calculate success rate for user's campaigns
     */
    private function calculateSuccessRate($user)
    {
        $totalCampaigns = $user->campaigns->count();
        if ($totalCampaigns === 0) return 0;
        
        $successfulCampaigns = $user->campaigns->filter(function($campaign) {
            return $campaign->current_amount >= $campaign->goal_amount;
        })->count();
        
        return ($successfulCampaigns / $totalCampaigns) * 100;
    }
    
    /**
     * Get total unique backers across all user campaigns
     */
    private function getTotalBackers($user)
    {
        return $user->campaigns->sum(function($campaign) {
            return $campaign->donations()->completed()->distinct('user_id')->count('user_id');
        });
    }
    
    /**
     * Get recent activity for the user
     */
    private function getRecentActivity($user)
    {
        $activities = collect();
        
        // Add recent campaigns
        $user->campaigns->take(3)->each(function($campaign) use ($activities) {
            $activities->push([
                'type' => 'campaign',
                'action' => 'created',
                'title' => $campaign->title,
                'date' => $campaign->created_at,
                'url' => route('campaigns.show', $campaign)
            ]);
        });
        
        // Add recent donations
        $user->completedDonations->take(3)->each(function($donation) use ($activities) {
            $activities->push([
                'type' => 'donation',
                'action' => 'donated',
                'title' => $donation->campaign->title,
                'date' => $donation->created_at,
                'url' => route('campaigns.show', $donation->campaign),
                'amount' => $donation->amount
            ]);
        });
        
        return $activities->sortByDesc('date')->take(5);
    }
}