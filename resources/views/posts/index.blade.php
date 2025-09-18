<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('') }}
        </h2>
    </x-slot>

    <div class="mb-4 inline-block">
    <form method="GET" action="{{ route('posts.index') }}">
        <select 
            name="category_id" 
            onchange="this.form.submit()" 
            class="bg-transparent border-2 border-purple-500 text-gray-900  
                   rounded-lg px-3 py-2 w-auto min-w-[150px] 
                   focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-500
                   transition-colors duration-300 ease-in-out">
            
            <!-- Placeholder option with light text in dark mode -->
            <option value="" class="text-gray-400 dark:text-gray-200">
                All Categories
            </option>

            @foreach($categories as $category)
                <option value="{{ $category->id }}" class="text-gray-900" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </form>
</div>
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
<div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
    @foreach($posts as $post)
    <a href="{{ route('posts.show', $post) }}" 
       class="break-inside-avoid block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
        @if($post->image)
        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full object-cover">
        @endif

        <div class="p-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">
                {{ $post->title }}
            </h3>
        </div>
    </a>
    @endforeach
</div>

@else
<p class="text-gray-500">No posts available.</p>
@endif

</x-app-layout>