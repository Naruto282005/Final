<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostList extends Component
{
    public $category = 'all'; // Current selected category
    public $sortBy = 'recent'; // ✅ CHANGED: Sorting method - default to 'recent' so new posts appear first

    /**
     * Use the main layout
     */
    protected $layout = 'layouts.app';

    /**
     * Filter posts by category
     */
    public function filterCategory($category)
    {
        $this->category = $category;
    }

    /**
     * Change sorting method
     */
    public function sortBy($method)
    {
        $this->sortBy = $method;
    }

    /**
     * Handle upvote on a post
     */
    public function vote($postId, $voteType)
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $post = Post::findOrFail($postId);
        $existingVote = $post->votes()->where('user_id', auth()->id())->first();

        // If user already voted
        if ($existingVote) {
            // If clicking same vote, remove it
            if ($existingVote->vote == $voteType) {
                $post->decrement('vote_count', $existingVote->vote);
                $existingVote->delete();
            } else {
                // Change vote direction
                $post->increment('vote_count', $voteType * 2);
                $existingVote->update(['vote' => $voteType]);
            }
        } else {
            // Create new vote
            $post->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $voteType
            ]);
            $post->increment('vote_count', $voteType);
        }
    }

    public function render()
    {
        // Get posts based on filters
        $query = Post::with(['user', 'comments']);

        // Filter by category
        if ($this->category !== 'all') {
            $query->where('category', $this->category);
        }

        // ✅ IMPROVED: Sort posts with better logic
        if ($this->sortBy === 'popular') {
            $query->orderBy('vote_count', 'desc')
                  ->orderBy('created_at', 'desc'); // Secondary sort by date
        } elseif ($this->sortBy === 'recent') {
            $query->latest(); // Orders by created_at DESC (newest first)
        } elseif ($this->sortBy === 'discussed') {
            $query->orderBy('comment_count', 'desc')
                  ->orderBy('created_at', 'desc'); // Secondary sort by date
        } else {
            // ✅ ADDED: Default fallback - show newest first
            $query->latest();
        }

        $posts = $query->get();

        return view('livewire.post-list', [
            'posts' => $posts
        ])->layout('layouts.app');
    }
}