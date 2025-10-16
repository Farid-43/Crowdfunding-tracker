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
        
        // Define realistic campaigns by category with matching images
        $categoryTemplates = [
            'Technology' => [
                'titles' => [
                    'Smart Home IoT Device Revolution',
                    'AI-Powered Mobile App Development',
                    'Open Source Code Editor Enhancement',
                    'Blockchain Payment Gateway Platform',
                    'VR Gaming Headset Innovation',
                    'Cybersecurity Tool for Small Business',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=800&h=600&fit=crop', // Tech workspace
                    'https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?w=800&h=600&fit=crop', // Laptop coding
                    'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=800&h=600&fit=crop', // Technology circuit
                    'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800&h=600&fit=crop', // AI/Tech
                ]
            ],
            'Art' => [
                'titles' => [
                    'Contemporary Art Gallery Exhibition',
                    'Street Art Mural Project Downtown',
                    'Digital Illustration Book Collection',
                    'Sculpture Installation in Public Park',
                    'Mixed Media Art Studio Workshop',
                    'Photography Portfolio Coffee Table Book',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?w=800&h=600&fit=crop', // Art supplies
                    'https://images.unsplash.com/photo-1547891654-e66ed7ebb968?w=800&h=600&fit=crop', // Paint brushes
                    'https://images.unsplash.com/photo-1561214115-f2f134cc4912?w=800&h=600&fit=crop', // Gallery
                    'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=800&h=600&fit=crop', // Painting
                ]
            ],
            'Music' => [
                'titles' => [
                    'Indie Album Recording and Production',
                    'Music Festival for Emerging Artists',
                    'Guitar Workshop and Tutorial Series',
                    'Orchestra Performance Tour Funding',
                    'Electronic Music Production Software',
                    'Vinyl Record Pressing for Local Bands',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800&h=600&fit=crop', // Acoustic guitar
                    'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800&h=600&fit=crop', // Music studio
                    'https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?w=800&h=600&fit=crop', // Concert
                    'https://images.unsplash.com/photo-1519508234439-4f23643125c1?w=800&h=600&fit=crop', // Headphones
                ]
            ],
            'Film' => [
                'titles' => [
                    'Independent Short Film Production',
                    'Documentary About Climate Change',
                    'Animated Feature Film Development',
                    'Film Festival Screening Tour',
                    'Video Production Equipment Upgrade',
                    'Script to Screen: First Feature Film',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=800&h=600&fit=crop', // Film camera
                    'https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&h=600&fit=crop', // Movie theater
                    'https://images.unsplash.com/photo-1440404653325-ab127d49abc1?w=800&h=600&fit=crop', // Film set
                    'https://images.unsplash.com/photo-1574267432644-f74f8ec55480?w=800&h=600&fit=crop', // Cinema
                ]
            ],
            'Games' => [
                'titles' => [
                    'Indie RPG Video Game Development',
                    'Board Game Manufacturing and Distribution',
                    'Mobile Gaming App with AR Features',
                    'Retro Arcade Cabinet Restoration',
                    'Educational Puzzle Game for Kids',
                    'Multiplayer Strategy Game Platform',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800&h=600&fit=crop', // Gaming controller
                    'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&h=600&fit=crop', // Arcade
                    'https://images.unsplash.com/photo-1556438064-2d7646166914?w=800&h=600&fit=crop', // Board games
                    'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=800&h=600&fit=crop', // Gaming setup
                ]
            ],
            'Publishing' => [
                'titles' => [
                    'First Novel Manuscript Publication',
                    'Children\'s Book Illustration Series',
                    'Poetry Anthology from Local Writers',
                    'Magazine Launch for Creative Writing',
                    'Comic Book Series Issue 1-5',
                    'Self-Publishing Platform for Authors',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?w=800&h=600&fit=crop', // Books
                    'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=800&h=600&fit=crop', // Open book
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=800&h=600&fit=crop', // Library
                    'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800&h=600&fit=crop', // Writing
                ]
            ],
            'Fashion' => [
                'titles' => [
                    'Sustainable Clothing Line Launch',
                    'Handmade Leather Accessories Collection',
                    'Fashion Show for Emerging Designers',
                    'Eco-Friendly Fabric Production',
                    'Custom Tailoring Workshop Series',
                    'Vintage Fashion Boutique Opening',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1445205170230-053b83016050?w=800&h=600&fit=crop', // Fashion
                    'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=800&h=600&fit=crop', // Clothing store
                    'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=800&h=600&fit=crop', // Fashion design
                    'https://images.unsplash.com/photo-1558769132-cb1aea8f82a1?w=800&h=600&fit=crop', // Sewing
                ]
            ],
            'Food' => [
                'titles' => [
                    'Food Truck Business Startup',
                    'Organic Farm to Table Restaurant',
                    'Cookbook Publication with Family Recipes',
                    'Artisan Bakery Equipment Upgrade',
                    'Cooking Classes and Culinary School',
                    'Specialty Coffee Roasting Facility',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=800&h=600&fit=crop', // Food spread
                    'https://images.unsplash.com/photo-1476224203421-9ac39bcb3327?w=800&h=600&fit=crop', // Cooking
                    'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&h=600&fit=crop', // Coffee
                    'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&h=600&fit=crop', // Restaurant
                ]
            ],
            'Health' => [
                'titles' => [
                    'Mental Health Support Mobile App',
                    'Yoga Studio Community Center',
                    'Fitness Equipment for Local Gym',
                    'Nutrition Coaching Program Launch',
                    'Meditation and Wellness Retreat',
                    'Home Exercise Video Series Production',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop', // Fitness
                    'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=800&h=600&fit=crop', // Yoga
                    'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?w=800&h=600&fit=crop', // Wellness
                    'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&h=600&fit=crop', // Healthcare
                ]
            ],
            'Education' => [
                'titles' => [
                    'STEM Learning Kit for Underserved Schools',
                    'Online Coding Bootcamp Platform',
                    'Language Learning App Development',
                    'After-School Tutoring Program Expansion',
                    'Educational Podcast Series for Kids',
                    'Virtual Reality Science Laboratory',
                ],
                'images' => [
                    'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&h=600&fit=crop', // Education
                    'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800&h=600&fit=crop', // Students
                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&h=600&fit=crop', // Classroom
                    'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&h=600&fit=crop', // University
                ]
            ],
        ];
        
        $category = fake()->randomElement(array_keys($categoryTemplates));
        $template = $categoryTemplates[$category];
        
        // Pick a random title and image from the category
        $title = fake()->randomElement($template['titles']);
        $image = fake()->randomElement($template['images']);
        
        // Generate description based on category
        $description = "This exciting {$category} project aims to bring innovation and creativity to life. " .
                      fake()->paragraphs(2, true) . 
                      " Join us in making this vision a reality!";
        
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $title,
            'description' => $description,
            'short_description' => fake()->sentence(rand(10, 20)),
            'goal_amount' => $goalAmount,
            'current_amount' => $currentAmount,
            'deadline' => fake()->dateTimeBetween('now', '+6 months'),
            'status' => fake()->randomElement(['active', 'active', 'active', 'active', 'paused', 'completed']), // 66% active
            'image_path' => $image,
            'category' => $category,
            'backers_count' => fake()->numberBetween(0, 500),
            'featured' => fake()->boolean(20), // 20% chance of being featured
        ];
    }
}
