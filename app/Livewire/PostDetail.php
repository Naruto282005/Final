<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostDetail extends Component
{
    public $post; // The post being viewed

    /**
     * Mount component with post
     */
    public function mount($id)
    {
        $this->post = Post::with(['user', 'comments.user'])->findOrFail($id);
    }

    /**
     * Handle voting on the post
     */
    public function vote($voteType)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $existingVote = $this->post->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->vote == $voteType) {
                $this->post->decrement('vote_count', $existingVote->vote);
                $existingVote->delete();
            } else {
                $this->post->increment('vote_count', $voteType * 2);
                $existingVote->update(['vote' => $voteType]);
            }
        } else {
            $this->post->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $voteType
            ]);
            $this->post->increment('vote_count', $voteType);
        }

        // Refresh post data
        $this->post->refresh();
    }
    /**
     * Delete this post
     */
    public function deletePost()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if user owns this post
        if ($this->post->user_id !== auth()->id()) {
            session()->flash('error', 'You can only delete your own posts!');
            return;
        }

        // Delete the post
        $this->post->delete();

        session()->flash('message', 'Post deleted successfully!');

        // Redirect to home
        return redirect()->route('home');
    }

    public function render()
    {
      return view('livewire.post-detail')->layout('layouts.app');

    }
}