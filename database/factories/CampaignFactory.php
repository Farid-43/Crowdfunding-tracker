<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $goalAmount = fake()->numberBetween(1000, 50000);
        $currentAmount = fake()->numberBetween(0, $goalAmount * 1.2); // Sometimes over-funded
        
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => fake()->sentence(rand(3, 8)),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(rand(10, 20)),
            'goal_amount' => $goalAmount,
            'current_amount' => $currentAmount,
            'deadline' => fake()->dateTimeBetween('now', '+6 months'),
            'status' => fake()->randomElement(['active', 'paused', 'completed']),
            'image_path' => null, // Will add image handling later
            'category' => fake()->randomElement([
                'Technology', 'Art', 'Music', 'Film', 'Games', 
                'Publishing', 'Fashion', 'Food', 'Health', 'Education'
            ]),
            'backers_count' => fake()->numberBetween(0, 500),
            'featured' => fake()->boolean(20), // 20% chance of being featured
        ];
    }
}
