<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_photo',
        'bio',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    public function friendOf()
    {
        return $this->belongsToMany(User::class, 'friendships', 'friend_id', 'user_id')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    public function allFriends()
    {
        return $this->friends->merge($this->friendOf);
    }

    public function friendRequests()
    {
        return $this->hasMany(Friendship::class, 'friend_id')
            ->where('status', 'pending');
    }

    public function sentRequests()
    {
        return $this->hasMany(Friendship::class, 'user_id')
            ->where('status', 'pending');
    }

  

    public function getLevelAttribute()
    {
        $xp = $this->xp ?? 0;
        $level = 0;
        $threshold = 50;
    
        while ($xp >= $threshold) {
            $xp -= $threshold;
            $level++;
            $threshold *= 2;
        }
    
        return $level;
    }
    
    public function getXpProgressAttribute()
    {
        $xp = $this->xp ?? 0;
        $level = 0;
        $threshold = 50;
        $remaining = $xp;
        $totalNeeded = 50; 
    
        while ($remaining >= $threshold) {
            $remaining -= $threshold;
            $level++;
            $threshold *= 2;
            $totalNeeded += $threshold; 
        }
    
        $progress = ($xp / $totalNeeded) * 100;
    
        $remainingToNext = $totalNeeded - $xp;
    
        return [
            'level' => $level,
            'current_xp' => $xp,
            'needed_xp' => $totalNeeded,
            'progress_percent' => round(min($progress, 100), 1),
            'remaining_xp' => max($remainingToNext, 0),
        ];
    }

    public function submissions()
{
    return $this->hasMany(\App\Models\Submission::class);
}
    
}
