<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and campaigns
        $users = User::all();
        $campaigns = Campaign::all();

        if ($users->isEmpty() || $campaigns->isEmpty()) {
            $this->command->info('No users or campaigns found. Please run UserSeeder and CampaignSeeder first.');
            return;
        }

        $sampleComments = [
            'This is such an amazing project! I really hope it reaches its goal.',
            'Great idea! I\'ve been looking for something like this for a long time.',
            'The concept is innovative and the team seems passionate. Best of luck!',
            'I love the transparency in your updates. Keep up the excellent work!',
            'When do you expect to deliver the rewards? Excited to get mine!',
            'This could really make a difference. Happy to support!',
            'The video explanation was very clear and compelling.',
            'I have a question about the timeline - any updates on the milestones?',
            'Impressive progress so far! The community support is fantastic.',
            'This reminds me of another project I backed. Hope this one succeeds too!',
            'The budget breakdown is very detailed. Appreciate the honesty.',
            'Can you provide more information about the technical specifications?',
            'I shared this with my friends - they might be interested too.',
            'The early bird pricing was a great incentive to back early.',
            'Looking forward to seeing regular updates as the project progresses.',
        ];

        // Create comments for each campaign
        foreach ($campaigns as $campaign) {
            $numberOfComments = rand(2, 8);
            
            for ($i = 0; $i < $numberOfComments; $i++) {
                $user = $users->random();
                $content = $sampleComments[array_rand($sampleComments)];
                
                // Occasionally create longer, more detailed comments
                if (rand(1, 4) === 1) {
                    $content .= "\n\nI've been following this space for a while and I think this approach is really promising. The team has shown great dedication and I'm confident they can deliver on their promises.";
                }
                
                Comment::create([
                    'user_id' => $user->id,
                    'campaign_id' => $campaign->id,
                    'content' => $content,
                    'is_pinned' => rand(1, 10) === 1, // 10% chance of being pinned
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                ]);
            }
        }

        // Create a few pinned comments from admins
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            foreach ($campaigns->take(3) as $campaign) {
                Comment::create([
                    'user_id' => $admin->id,
                    'campaign_id' => $campaign->id,
                    'content' => 'Welcome to the campaign discussion! Please keep comments constructive and relevant to the project. Thank you for being part of our community!',
                    'is_pinned' => true,
                    'created_at' => $campaign->created_at->addHours(1),
                ]);
            }
        }

        $this->command->info('Comments seeded successfully!');
    }
}
