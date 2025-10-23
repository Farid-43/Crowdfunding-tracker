# 🚀 Crowdfunding Tracker

A full-featured crowdfunding platform built with Laravel 11, featuring campaign management, donation processing, real-time progress tracking, and comprehensive admin controls.

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat-square&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📋 Table of Contents

-   [Features](#-features)
-   [Tech Stack](#-tech-stack)
-   [Installation](#-installation)
-   [Database Setup](#-database-setup)
-   [Usage](#-usage)
-   [Project Structure](#-project-structure)
-   [API Documentation](#-api-documentation)
-   [Lab Topics Covered](#-lab-topics-covered)
-   [Screenshots](#-screenshots)
-   [Contributing](#-contributing)
-   [License](#-license)

## ✨ Features

### 🎯 Campaign Management

-   **Create & Edit Campaigns** - Full CRUD operations with rich text descriptions
-   **Category System** - Multiple categories per campaign (Technology, Art, Music, Film, etc.)
-   **Status Management** - Active, Paused, Completed, Cancelled states
-   **Image Support** - Campaign images via URL (Unsplash integration)
-   **Progress Tracking** - Real-time funding percentage and backers count
-   **Deadline System** - Automatic campaign expiration handling
-   **Advanced Search** - Search by keyword, category, funding status, and goals
-   **Filtering & Sorting** - Multi-criteria campaign discovery

### 💰 Donation System

-   **Flexible Donations** - Support any amount above minimum
-   **Reward Tiers** - Create and manage campaign rewards
-   **Anonymous Donations** - Optional anonymous backing
-   **Payment Processing** - Secure donation handling
-   **Donation History** - Track all contributions per user/campaign
-   **Quick Donate Modal** - AJAX donation without page refresh
-   **Thank You Pages** - Personalized confirmation pages

### 👥 User Management

-   **Authentication** - Laravel Breeze integration with modern UI
-   **User Roles** - Admin and Regular user roles
-   **User Dashboard** - Personal campaign and donation tracking
-   **Profile Management** - Update user information and view activity
-   **Profile Pages** - Public profiles with user contributions
-   **Contact System** - Built-in contact form with admin management

### 🎨 Admin Dashboard

-   **Analytics** - Platform-wide statistics and insights
-   **Campaign Oversight** - Manage all campaigns
-   **User Management** - View and manage all users
-   **Comment Moderation** - Pin, edit, and delete comments
-   **Contact Management** - Handle user inquiries

### 💬 Community Features

-   **Comments System** - Campaign discussions with edit/delete
-   **Comment Threading** - Organized conversations
-   **Pinned Comments** - Highlight important updates
-   **Owner Badges** - Visual campaign creator identification

### 🔧 Advanced Features

-   **REST API** - JSON endpoints for external integrations
-   **AJAX Donations** - Real-time donation modal without page refresh
-   **Search & Filtering** - Multi-criteria campaign discovery
-   **Pagination** - Efficient large dataset handling
-   **Responsive Design** - Modern Tailwind CSS UI with gradients and animations
-   **Session Management** - Recently viewed campaigns and user preferences
-   **Flash Messages** - Beautiful animated notifications
-   **About Page** - Comprehensive platform information

## 🎨 UI/UX Highlights

### Modern Design System

-   **Gradient Backgrounds**: 3-color gradients (indigo → purple → pink)
-   **Glassmorphism Effects**: Backdrop blur with transparency
-   **Smooth Animations**: Hover effects, transitions, and transforms
-   **Consistent Icon Alignment**: Perfect vertical alignment in forms
-   **Responsive Cards**: Scale and shadow effects on interaction
-   **Clean Forms**: Centered, modern authentication pages

### Key Pages

-   **Home**: Hero section with animated SVG patterns, stats cards, campaign showcase
-   **About**: Mission/vision cards, impact statistics, company story, values section
-   **Authentication**: Clean centered forms with icons, no split-screen design
-   **Campaigns**: Enhanced card layouts with hover effects
-   **Dashboards**: User and admin dashboards with analytics

## 🛠️ Tech Stack

### Backend

-   **Framework**: Laravel 11
-   **Language**: PHP 8.2+
-   **Authentication**: Laravel Breeze with modern UI
-   **Database**: MySQL 8.0
-   **ORM**: Eloquent

### Frontend

-   **CSS Framework**: Tailwind CSS 3.4
-   **UI Design**: Modern Tailwind UI patterns (gradients, glassmorphism, animations)
-   **JavaScript**: Alpine.js 3.14
-   **Build Tool**: Vite 5.0
-   **Icons**: Heroicons SVG icons

### Development Tools

-   **Package Manager**: Composer
-   **Node Package Manager**: npm
-   **Version Control**: Git
-   **Database Migrations**: Laravel Migrations
-   **Seeding**: Laravel Seeders with Faker

## 📦 Installation

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   MySQL 5.7+ or MariaDB 10.3+
-   Node.js & npm (for asset compilation)

### Step 1: Clone the Repository

```bash
git clone https://github.com/Farid-43/Crowdfunding-tracker.git
cd Crowdfunding-tracker
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 3: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crowdfunding_tracker
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 5: Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed
```

### Step 6: Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Step 7: Start Development Server

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000` in your browser.

## 🗄 Database Setup

### Default User Accounts

After seeding, you'll have these test accounts:

**Admin Account:**

-   Email: `admin@crowdfunder.com`
-   Password: `password123`
-   Role: Admin

**Regular User Account:**

-   Email: `user@crowdfunder.com`
-   Password: `password123`
-   Role: User

### Database Structure

**Main Tables:**

-   `users` - User accounts and authentication
-   `campaigns` - Campaign information
-   `categories` - Campaign categories
-   `campaign_category` - Many-to-many relationship
-   `donations` - Donation records
-   `rewards` - Campaign reward tiers
-   `comments` - Campaign comments

## 🎮 Usage

### Creating a Campaign

1. **Register/Login** to your account
2. Click **"Start a Campaign"** or **"New Campaign"**
3. Fill in campaign details:
    - Title & Description
    - Funding Goal ($100 - $1,000,000)
    - Deadline (1 day - 1 year)
    - Category (select 1-3)
    - Campaign Image URL (optional)
4. Click **"Create Campaign"**

### Making a Donation

1. Browse campaigns at `/campaigns`
2. Click on a campaign to view details
3. Click **"Donate Now"** or **"Quick Donate"**
4. Enter donation amount and details
5. Optional: Select a reward tier
6. Submit donation

### Admin Features

1. Login with admin account
2. Access admin dashboard at `/admin`
3. Available actions:
    - View platform statistics
    - Manage all campaigns
    - Manage users
    - View analytics and reports
    - Manage categories

## 📁 Project Structure

```
crowdfunding-tracker/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── CampaignController.php
│   │   │   ├── DonationController.php
│   │   │   ├── CommentController.php
│   │   │   ├── RewardController.php
│   │   │   └── Api/
│   │   │       └── CampaignController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Campaign.php
│       ├── Donation.php
│       ├── Reward.php
│       ├── Comment.php
│       └── Category.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── UserSeeder.php
│   │   ├── CategorySeeder.php
│   │   └── CampaignSeeder.php
│   └── factories/
│       ├── CampaignFactory.php
│       └── UserFactory.php
├── resources/
│   ├── views/
│   │   ├── campaigns/
│   │   ├── donations/
│   │   ├── admin/
│   │   ├── layouts/
│   │   └── home.blade.php
│   └── css/
│       └── app.css
├── routes/
│   ├── web.php
│   └── api.php
└── public/
    └── index.php
```

## 🔌 API Documentation

### Base URL

```
http://127.0.0.1:8000/api
```

### Endpoints

#### Get All Campaigns

```http
GET /api/campaigns
```

**Response:**

```json
{
    "data": [
        {
            "id": 1,
            "title": "Smart Home IoT Device",
            "goal_amount": 25000,
            "current_amount": 18500,
            "deadline": "2025-04-15",
            "status": "active",
            "category": "Technology"
        }
    ]
}
```

#### Get Single Campaign

```http
GET /api/campaigns/{id}
```

#### Make a Donation (Authenticated)

```http
POST /api/campaigns/{id}/donate
```

**Headers:**

```
Content-Type: application/json
X-CSRF-TOKEN: {token}
```

**Body:**

```json
{
    "amount": 100,
    "donor_name": "John Doe",
    "donor_email": "john@example.com",
    "anonymous": false,
    "reward_id": 1
}
```

#### Platform Statistics

```http
GET /api/stats
```

#### Health Check

```http
GET /api/health
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 👨‍💻 Author

**Farid Patwary**

-   GitHub: [@Farid-43](https://github.com/Farid-43)
-   Email: faridpatwary2020@gmail.com

## 🙏 Acknowledgments

-   Laravel Framework Team
-   Tailwind CSS
-   Unsplash (for placeholder images)
-   All contributors and testers

## 📞 Support

For support, email faridpatwary2020@gmail.com or open an issue in the GitHub repository.

---
