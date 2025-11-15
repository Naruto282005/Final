<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = ['user_id', 'title', 'content', 'category', 'vote_count', 'comment_count', 'media_path', 'media_type'];

    /**
     * Get the user who created this post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all comments for this post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get all votes for this post
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    /**
     * Check if current user has voted on this post
     */
    public function userVote()
    {
        if (!auth()->check()) return null;
        
        return $this->votes()
            ->where('user_id', auth()->id())
            ->first();
    }
}