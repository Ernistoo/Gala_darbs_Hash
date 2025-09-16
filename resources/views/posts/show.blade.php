<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center w-12 h-12 bg-transparent rounded-full shadow hover:bg-purple-400 transition">
            <img src="{{ asset('images/back.svg') }}" alt="Back" class="w-6 h-6">
        </a>
    </div>

    <div class="py-6 max-w-4xl mx-auto space-y-6">

        {{-- Post Box --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4 relative">

            {{-- Dropdown 3-punktu menu --}}
            @if(auth()->id() === $post->user_id)
                <div x-data="{ open: false }" class="absolute top-4 right-4">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        ⋮
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-700 shadow rounded border dark:border-gray-600 z-10">
                        <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Edit</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endif

            {{-- User info --}}
            <a href="{{ route('users.show', $post->user) }}" class="inline-flex items-center gap-2 mb-4">
                <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : asset('default-avatar.png') }}"
                     class="w-8 h-8 rounded-full object-cover">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
            </a>

            {{-- Media carousel --}}
            @php
    $mediaItems = [];
    if ($post->image) $mediaItems[] = '<img src="'.Storage::url($post->image).'" class="w-full h-64 object-cover flex-shrink-0 rounded">';
    if ($post->youtube_url && getYoutubeEmbedUrl($post->youtube_url)) $mediaItems[] = '<iframe src="'.getYoutubeEmbedUrl($post->youtube_url).'" class="w-full h-64 flex-shrink-0 rounded" frameborder="0" allowfullscreen></iframe>';
@endphp

@if(count($mediaItems) > 1)
    {{-- Carousel for multiple media --}}
    <div x-data="{ index: 0 }" class="relative">
        <div class="overflow-hidden w-full rounded">
            <div class="flex transition-transform duration-300" :style="`transform: translateX(-${index * 100}%)`">
                @foreach($mediaItems as $media)
                    {!! $media !!}
                @endforeach
            </div>
        </div>
        <button @click="index = Math.max(index - 1, 0)"
                class="absolute top-1/2 left-2 -translate-y-1/2 bg-gray-700 text-white px-2 py-1 rounded opacity-70 hover:opacity-100 transition">
            ◀
        </button>
        <button @click="index = Math.min(index + 1, {{ count($mediaItems) - 1 }})"
                class="absolute top-1/2 right-2 -translate-y-1/2 bg-gray-700 text-white px-2 py-1 rounded opacity-70 hover:opacity-100 transition">
            ▶
        </button>
    </div>
@elseif(count($mediaItems) === 1)
    {{-- Single media --}}
    <div class="w-full rounded">
        {!! $mediaItems[0] !!}
    </div>
@endif

            {{-- Post content --}}
            <p class="text-gray-700 dark:text-gray-300 mt-4">{{ $post->content }}</p>
            <small class="text-gray-500">Posted at {{ $post->created_at->format('d M Y H:i') }}</small>

            {{-- Likes & Collections --}}
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
                <form action="{{ route('collections.addPost', ['collection' => 0, 'post' => $post->id]) }}" method="POST" class="mt-4">
                    @csrf
                    <label for="collection">Choose a collection:</label>
                    <select name="collection" id="collection" required class="border p-1 rounded">
                        @foreach(auth()->user()->collections as $userCollection)
                            <option value="{{ $userCollection->id }}">{{ $userCollection->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-1 bg-indigo-600 text-white rounded ml-2">Add</button>
                </form>
            @endif
        </div>

        {{-- Comments Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-4">
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

    </div>
</x-app-layout>
