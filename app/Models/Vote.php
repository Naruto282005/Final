<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'voteable_id', 'voteable_type', 'vote'];

    /**
     * Get the voteable model (Post or Comment)
     */
    public function voteable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user who made this vote
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}