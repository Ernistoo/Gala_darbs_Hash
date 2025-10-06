<x-app-layout>
<x-header>        
    {{ __('Posts') }}
</x-header>
<x-back-button :route="route('posts.index')" />
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        
            
            <div class="mb-4">
                <a href="{{ route('posts.create') }}"
                   class="inline-flex items-center justify-center w-12 h-12 bg-transparent rounded-full shadow hover:bg-purple-400 transition">
                    <img src="{{ asset('images/add.svg') }}" alt="Create Post" class="w-6 h-6">
                </a>
            </div>

            @if($posts->count())
                <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
                    @foreach($posts as $post)
                        <x-posts.post-card-preview :post="$post" />
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">No posts in this category yet.</p>
            @endif
        </div>
    </div>
</x-app-layout>
