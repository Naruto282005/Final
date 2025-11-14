<div class="space-y-6 animate-fade-in">
    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header Section --}}
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome to TechForum</h1>
        <p class="text-gray-600 text-lg">Join the conversation about the latest in technology</p>
    </div>

    {{-- Category Filter with Modern Design --}}
    <div class="card p-6">
        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wide mb-4">📑 Browse by Category</h2>
        <div class="flex flex-wrap gap-3">
            <button wire:click="filterCategory('all')" 
                    class="category-badge {{ $category === 'all' ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All Topics
            </button>
            <button wire:click="filterCategory('programming')" 
                    class="category-badge {{ $category === 'programming' ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                💻 Programming
            </button>
            <button wire:click="filterCategory('ai')" 
                    class="category-badge {{ $category === 'ai' ? 'bg-gradient-to-r from-purple-500 to-pink-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                🤖 AI & ML
            </button>
            <button wire:click="filterCategory('hardware')" 
                    class="category-badge {{ $category === 'hardware' ? 'bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                🖥️ Hardware
            </button>
            <button wire:click="filterCategory('security')" 
                    class="category-badge {{ $category === 'security' ? 'bg-gradient-to-r from-red-500 to-rose-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                🔒 Security
            </button>
            <button wire:click="filterCategory('web')" 
                    class="category-badge {{ $category === 'web' ? 'bg-gradient-to-r from-blue-500 to-cyan-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                🌐 Web Dev
            </button>
        </div>
    </div>

    {{-- Sort Options with Icons --}}
    <div class="card p-4">
        <div class="flex items-center gap-6">
            <span class="text-sm font-medium text-gray-500">Sort by:</span>
            <button wire:click="sortBy('popular')" 
                    class="flex items-center gap-2 text-sm font-medium transition-colors duration-200 {{ $sortBy === 'popular' ? 'text-orange-600' : 'text-gray-600 hover:text-gray-900' }}">
                <span class="text-xl">🔥</span> Popular
            </button>
            <button wire:click="sortBy('recent')" 
                    class="flex items-center gap-2 text-sm font-medium transition-colors duration-200 {{ $sortBy === 'recent' ? 'text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                <span class="text-xl">🆕</span> Recent
            </button>
            <button wire:click="sortBy('discussed')" 
                    class="flex items-center gap-2 text-sm font-medium transition-colors duration-200 {{ $sortBy === 'discussed' ? 'text-green-600' : 'text-gray-600 hover:text-gray-900' }}">
                <span class="text-xl">💬</span> Most Discussed
            </button>
        </div>
    </div>

    {{-- Posts List with Enhanced Design --}}
    <div class="space-y-4">
        @forelse($posts as $post)
            <div class="card post-card overflow-hidden">
                <div class="flex">
                    {{-- Vote Section with Gradient --}}
                    <div class="flex flex-col items-center p-6 bg-gradient-to-b from-gray-50 to-gray-100 border-r border-gray-200 rounded-l-lg">
                        <button wire:click="vote({{ $post->id }}, 1)" 
                                class="vote-btn text-gray-400 hover:text-orange-500 {{ $post->userVote()?->vote === 1 ? 'text-orange-500 vote-btn-active' : '' }}">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l6 6H4z"/>
                            </svg>
                        </button>
                        <span class="font-bold text-xl my-2 {{ $post->vote_count > 0 ? 'text-orange-500' : ($post->vote_count < 0 ? 'text-blue-500' : 'text-gray-600') }}">
                            {{ $post->vote_count }}
                        </span>
                        <button wire:click="vote({{ $post->id }}, -1)" 
                                class="vote-btn text-gray-400 hover:text-blue-500 {{ $post->userVote()?->vote === -1 ? 'text-blue-500 vote-btn-active' : '' }}">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 17l6-6H4z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Post Content --}}
                    <div class="flex-1 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs">{{ substr($post->user->name, 0, 1) }}</span>
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
                                           class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>

                                        {{-- Delete Button --}}
                                        <button @click="showDeleteConfirm = true"
                                                class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                                title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                                <p class="text-gray-600 mb-6">Are you sure you want to delete "{{ $post->title }}"? This action cannot be undone.</p>
                                                <div class="flex gap-3 justify-end">
                                                    <button @click="showDeleteConfirm = false" 
                                                            class="btn-secondary">
                                                        Cancel
                                                    </button>
                                                    <button wire:click="deletePost({{ $post->id }})" 
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
                        
                        <a href="{{ route('post.show', $post->id) }}" class="block group">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 mb-2 transition-colors duration-200">
                                {{ $post->title }}
                            </h3>
                            <p class="text-gray-600 line-clamp-2">{{ $post->content }}</p>
                        </a>

                        <div class="flex gap-6 mt-4">
                            <a href="{{ route('post.show', $post->id) }}" 
                               class="flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span class="font-medium">{{ $post->comment_count }} comments</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-12 text-center">
                <div class="text-6xl mb-4">📝</div>
                <p class="text-gray-500 text-lg">No posts yet in this category.</p>
                <p class="text-gray-400 text-sm mt-2">Be the first to start a discussion!</p>
            </div>
        @endforelse
    </div>
</div>