<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@crowdfunder.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'John Doe',
            'email' => 'user@crowdfunder.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        echo "✅ Admin user created: admin@crowdfunder.com (password: password123)\n";
        echo "✅ Test user created: user@crowdfunder.com (password: password123)\n";
    }
}
