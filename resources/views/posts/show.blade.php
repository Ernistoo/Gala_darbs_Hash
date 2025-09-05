<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <p class="text-gray-700 dark:text-gray-300">{{ $post->content }}</p>
            <small class="text-gray-500">Posted at {{ $post->created_at->format('d M Y H:i') }}</small>
        </div>
    </div>
    <a href="{{ route('posts.index', $post) }}" class="text-indigo-600 hover:underline">
    Back
</a>
</x-app-layout>