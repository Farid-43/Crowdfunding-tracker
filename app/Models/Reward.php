<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'minimum_amount',
        'maximum_backers',
        'current_backers',
        'estimated_delivery',
        'is_available',
        'sort_order',
        'included_items',
        'shipping_info',
    ];

    protected $casts = [
        'minimum_amount' => 'decimal:2',
        'estimated_delivery' => 'date',
        'is_available' => 'boolean',
        'included_items' => 'array', // Cast to array for JSON storage
    ];

    /**
     * Get the campaign that owns this reward
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get donations that selected this reward
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Check if reward is available for selection
     */
    public function isAvailable(): bool
    {
        if (!$this->is_available) {
            return false;
        }

        // Check if maximum backers limit is reached
        if ($this->maximum_backers && $this->current_backers >= $this->maximum_backers) {
            return false;
        }

        return true;
    }

    /**
     * Get remaining spots for this reward
     */
    public function getRemainingBackersAttribute(): ?int
    {
        if (!$this->maximum_backers) {
            return null; // Unlimited
        }

        return max(0, $this->maximum_backers - $this->current_backers);
    }

    /**
     * Get availability status text
     */
    public function getAvailabilityStatusAttribute(): string
    {
        if (!$this->is_available) {
            return 'Unavailable';
        }

        if ($this->maximum_backers) {
            if ($this->current_backers >= $this->maximum_backers) {
                return 'Sold Out';
            }
            return $this->remaining_backers . ' of ' . $this->maximum_backers . ' left';
        }

        return 'Available';
    }

    /**
     * Scope for available rewards
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
                    ->where(function($q) {
                        $q->whereNull('maximum_backers')
                          ->orWhereRaw('current_backers < maximum_backers');
                    });
    }

    /**
     * Scope for ordering rewards by minimum amount
     */
    public function scopeByAmount($query)
    {
        return $query->orderBy('minimum_amount', 'asc');
    }

    /**
     * Scope for ordering rewards by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('minimum_amount', 'asc');
    }
}
