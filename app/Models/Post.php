<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Like;
use App\Models\User;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'youtube_url',
        'category_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Check if a given user liked this post
    public function likedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_post');
    }

    public function category()
{
    return $this->belongsTo(Category::class);
}
}
