<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Campaign;
use App\Models\User;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users and campaigns
        $users = User::all();
        $campaigns = Campaign::all();

        if ($users->isEmpty() || $campaigns->isEmpty()) {
            $this->command->warn('No users or campaigns found. Please run UserSeeder and CampaignSeeder first.');
            return;
        }

        // Sample donations data
        $donations = [
            [
                'user_id' => $users->where('role', 'user')->first()?->id,
                'campaign_id' => $campaigns->first()->id,
                'amount' => 100.00,
                'message' => 'Great project! Hope you reach your goal!',
                'anonymous' => false,
            ],
            [
                'user_id' => $users->where('role', 'admin')->first()?->id,
                'campaign_id' => $campaigns->first()->id,
                'amount' => 250.00,
                'message' => 'Supporting innovation in our community.',
                'anonymous' => false,
            ],
            [
                'user_id' => null, // Guest donation
                'campaign_id' => $campaigns->skip(1)->first()?->id ?: $campaigns->first()->id,
                'amount' => 50.00,
                'donor_name' => 'John Smith',
                'donor_email' => 'john@example.com',
                'message' => 'Anonymous donation - good luck!',
                'anonymous' => true,
            ],
            [
                'user_id' => $users->where('role', 'user')->first()?->id,
                'campaign_id' => $campaigns->skip(1)->first()?->id ?: $campaigns->first()->id,
                'amount' => 75.00,
                'message' => 'Love this idea!',
                'anonymous' => false,
            ],
            [
                'user_id' => null, // Guest donation
                'campaign_id' => $campaigns->first()->id,
                'amount' => 25.00,
                'donor_name' => 'Jane Doe',
                'donor_email' => 'jane@example.com',
                'message' => null,
                'anonymous' => false,
            ],
        ];

        foreach ($donations as $donationData) {
            $donation = Donation::create($donationData);
            
            // Update campaign current_amount and backers_count
            $campaign = $donation->campaign;
            $campaign->increment('current_amount', $donation->amount);
            $campaign->increment('backers_count');
        }

        $this->command->info('Sample donations created successfully!');
        $this->command->info('Campaign progress updated with donation amounts.');
    }
}
