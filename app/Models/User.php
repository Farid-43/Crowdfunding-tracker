<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * User has many campaigns (one-to-many relationship)
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    /**
     * User has many donations (one-to-many relationship)
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get user's completed donations
     */
    public function completedDonations()
    {
        return $this->donations()->completed();
    }

    /**
     * Get total amount donated by user
     */
    public function getTotalDonatedAttribute()
    {
        return $this->completedDonations()->sum('amount');
    }

    /**
     * Get number of campaigns user has supported
     */
    public function getCampaignsSupportedCountAttribute()
    {
        return $this->completedDonations()->distinct('campaign_id')->count('campaign_id');
    }

    /**
     * Scope to get only admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope to get only regular users
     */
    public function scopeUsers($query)
    {
        return $query->where('role', 'user');
    }
}
