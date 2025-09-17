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
                    <img src="{{ Storage::url($post->image) }}" class="w-full h-32 object-cover rounded">
                </a>
                @endforeach
            </div>
        </div>
        @endforeach

    </div>

    <!-- Badge Popup -->
    @if(session('badge_earned'))
    <div x-data="{ show: true }" x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed top-4 right-4 bg-white dark:bg-gray-800 border shadow-lg rounded-lg p-4 flex items-center gap-3 z-50">
        <img src="{{ asset('images/' . session('badge_image')) }}" class="w-10 h-10 rounded-full">
        <div>
            <p class="font-bold text-gray-900 dark:text-gray-100">Badge earned!</p>
            <p class="text-sm text-gray-700 dark:text-gray-300">{{ session('badge_name') }}</p>
        </div>
        <button @click="show = false" class="ml-auto text-gray-500 hover:text-gray-700">&times;</button>
    </div>
    @endif

</x-app-layout>
