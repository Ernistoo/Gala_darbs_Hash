<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'challenge_id',
        'user_id',
        'image',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(SubmissionVote::class);
    }

    
    public function hasUpvoted(User $user)
    {
        return $this->votes()->where('user_id', $user->id)->exists();
    }
}
