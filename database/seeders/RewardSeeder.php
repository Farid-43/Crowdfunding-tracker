<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\Reward;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first campaign
        $campaign = Campaign::first();
        
        if (!$campaign) {
            $this->command->info('No campaigns found. Please create a campaign first.');
            return;
        }

        // Sample rewards data
        $rewards = [
            [
                'campaign_id' => $campaign->id,
                'title' => 'Early Bird Special',
                'description' => 'Get the product at a discounted price! Perfect for early supporters.',
                'minimum_amount' => 25.00,
                'maximum_backers' => 100,
                'current_backers' => 15,
                'estimated_delivery' => '2025-12-01',
                'included_items' => ['Digital Download', 'Thank You Email'],
                'shipping_info' => 'Digital - No Shipping Required',
                'sort_order' => 1
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Unlimited Access',
                'description' => 'No limit digital reward for maximum flexibility.',
                'minimum_amount' => 15.00,
                'maximum_backers' => null,
                'current_backers' => 150,
                'estimated_delivery' => '2025-11-01',
                'included_items' => ['Digital Access', 'Updates', 'Community Access'],
                'shipping_info' => 'Digital - Instant Access',
                'sort_order' => 2
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Standard Reward',
                'description' => 'The full product experience with all standard features included.',
                'minimum_amount' => 50.00,
                'maximum_backers' => 500,
                'current_backers' => 45,
                'estimated_delivery' => '2025-12-15',
                'included_items' => ['Physical Product', 'User Manual', 'Digital Extras'],
                'shipping_info' => 'Worldwide Shipping Included',
                'sort_order' => 3
            ],
            [
                'campaign_id' => $campaign->id,
                'title' => 'Premium Package',
                'description' => 'Everything in standard plus exclusive bonus content and premium materials.',
                'minimum_amount' => 100.00,
                'maximum_backers' => 50,
                'current_backers' => 8,
                'estimated_delivery' => '2025-11-30',
                'included_items' => ['Premium Product', 'Exclusive Bonuses', 'Certificate', 'Priority Support'],
                'shipping_info' => 'Express Shipping Worldwide',
                'sort_order' => 4
            ]
        ];

        foreach ($rewards as $rewardData) {
            Reward::create($rewardData);
        }

        $this->command->info('Created ' . count($rewards) . ' sample rewards for campaign: ' . $campaign->title);
    }
}
