<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug when creating a category
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        // Update slug when name changes
        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    /**
     * Get the campaigns that belong to this category
     */
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class, 'campaign_category')
                    ->withTimestamps();
    }

    /**
     * Scope to get only active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order categories by sort order and name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get campaigns count for this category
     */
    public function getCampaignCountAttribute()
    {
        return $this->campaigns()->count();
    }

    /**
     * Get active campaigns count for this category
     */
    public function getActiveCampaignCountAttribute()
    {
        return $this->campaigns()
                    ->where('status', 'active')
                    ->where('deadline', '>', now())
                    ->count();
    }

    /**
     * Get the route key for model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Generate a unique slug for the category
     */
    public static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = 1;
        
        while (static::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }
        
        return $slug;
    }
}
