<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Post;

class EditPost extends Component
{
    use WithFileUploads;

    public $post; // The post being edited
    public $title = '';
    public $content = '';
    public $category = '';
    public $media;
    public $removeMedia = false;

    // Validation rules
    protected $rules = [
        'title' => 'required|min:5|max:255',
        'content' => 'required|min:10',
        'category' => 'required',
        'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv|max:20480'
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

        $mediaPath = $this->post->media_path;
        $mediaType = $this->post->media_type;

        if ($this->removeMedia) {
            $mediaPath = null;
            $mediaType = null;
        }

        if ($this->media) {
            $mediaPath = $this->media->store('posts', 'public');
            $mime = $this->media->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $mediaType = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $mediaType = 'video';
            } else {
                $mediaType = null;
            }
        }

        // Update post
        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
            'media_path' => $mediaPath,
            'media_type' => $mediaType,
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