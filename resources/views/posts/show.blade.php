<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
            @if($post->image)
            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-48 h-48 object-cover rounded mx-auto">
            @endif

            <p class="text-gray-700 dark:text-gray-300">{{ $post->content }}</p>
            <small class="text-gray-500">Posted at {{ $post->created_at->format('d M Y H:i') }}</small>
        </div>

        @if(auth()->id() === $post->user_id)
        <div class="mt-4 flex gap-2">
            <!-- Edit Button -->
            <a href="{{ route('posts.edit', $post) }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Edit
            </a>

            <!-- Delete Button -->
            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>
        @endif

    </div>

    <!-- Likes -->
    <div class="flex items-center gap-2 mt-4">
        @if($post->likedBy(auth()->user()))
        <form action="{{ route('posts.unlike', $post) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600">❤️</button>
        </form>
        @else
        <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <button type="submit" class="text-gray-600 hover:text-red-600">🤍</button>
        </form>
        @endif
        <span>{{ $post->likes()->count() }} likes</span>
    </div>

    @if(auth()->check())
    <form action="{{ route('collections.addPost', ['collection' => auth()->user()->collections->first(), 'post' => $post]) }}" method="POST">
        @csrf
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">
            Save to First Collection
        </button>
    </form>
    @endif

    <!-- Comments -->
    <div class="mt-6">
        <h3 class="font-semibold mb-2">Comments</h3>

        <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
            @csrf
            <textarea name="content" class="w-full border rounded p-2" rows="2" placeholder="Write a comment..."></textarea>
            <button type="submit" class="mt-1 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Comment</button>
        </form>

        @foreach($post->comments as $comment)
        <div class="flex justify-between items-start gap-2 mb-2 p-2 bg-gray-100 dark:bg-gray-700 rounded">
            <div>
                <p class="font-semibold">{{ $comment->user->name }}</p>
                <p>{{ $comment->content }}</p>
            </div>
            @if(auth()->id() === $comment->user_id)
            <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="text-red-600">Delete</button>
            </form>
            @endif
        </div>
        @endforeach
    </div>


    <div class="mb-4 mt-6">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center w-12 h-12 bg-transparent rounded-full shadow hover:bg-purple-400 transition">
            <img src="{{ asset('images/back.svg') }}" alt="Back" class="w-6 h-6">
        </a>
    </div>
</x-app-layout>