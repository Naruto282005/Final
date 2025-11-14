<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class EditPost extends Component
{
    public $post; // The post being edited
    public $title = '';
    public $content = '';
    public $category = '';

    // Validation rules
    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'category' => 'required'
    ];

    /**
     * Mount component with post data
     */
    public function mount($id)
    {
        $this->post = Post::findOrFail($id);

        // Check if user owns this post
        if ($this->post->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load existing data
        $this->title = $this->post->title;
        $this->content = $this->post->content;
        $this->category = $this->post->category;
    }

    /**
     * Update the post
     */
    public function update()
    {
        // Validate input
        $this->validate();

        // Update post
        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
        ]);

        // Flash success message
        session()->flash('message', 'Post updated successfully!');

        // Redirect to post detail
        return redirect()->route('post.show', $this->post->id);
    }

    public function render()
    {
        return view('livewire.edit-post')->layout('layouts.app');
    }
}