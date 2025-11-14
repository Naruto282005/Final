<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Post;

class CommentSection extends Component
{
    public $post; // The post we're commenting on
    public $content = ''; // Comment content

    // Validation rules
    protected $rules = [
        'content' => 'required|min:3|max:1000'
    ];

    /**
     * Initialize component with post
     */
    public function mount(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Submit a new comment
     */
    public function submitComment()
    {
        // Check if user is logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Validate comment
        $this->validate();

        // Create comment
        $this->post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $this->content,
        ]);

        // Increment comment count on post
        $this->post->increment('comment_count');

        // Reset form
        $this->content = '';

        // Refresh post to show new comment
        $this->post->load('comments.user');

        session()->flash('comment-success', 'Comment posted!');
    }

    /**
     * Vote on a comment
     */
    public function voteComment($commentId, $voteType)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $comment = Comment::findOrFail($commentId);
        $existingVote = $comment->votes()->where('user_id', auth()->id())->first();

        if ($existingVote) {
            if ($existingVote->vote == $voteType) {
                $comment->decrement('vote_count', $existingVote->vote);
                $existingVote->delete();
            } else {
                $comment->increment('vote_count', $voteType * 2);
                $existingVote->update(['vote' => $voteType]);
            }
        } else {
            $comment->votes()->create([
                'user_id' => auth()->id(),
                'vote' => $voteType
            ]);
            $comment->increment('vote_count', $voteType);
        }

        // Refresh comments
        $this->post->load('comments.user');
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}