<div class="px-6 py-4 text-gray-900 dark:text-gray-100">
    <a href="{{ route('challenges.index') }}" class="inline-flex items-center text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition mb-4">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Challenges
    </a>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">{{ $challenge->title }}</h2>

        @role('admin')
            <form action="{{ route('challenges.destroy', $challenge) }}" method="POST" onsubmit="return confirm('Do you really want to delete this challenge?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                    Delete
                </button>
            </form>
        @endrole
    </div>
</div>
