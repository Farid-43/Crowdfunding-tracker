<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users to assign campaigns to
        $adminUser = \App\Models\User::where('email', 'admin@crowdfunder.com')->first();
        $regularUser = \App\Models\User::where('email', 'user@crowdfunder.com')->first();
        
        // Create specific campaigns for our test users
        \App\Models\Campaign::create([
            'user_id' => $adminUser->id,
            'title' => 'Revolutionary AI Assistant for Developers',
            'description' => 'We are building the next generation AI assistant specifically designed for software developers. This tool will understand code context, suggest improvements, and help debug complex issues across multiple programming languages.',
            'short_description' => 'Next-gen AI assistant for developers with advanced code understanding and debugging capabilities.',
            'goal_amount' => 25000,
            'current_amount' => 18500,
            'deadline' => now()->addMonths(3),
            'status' => 'active',
            'category' => 'Technology',
            'image_path' => 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop',
            'backers_count' => 127,
            'featured' => true,
        ]);

        \App\Models\Campaign::create([
            'user_id' => $regularUser->id,
            'title' => 'Sustainable Urban Garden Kit',
            'description' => 'Help us create affordable, space-efficient garden kits for urban dwellers. Our modular system allows anyone to grow fresh vegetables and herbs in small spaces like apartments and balconies.',
            'short_description' => 'Modular garden kits designed for small urban spaces and sustainable living.',
            'goal_amount' => 8000,
            'current_amount' => 3200,
            'deadline' => now()->addMonths(2),
            'status' => 'active',
            'category' => 'Health',
            'image_path' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=800&h=600&fit=crop',
            'backers_count' => 45,
            'featured' => false,
        ]);

        \App\Models\Campaign::create([
            'user_id' => $adminUser->id,
            'title' => 'Interactive Music Learning App',
            'description' => 'An innovative mobile app that teaches music theory and instruments through gamification. Perfect for beginners and intermediate musicians looking to improve their skills.',
            'short_description' => 'Gamified music learning app for all skill levels.',
            'goal_amount' => 15000,
            'current_amount' => 22000, // Over-funded!
            'deadline' => now()->addMonths(1),
            'status' => 'completed',
            'category' => 'Music',
            'image_path' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800&h=600&fit=crop',
            'backers_count' => 203,
            'featured' => true,
        ]);

        // Create random campaigns using the factory
        \App\Models\Campaign::factory(12)->create([
            'user_id' => function() use ($adminUser, $regularUser) {
                return fake()->randomElement([$adminUser->id, $regularUser->id]);
            }
        ]);

        echo "✅ " . \App\Models\Campaign::count() . " campaigns created successfully!\n";
    }
}
