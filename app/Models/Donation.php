<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'amount',
        'donor_name',
        'donor_email',
        'message',
        'anonymous',
        'status',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'anonymous' => 'boolean',
    ];

    /**
     * Get the user who made the donation (can be null for guest donations)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the campaign that received the donation
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Get the donor name (from user or custom name)
     */
    public function getDonorNameAttribute(): string
    {
        if ($this->anonymous) {
            return 'Anonymous';
        }
        
        return $this->attributes['donor_name'] ?: $this->user?->name ?: 'Anonymous';
    }

    /**
     * Get the donor email (from user or custom email)
     */
    public function getDonorEmailAttribute(): string
    {
        return $this->attributes['donor_email'] ?: $this->user?->email ?: '';
    }

    /**
     * Scope for public donations (non-anonymous)
     */
    public function scopePublic($query)
    {
        return $query->where('anonymous', false);
    }

    /**
     * Scope for completed donations
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
