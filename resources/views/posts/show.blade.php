<x-app-layout>
    <!--Style-->


    <body class="font-sans antialiased bg-gradient-to-br from-gray-200 to-purple-100 dark:from-black dark:to-purple-900 transition-colors duration-500 ease-in-out min-h-screen">
        <div class="min-h-screen flex">

            <div class="flex-1 flex flex-col ml-64 transition-colors duration-500 ease-in-out">
                <header class="transition-colors duration-500 ease-in-out">
                    <div class="px-6 py-4 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                        <div class="mb-4">
                            <a href="{{ route('posts.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full shadow hover:bg-purple-100 dark:hover:bg-purple-800 transition btn-transition">
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </header>

                <main class="p-6 transition-colors duration-500 ease-in-out text-gray-900 dark:text-gray-100">
                    <div class="max-w-4xl mx-auto space-y-6 fade-in">
                        <!--Post box-->
                        <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 space-y-4 relative border border-gray-200 dark:border-gray-700">
                            <!--Dropdown-->
                            <div x-data="{ open: false }" class="absolute top-6 right-6">
                                <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 shadow-lg rounded-lg border dark:border-gray-600 z-50 overflow-hidden">
                                    <!-- Edit for owner -->
                                    @if(auth()->id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    @endif


                                    @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 transition flex items-center gap-2 text-red-600 dark:text-red-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </div>


                            <a href="{{ route('users.show', $post->user) }}" class="inline-flex items-center gap-3 mb-4 group">
                                <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : asset('default-avatar.png') }}"
                                    class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700 group-hover:border-purple-400 transition">
                                <div>
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">{{ $post->user->name }}</span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Posted at {{ $post->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </a>

                            <!--scroll-->
                            @php
                            $mediaItems = [];
                            if ($post->image) $mediaItems[] = '<img src="'.Storage::url($post->image).'" class="w-full h-80 object-contain flex-shrink-0 rounded-lg">';
                            if ($post->youtube_url && getYoutubeEmbedUrl($post->youtube_url)) $mediaItems[] = '<iframe src="'.getYoutubeEmbedUrl($post->youtube_url).'" class="w-full h-80 flex-shrink-0 rounded-lg" frameborder="0" allowfullscreen></iframe>';
                            @endphp

                            @if(count($mediaItems) > 0)
                            @if(count($mediaItems) > 1)
                            <div x-data="{ index: 0 }" class="relative mb-4 rounded-lg overflow-hidden">
                                <div class="overflow-hidden w-full rounded-lg">
                                    <div class="flex carousel-transition" :style="`transform: translateX(-${index * 100}%)`">
                                        @foreach($mediaItems as $media)
                                        <div class="w-full flex-shrink-0">
                                            {!! $media !!}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button @click="index = Math.max(index - 1, 0)"
                                    class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full opacity-70 hover:opacity-100 transition"
                                    :class="index === 0 ? 'invisible' : 'visible'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button @click="index = Math.min(index + 1, {{ count($mediaItems) - 1 }})"
                                    class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/40 text-white p-2 rounded-full opacity-70 hover:opacity-100 transition"
                                    :class="index === {{ count($mediaItems) - 1 }} ? 'invisible' : 'visible'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    @foreach($mediaItems as $i => $media)
                                    <button @click="index = {{ $i }}"
                                        class="w-2 h-2 rounded-full transition"
                                        :class="index === {{ $i }} ? 'bg-white' : 'bg-white/50'">
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="mb-4 rounded-lg overflow-hidden">
                                {!! $mediaItems[0] !!}
                            </div>
                            @endif
                            @endif

                            <!--content-->
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $post->title }}</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-4 whitespace-pre-line">{{ $post->content }}</p>

                            <!--category-->
                            @if($post->category)
                            <div class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 rounded-full text-sm mb-4">
                                {{ $post->category->name }}
                            </div>
                            @endif

                            <!-- likes n collections -->
                            <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2">
                                    @if($post->likedBy(auth()->user()))
                                    <form action="{{ route('posts.unlike', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 transition flex items-center gap-1">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{ $post->likes()->count() }}</span>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('posts.like', $post) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-gray-600 dark:text-gray-400 hover:text-red-600 transition flex items-center gap-1">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin='round' stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span>{{ $post->likes()->count() }}</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>

                                @if(auth()->check())
                                <div x-data="{ open: false }" class="dropdown-container relative">
                                    <button @click="open = !open"
                                        class="text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition flex items-center gap-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                        Save
                                    </button>

                                    <div x-show="open" @click.away="open = false"
                                        x-cloak
                                        class="dropdown-menu absolute left-0 bottom-full mb-2 w-56 bg-white dark:bg-gray-700 shadow-lg rounded-lg border dark:border-gray-600 z-50 p-3">

                                        <form action="{{ route('collections.addPost', $post) }}" method="POST" class="mt-2 flex flex-col gap-2">
                                            @csrf
                                            <label for="collection" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                Choose a collection:
                                            </label>
                                            <select name="collection" id="collection" required
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100 text-sm">
                                                @foreach(auth()->user()->collections as $userCollection)
                                                <option value="{{ $userCollection->id }}">{{ $userCollection->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit"
                                                class="mt-2 w-full px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-sm transition">
                                                Add to Collection
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- comments section -->
                        <div class="comments-section bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 space-y-4 border border-gray-200 dark:border-gray-700">
                            <h3 class="font-semibold text-lg mb-2">Comments ({{ $post->comments->count() }})</h3>

                            @auth
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                                @csrf
                                <div class="flex gap-3">
                                    <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('default-avatar.png') }}"
                                        class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                    <div class="flex-1">
                                        <textarea name="content" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-purple-500 transition" rows="2" placeholder="Write a comment..."></textarea>
                                        <button type="submit" class="mt-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm transition btn-transition">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                            @endauth

                            @foreach($post->comments as $comment)
                            <div class="flex justify-between items-start gap-3 p-4 bg-gray-100/70 dark:bg-gray-700/70 rounded-lg">
                                <div class="flex gap-3">
                                    <a href="{{ route('users.show', $comment->user) }}">
                                        <img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : asset('default-avatar.png') }}"
                                            class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                    </a>
                                    <div>
                                        <a href="{{ route('users.show', $comment->user) }}" class="font-semibold text-sm text-gray-800 dark:text-gray-200 hover:text-purple-600 dark:hover:text-purple-400 transition">{{ $comment->user->name }}</a>
                                        <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $comment->content }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                @if(auth()->id() === $comment->user_id)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 transition p-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>

            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dropdown', () => ({
                    open: false,
                    toggle() {
                        this.open = !this.open
                    }
                }))

                Alpine.data('carousel', () => ({
                    index: 0,
                    next() {
                        this.index = (this.index + 1) % this.items.length
                    },
                    prev() {
                        this.index = (this.index - 1 + this.items.length) % this.items.length
                    }
                }))
            })
        </script>
        <script src="//unpkg.com/alpinejs" defer></script>



</x-app-layout>