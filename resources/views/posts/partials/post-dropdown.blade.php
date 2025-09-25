<div x-data="{ open: false }" class="absolute top-6 right-6">
    <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 shadow-lg rounded-lg border dark:border-gray-600 z-50 overflow-hidden">
        @if(auth()->id() === $post->user_id)
            <a href="{{ route('posts.edit', $post) }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit
            </a>
        @endif
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600 flex items-center gap-2 text-red-600 dark:text-red-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </form>
        @endcan
    </div>
</div>
