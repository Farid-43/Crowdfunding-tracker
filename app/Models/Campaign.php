<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'short_description',
        'goal_amount',
        'current_amount',
        'deadline',
        'status',
        'image_path',
        'category',
        'backers_count',
        'featured'
    ];

    protected $casts = [
        'goal_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'deadline' => 'date',
        'featured' => 'boolean',
        'backers_count' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all donations for this campaign
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get all completed donations for this campaign
     */
    public function completedDonations()
    {
        return $this->donations()->completed();
    }

    /**
     * Get public donations (non-anonymous) for display
     */
    public function publicDonations()
    {
        return $this->donations()->public()->completed();
    }

    // In future: comments, rewards relationships will be added

    // Helper methods
    public function getProgressPercentageAttribute()
    {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100, 1));
    }

    public function getDaysRemainingAttribute()
    {
        $now = Carbon::now();
        $deadline = Carbon::parse($this->deadline);
        
        if ($deadline->isPast()) {
            return 0;
        }
        
        return $now->diffInDays($deadline);
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::parse($this->deadline)->isPast();
    }

    public function getIsSuccessfulAttribute()
    {
        return $this->current_amount >= $this->goal_amount;
    }

    public function getAmountRemainingAttribute()
    {
        return max(0, $this->goal_amount - $this->current_amount);
    }

    // Scopes for filtering
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where('deadline', '>=', Carbon::now());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
