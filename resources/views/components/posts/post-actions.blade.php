@props(['post'])
<div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
    
    <div>
        @if($post->likedBy(auth()->user()))
            <form action="{{ route('posts.unlike', $post) }}" method="POST">
                @csrf @method('DELETE')
                <button class="text-red-600 hover:text-red-700 transition flex items-center gap-1">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $post->likes()->count() }}</span>
                </button>
            </form>
        @else
            <form action="{{ route('posts.like', $post) }}" method="POST">
                @csrf
                <button class="text-gray-600 dark:text-gray-400 hover:text-red-600 transition flex items-center gap-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span>{{ $post->likes()->count() }}</span>
                </button>
            </form>
        @endif
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
