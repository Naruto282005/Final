<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="text-xl font-bold mb-4">Comments ({{ $post->comment_count }})</h3>

    @if (session()->has('comment-success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('comment-success') }}
        </div>
    @endif

    {{-- Comment Form --}}
    @auth
        <form wire:submit.prevent="submitComment" class="mb-6">
            <textarea wire:model="content" 
                      rows="3" 
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                      placeholder="Add a comment..."></textarea>
            @error('content') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
            <div class="mt-2">
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Comment
                </button>
            </div>
        </form>
    @else
        <div class="mb-6 p-4 bg-gray-50 rounded-lg text-center">
            <p class="text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Log in</a>
                or
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
                to join the discussion.
            </p>
        </div>
    @endauth

    {{-- Comments List --}}
    <div class="space-y-4">
        @forelse($post->comments as $comment)
            <div class="border-l-2 border-gray-200 pl-4">
                <div class="flex gap-3">
                    {{-- Vote buttons --}}
                    <div class="flex flex-col items-center">
                        <button wire:click="voteComment({{ $comment->id }}, 1)" 
                                class="text-gray-400 hover:text-orange-500 transition-colors {{ $comment->userVote()?->vote === 1 ? 'text-orange-500' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3l6 6H4z"/>
                            </svg>
                        </button>
                        <span class="text-sm font-semibold {{ $comment->vote_count > 0 ? 'text-orange-500' : ($comment->vote_count < 0 ? 'text-blue-500' : 'text-gray-600') }}">
                            {{ $comment->vote_count }}
                        </span>
                        <button wire:click="voteComment({{ $comment->id }}, -1)" 
                                class="text-gray-400 hover:text-blue-500 transition-colors {{ $comment->userVote()?->vote === -1 ? 'text-blue-500' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 17l6-6H4z"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Comment content --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                            <span class="font-medium text-gray-700">{{ $comment->user->name }}</span>
                            <span>•</span>
                            <span>{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</div>
