<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">{{ $collection->name }}</h2>
    </x-slot>
    <x-back-button :route="route('collections.index')" />
    <div class="max-w-4xl mx-auto py-6 space-y-6">

        @if($collection->description)
        <p class="text-gray-600 dark:text-gray-400">{{ $collection->description }}</p>
        @endif

        @if($collection->posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($collection->posts as $post)
            <div class="relative bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
                <a href="{{ route('posts.show', $post) }}">
                    <img src="{{ Storage::url($post->image) }}" class="w-full h-40 object-cover rounded">
                </a>
                <form action="{{ route('collections.removePost', [$collection, $post]) }}" method="POST" class="absolute top-2 right-2">
                    @csrf
                    <button type="submit" class="px-2 py-1 text-red-500 hover:text-red-700 bg-white rounded">Remove</button>
                </form>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-gray-500 dark:text-gray-400">No posts in this collection yet.</p>
        @endif

    </div>
</x-app-layout>
