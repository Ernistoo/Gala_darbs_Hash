@props(['post'])

<a href="{{ route('posts.show', $post) }}"
   class="group relative break-inside-avoid block rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">

    @if ($post->image)
        <img src="{{ Storage::url($post->image) }}"
             alt="{{ $post->title }}"
             class="w-full object-cover">

    @elseif ($post->youtube_url)
        @php
            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->youtube_url, $matches);
            $videoId = $matches[1] ?? null;
        @endphp

        @if ($videoId)
            <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                 alt="{{ $post->title }}"
                 class="w-full object-cover">
            <div class="absolute inset-0 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-16 h-16 text-white opacity-80 group-hover:opacity-100 transition"
                     fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
        @endif
    @endif

    <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <h3 class="text-sm font-semibold text-white text-center px-2 line-clamp-2">
            {{ $post->title }}
        </h3>
    </div>
</a>
