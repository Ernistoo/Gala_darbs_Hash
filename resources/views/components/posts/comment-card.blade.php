<div class="flex justify-between items-start gap-3 p-4 bg-gray-100/70 dark:bg-gray-700/70 rounded-lg"
    x-data="{ showReplies: false, replying: false }">

    <div class="flex gap-3">
        <a href="{{ route('users.show', $comment->user) }}">
            <img src="{{ userAvatar($comment->user->profile_photo) }}"
                class="w-10 h-10 rounded-full object-cover"
                alt="{{ $comment->user->name }}">
        </a>

        <div class="flex-1">
            <div class="flex justify-between items-center">
                <a href="{{ route('users.show', $comment->user) }}" class="font-semibold text-sm">
                    {{ $comment->user->name }}
                </a>
                <span class="text-xs text-gray-500 whitespace-nowrap ml-3">
                    {{ $comment->created_at->diffForHumans() }}
                </span>
            </div>

            <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $comment->content }}</p>

            <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                @if($comment->is_pinned)
                <span class="text-purple-600 font-semibold">📌 Pinned</span>
                @endif

                <button @click="replying = !replying"
                    class="text-purple-600 hover:underline font-medium">
                    <span x-show="!replying">Reply</span>
                    <span x-show="replying">Cancel</span>
                </button>
            </div>

            <div x-show="replying" x-transition.duration.300ms class="mt-3">
                <div x-show="replying" x-transition.duration.300ms class="mt-3">
                    <form action="{{ route('comments.reply', [$comment->post, $comment]) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="text" name="content"
                            placeholder="Reply to {{ $comment->user->name }}..."
                            class="flex-1 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1.5 text-sm 
                  bg-white dark:bg-gray-800 focus:ring-2 focus:ring-purple-500"
                            required>
                        <button type="submit"
                            class="px-3 py-1 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700">
                            Send
                        </button>
                    </form>
                </div>

            </div>

            @if($comment->replies->count() > 0)
            <button @click="showReplies = !showReplies"
                class="text-xs text-gray-500 hover:text-purple-500 mt-2">
                <span x-show="!showReplies">View replies ({{ $comment->replies->count() }})</span>
                <span x-show="showReplies">Hide replies</span>
            </button>

            <div x-show="showReplies" x-transition.duration.300ms class="mt-3 pl-6 border-l border-gray-300 dark:border-gray-600 space-y-3">
                @foreach($comment->replies as $reply)
                <div class="flex gap-3">
                    <a href="{{ route('users.show', $reply->user) }}">
                        <img src="{{ userAvatar($reply->user->profile_photo) }}"
                            class="w-8 h-8 rounded-full object-cover"
                            alt="{{ $reply->user->name }}">
                    </a>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('users.show', $reply->user) }}" class="font-semibold text-sm">
                                {{ $reply->user->name }}
                            </a>
                            <span class="text-xs text-gray-500 whitespace-nowrap ml-3">
                                {{ $reply->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $reply->content }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div class="flex gap-2">
        @if(auth()->id() === $comment->post->user_id && !$comment->is_pinned)
        <form action="{{ route('comments.pin', $comment) }}" method="POST">
            @csrf
            <button class="text-purple-500 hover:text-purple-700">📌</button>
        </form>
        @endif

        @if(auth()->id() === $comment->user_id)
        <form action="{{ route('comments.destroy', $comment) }}" method="POST">
            @csrf @method('DELETE')
            <button class="text-red-500">🗑</button>
        </form>
        @endif
    </div>
</div>