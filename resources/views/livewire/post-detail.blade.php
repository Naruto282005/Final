<div class="max-w-4xl mx-auto space-y-6">
    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Post Card --}}
    <div class="card">
        <div class="flex">
            {{-- Vote Section --}}
            <div class="flex flex-col items-center p-6 bg-gradient-to-b from-gray-50 to-gray-100 border-r border-gray-200 rounded-l-lg">
                <button wire:click="vote(1)" 
                        class="vote-btn text-gray-400 hover:text-orange-500 {{ $post->userVote()?->vote === 1 ? 'text-orange-500 vote-btn-active' : '' }}">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3l6 6H4z"/>
                    </svg>
                </button>
                <span class="font-bold text-2xl my-2 {{ $post->vote_count > 0 ? 'text-orange-500' : ($post->vote_count < 0 ? 'text-blue-500' : 'text-gray-600') }}">
                    {{ $post->vote_count }}
                </span>
                <button wire:click="vote(-1)" 
                        class="vote-btn text-gray-400 hover:text-blue-500 {{ $post->userVote()?->vote === -1 ? 'text-blue-500 vote-btn-active' : '' }}">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 17l6-6H4z"/>
                    </svg>
                </button>
            </div>

            {{-- Post Content --}}
            <div class="flex-1 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <span class="font-medium text-gray-700">{{ $post->user->name }}</span>
                        </div>
                        <span>•</span>
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            {{ $post->category === 'programming' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $post->category === 'ai' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $post->category === 'hardware' ? 'bg-orange-100 text-orange-700' : '' }}
                            {{ $post->category === 'security' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $post->category === 'web' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $post->category === 'general' ? 'bg-gray-100 text-gray-700' : '' }}">
                            {{ ucfirst($post->category) }}
                        </span>
                    </div>

                    {{-- Edit/Delete Buttons (Only for post owner) --}}
                    @auth
                        @if(auth()->id() === $post->user_id)
                            <div class="flex items-center gap-2" x-data="{ showDeleteConfirm: false }">
                                {{-- Edit Button --}}
                                <a href="{{ route('post.edit', $post->id) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                   title="Edit post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                {{-- Delete Button --}}
                                <button @click="showDeleteConfirm = true"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        title="Delete post">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                {{-- Delete Confirmation Modal --}}
                                <div x-show="showDeleteConfirm" 
                                     x-transition
                                     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center"
                                     @click.self="showDeleteConfirm = false">
                                    <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-2xl">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Post?</h3>
                                        <p class="text-gray-600 mb-6">Are you sure you want to delete this post? This action cannot be undone.</p>
                                        <div class="flex gap-3 justify-end">
                                            <button @click="showDeleteConfirm = false" 
                                                    class="btn-secondary">
                                                Cancel
                                            </button>
                                            <button wire:click="deletePost" 
                                                    @click="showDeleteConfirm = false"
                                                    class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors duration-200">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
                <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $post->content }}</div>
            </div>
        </div>
    </div>

    {{-- Comments Section --}}
    <livewire:comment-section :post="$post" />
</div>