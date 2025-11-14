<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class CreatePost extends Component
{
    public $title = ''; // Post title
    public $content = ''; // Post content
    public $category = 'general'; // Selected category

    // Validation rules
    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'category' => 'required'
    ];

    /**
     * Create a new post
     */
    public function submit()
    {
        $this->validate();

        Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
        ]);

        session()->flash('message', 'Post created successfully!');
        $this->reset(['title', 'content', 'category']);

        return redirect()->route('home');
    }

    public function render()
    {
        // ✅ explicitly use the correct layout
        return view('livewire.create-post')->layout('layouts.app');
    }
}
