<x-app-layout>
    <x-header></x-header>
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
                            {{-- Handle Video with Thumbnail --}}
                            @if($post->video && $post->video_thumbnail)
                                <img src="{{ Storage::url($post->video_thumbnail) }}" 
                                     class="w-full h-40 object-cover rounded">
                            {{-- Handle Image --}}
                            @elseif($post->image)
                                <img src="{{ Storage::url($post->image) }}" 
                                     class="w-full h-40 object-cover rounded">
                            {{-- Handle YouTube --}}
                            @elseif($post->youtube_url)
                                @php
                                    preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->youtube_url, $matches);
                                    $videoId = $matches[1] ?? null;
                                @endphp
                                @if($videoId)
                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" 
                                         class="w-full h-40 object-cover rounded">
                                @else
                                    <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-500">No preview</span>
                                    </div>
                                @endif
                            {{-- Fallback --}}
                            @else
                                <div class="w-full h-40 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <span class="text-gray-500">No image</span>
                                </div>
                            @endif
                        </a>
                        <form action="{{ route('collections.removePost', [$collection, $post]) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            <button type="submit" class="px-2 py-1 text-red-500 hover:text-red-700 bg-white dark:bg-gray-800 rounded shadow">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">No posts in this collection yet.</p>
        @endif

    </div>
</x-app-layout>