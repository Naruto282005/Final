<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;

class CreatePost extends Component
{
    use WithFileUploads;

    public $title = ''; // Post title
    public $content = ''; // Post content
    public $category = 'general'; // Selected category
    public $media;

    // Validation rules
    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'category' => 'required',
        'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv|max:20480'
    ];

    /**
     * Create a new post
     */
    public function submit()
    {
        $this->validate();

        $mediaPath = null;
        $mediaType = null;

        if ($this->media) {
            $mediaPath = $this->media->store('posts', 'public');
            $mime = $this->media->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $mediaType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $mediaType = 'video';
            }
        }

        Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
        ]);

        session()->flash('message', 'Post created successfully!');
        $this->reset(['title', 'content', 'category', 'media']);

        return redirect()->route('home');
    }

    public function render()
    {
        // ✅ explicitly use the correct layout
        return view('livewire.create-post')->layout('layouts.app');
    }
}
