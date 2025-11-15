<div class="max-w-3xl mx-auto">
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Edit Post</h2>
            <a href="{{ route('post.show', $post->id) }}" class="text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="update" class="space-y-4">
            {{-- Title Input --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" 
                       wire:model="title" 
                       class="input-field"
                       placeholder="Enter an interesting title...">
                @error('title') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Category Select --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select wire:model="category" 
                        class="input-field">
                    <option value="general">General</option>
                    <option value="programming">Programming</option>
                    <option value="ai">AI & ML</option>
                    <option value="hardware">Hardware</option>
                    <option value="security">Security</option>
                    <option value="web">Web Dev</option>
                </select>
                @error('category') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Content Textarea --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea wire:model="content" 
                          rows="10" 
                          class="input-field"
                          placeholder="Share your thoughts..."></textarea>
                @error('content') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Media Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image / Video</label>

                @if ($post->media_path)
                    <div class="mb-3 space-y-2">
                        @if ($post->media_type === 'image')
                            <img src="{{ asset('storage/' . $post->media_path) }}" alt="Post media" class="max-h-64 rounded-lg border border-gray-200">
                        @elseif ($post->media_type === 'video')
                            <video controls class="w-full max-h-96 rounded-lg border border-gray-200">
                                <source src="{{ asset('storage/' . $post->media_path) }}">
                            </video>
                        @endif

                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" wire:model="removeMedia" class="rounded border-gray-300">
                            <span>Remove current media</span>
                        </label>
                    </div>
                @endif

                <input type="file" 
                       wire:model="media" 
                       class="input-field">
                @error('media') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror

                @if ($media)
                    <div class="mt-2 space-y-2">
                        @php
                            $mime = $media->getMimeType();
                            $isImage = str_starts_with($mime, 'image/');
                            $isVideo = str_starts_with($mime, 'video/');
                        @endphp

                        @if ($isImage)
                            <img src="{{ $media->temporaryUrl() }}" alt="New media preview" class="max-h-64 rounded-lg border border-gray-200 object-contain">
                        @elseif ($isVideo)
                            <video controls class="w-full max-h-80 rounded-lg border border-gray-200">
                                <source src="{{ $media->temporaryUrl() }}">
                            </video>
                        @endif

                        <span class="text-xs text-gray-500">New file selected. It will replace the current media when you update.</span>
                    </div>
                @endif
            </div>

            {{-- Submit Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('post.show', $post->id) }}" class="btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn-primary">
                    Update Post
                </button>
            </div>
        </form>
    </div>
</div>