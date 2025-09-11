<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">My Collections</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 space-y-6">

        <!-- Create Collection -->
        <form action="{{ route('collections.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Collection name"
                class="border rounded p-2 flex-1">
            <x-primary-button>Create</x-primary-button>
        </form>

        <!-- List Collections -->
        @foreach($collections as $collection)
        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
            <h3 class="text-lg font-bold">{{ $collection->name }}</h3>
            <div class="grid grid-cols-3 gap-2 mt-2">
                @foreach($collection->posts as $post)
                <a href="{{ route('posts.show', $post) }}">
                    <img src="{{ asset($post->image) }}" class="w-full h-32 object-cover rounded">
                </a>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>
</x-app-layout>