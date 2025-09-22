<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'content',
        'is_pinned',
        'is_edited',
        'edited_at',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime',
    ];

    /**
     * Get the user that created the comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the campaign this comment belongs to
     */
    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Scope to get only pinned comments
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope to get comments ordered by pinned first, then newest
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');
    }

    /**
     * Check if comment can be edited by user
     */
    public function canBeEditedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Admin can edit any comment
        if ($user->role === 'admin') {
            return true;
        }

        // Users can edit their own comments within 15 minutes
        if ($this->user_id === $user->id && $this->created_at->diffInMinutes(now()) <= 15) {
            return true;
        }

        return false;
    }

    /**
     * Check if comment can be deleted by user
     */
    public function canBeDeletedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Admin can delete any comment
        if ($user->role === 'admin') {
            return true;
        }

        // Users can delete their own comments
        if ($this->user_id === $user->id) {
            return true;
        }

        // Campaign owners can delete comments on their campaigns
        if ($this->campaign->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Mark comment as edited
     */
    public function markAsEdited(): void
    {
        $this->update([
            'is_edited' => true,
            'edited_at' => now(),
        ]);
    }
}
