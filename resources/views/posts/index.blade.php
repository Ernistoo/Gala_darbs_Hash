<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Create Post button -->
            <div class="mb-4">
                <a href="{{ route('posts.create') }}" class="inline-flex items-center justify-center w-12 h-12 bg-transparent rounded-full shadow hover:bg-purple-400 transition">
                    <img src="{{ asset('images/add.svg') }}" alt="Create Post" class="w-6 h-6">
                </a>
            </div>

            <!-- Posts Grid -->
            @if($posts->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="block bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg overflow-hidden transition">
                    @if($post->image)
                    <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full object-cover" style="aspect-ratio: 3/4;">
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $post->title }}
                        </h3>

                        <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-3">
                            {{ $post->content }}
                        </p>

                        <div class="mt-2 flex justify-between items-center text-xs text-gray-500">
                            <span>By User {{ $post->user_id }}</span>
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <p class="text-gray-500">No posts available.</p>
            @endif
        </div>
    </div>
</x-app-layout>