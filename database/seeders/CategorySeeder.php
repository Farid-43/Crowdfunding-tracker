<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Innovative tech projects, apps, gadgets, and digital solutions',
                'color' => '#3B82F6',
                'icon' => 'fas fa-laptop',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Arts & Culture',
                'slug' => 'arts-culture',
                'description' => 'Creative projects, music, films, books, and cultural initiatives',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-palette',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Environment',
                'slug' => 'environment',
                'description' => 'Eco-friendly projects, sustainability, and environmental protection',
                'color' => '#10B981',
                'icon' => 'fas fa-leaf',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Learning platforms, educational resources, and academic projects',
                'color' => '#F59E0B',
                'icon' => 'fas fa-graduation-cap',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Healthcare innovations, fitness, mental health, and wellness projects',
                'color' => '#EF4444',
                'icon' => 'fas fa-heartbeat',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Social Impact',
                'slug' => 'social-impact',
                'description' => 'Community projects, charity initiatives, and social good campaigns',
                'color' => '#06B6D4',
                'icon' => 'fas fa-hands-helping',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Business & Entrepreneurship',
                'slug' => 'business-entrepreneurship',
                'description' => 'Startups, business ventures, and entrepreneurial projects',
                'color' => '#6366F1',
                'icon' => 'fas fa-briefcase',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Video games, board games, and interactive entertainment',
                'color' => '#EC4899',
                'icon' => 'fas fa-gamepad',
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'name' => 'Food & Beverage',
                'slug' => 'food-beverage',
                'description' => 'Culinary projects, restaurants, food products, and beverage innovations',
                'color' => '#F97316',
                'icon' => 'fas fa-utensils',
                'is_active' => true,
                'sort_order' => 9,
            ],
            [
                'name' => 'Sports & Fitness',
                'slug' => 'sports-fitness',
                'description' => 'Athletic projects, fitness equipment, sports teams, and training programs',
                'color' => '#84CC16',
                'icon' => 'fas fa-running',
                'is_active' => true,
                'sort_order' => 10,
            ],
            [
                'name' => 'Travel & Adventure',
                'slug' => 'travel-adventure',
                'description' => 'Travel experiences, adventure projects, and exploration initiatives',
                'color' => '#14B8A6',
                'icon' => 'fas fa-map-marked-alt',
                'is_active' => true,
                'sort_order' => 11,
            ],
            [
                'name' => 'Fashion & Design',
                'slug' => 'fashion-design',
                'description' => 'Clothing lines, accessories, industrial design, and fashion innovation',
                'color' => '#A855F7',
                'icon' => 'fas fa-tshirt',
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
