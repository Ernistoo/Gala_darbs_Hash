@props(['post'])
<div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
    
    <div>
        <button class="like-btn transition flex items-center gap-1 hover:text-red-600 {{ $post->likedBy(auth()->user()) ? 'text-red-600' : 'text-gray-600 dark:text-gray-400' }}"
                data-post-id="{{ $post->id }}"
                data-liked="{{ $post->likedBy(auth()->user()) ? 'true' : 'false' }}">
            @if($post->likedBy(auth()->user()))
                <svg class="like-icon w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                </svg>
            @else
                <svg class="like-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            @endif
            <span class="like-count">{{ $post->likes()->count() }}</span>
        </button>
    </div>

    @auth
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="text-gray-600 dark:text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 transition flex items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                Save
            </button>
            <div x-show="open" @click.away="open = false" class="absolute mt-2 w-56 bg-white dark:bg-gray-700 shadow-lg rounded-lg border dark:border-gray-600 z-50 p-3">
                <form action="{{ route('collections.addPost', $post) }}" method="POST">
                    @csrf
                    <label for="collection" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Choose a collection:
                    </label>
                    <select name="collection" id="collection"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded p-2 bg-white dark:bg-gray-600 text-gray-900 dark:text-gray-100">
                        @foreach(auth()->user()->collections as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="mt-2 w-full px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md">
                        Add
                    </button>
                </form>
            </div>
        </div>
    @endauth
</div>