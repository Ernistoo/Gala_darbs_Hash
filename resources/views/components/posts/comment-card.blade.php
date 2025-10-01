<div class="flex justify-between items-start gap-3 p-4 bg-gray-100/70 dark:bg-gray-700/70 rounded-lg">
    <div class="flex gap-3">
        <a href="{{ route('users.show', $comment->user) }}">
            <img src="{{ $comment->user->profile_photo ? asset('storage/'.$comment->user->profile_photo) : asset('default-avatar.png') }}"
                 class="w-10 h-10 rounded-full object-cover">
        </a>
        <div>
            <a href="{{ route('users.show', $comment->user) }}" class="font-semibold text-sm">
                {{ $comment->user->name }}
            </a>
            <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $comment->content }}</p>
            <p class="text-xs text-gray-500">
                {{ $comment->created_at->diffForHumans() }}
                @if($comment->is_pinned)
                    <span class="ml-2 text-purple-600 font-semibold">📌 Pinned</span>
                @endif
            </p>
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