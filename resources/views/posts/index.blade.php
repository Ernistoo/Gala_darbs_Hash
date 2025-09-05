<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Post poga -->
            <div class="mb-4">
                <a href="{{ route('posts.create') }}"
                   class="px-4 py-2 bg-indigo-600 rounded-lg">
                    {{ __('Create Post') }}
                </a>
            </div>

            <!-- Parāda visus postus -->
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ $post->title }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $post->content }}
                    </p>
                    <small class="text-gray-500">
                        Posted by User ID: {{ $post->user_id }} on {{ $post->created_at->format('d M Y H:i') }}
                    </small>
                    <a href="{{ route('posts.show', $post) }}" class="text-indigo-600 hover:underline">
    View Post
</a>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">No posts yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
