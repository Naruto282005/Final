<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-2xl font-bold mb-6">Create a New Post</h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-4">
            {{-- Title Input --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                <input type="text" 
                       wire:model="title" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="Enter an interesting title...">
                @error('title') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Category Select --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select wire:model="category" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
                          rows="8" 
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Share your thoughts..."></textarea>
                @error('content') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Media Upload --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Image / Video (optional)</label>
                <input type="file" 
                       wire:model="media" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('media') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror

                @if ($media)
                    <div class="mt-3 space-y-2">
                        @php
                            $mime = $media->getMimeType();
                            $isImage = str_starts_with($mime, 'image/');
                            $isVideo = str_starts_with($mime, 'video/');
                        @endphp

                        @if ($isImage)
                            <img src="{{ $media->temporaryUrl() }}" alt="Preview" class="max-h-64 rounded-lg border border-gray-200 object-contain">
                        @elseif ($isVideo)
                            <video controls class="w-full max-h-80 rounded-lg border border-gray-200">
                                <source src="{{ $media->temporaryUrl() }}">
                            </video>
                        @endif

                        <span class="text-xs text-gray-500">Preview of the file you selected. It will be uploaded when you post.</span>
                    </div>
                @endif
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('home') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Post
                </button>
            </div>
        </form>
    </div>
</div>