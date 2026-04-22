@props(['post'])

<div class="group relative break-inside-avoid block rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
    <div @click.stop="$dispatch('lightbox', {
        type: '{{ $post->video ? 'video' : ($post->youtube_url ? 'youtube' : 'image') }}',
        url: '{{ $post->video ? Storage::url($post->video) : ($post->youtube_url ? $post->youtube_url : Storage::url($post->image)) }}'
    })" class="cursor-pointer relative">
        @if ($post->image)
        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full object-cover">
        @elseif ($post->video)
        @if ($post->video_thumbnail)
        <img src="{{ Storage::url($post->video_thumbnail) }}" alt="{{ $post->title }}" class="w-full object-cover">
        @else
        <div class="w-full h-40 bg-gray-900 flex items-center justify-center">
            <span class="text-white text-xs">No thumbnail</span>
        </div>
        @endif
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-16 h-16 text-white opacity-80 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z" />
            </svg>
        </div>
        @elseif ($post->youtube_url)
        @php
        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->youtube_url, $matches);
        $videoId = $matches[1] ?? null;
        @endphp
        @if ($videoId)
        <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg" alt="{{ $post->title }}" class="w-full object-cover">
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-16 h-16 text-white opacity-80 group-hover:opacity-100 transition" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z" />
            </svg>
        </div>
        @endif
        @endif
    </div>

    <a href="{{ route('posts.show', $post) }}" class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <h3 class="text-sm font-semibold text-white text-center px-2 line-clamp-2">
            {{ $post->title }}
        </h3>
    </a>
</div>