<h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Posts</h3>

@if($posts->count())
    <div class="columns-1 xs:columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
        @foreach($posts as $post)
            <a href="{{ route('posts.show', $post) }}"
                class="group relative break-inside-avoid block rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
                {{-- Display video thumbnail or image --}}
                @if($post->video && $post->video_thumbnail)
                    <img src="{{ Storage::url($post->video_thumbnail) }}"
                        alt="{{ $post->title }}"
                        class="w-full object-cover">
                @elseif($post->image)
                    <img src="{{ Storage::url($post->image) }}"
                        alt="{{ $post->title }}"
                        class="w-full object-cover">
                @elseif($post->youtube_url)
                    @php
                        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->youtube_url, $matches);
                        $videoId = $matches[1] ?? null;
                    @endphp
                    @if($videoId)
                        <img src="https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg"
                            alt="{{ $post->title }}"
                            class="w-full object-cover">
                    @endif
                @endif
                <div class="absolute inset-0 flex items-center justify-center bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <h3 class="text-sm font-semibold text-white text-center px-2 line-clamp-2">
                        {{ $post->title }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
@else
    <p class="text-gray-500 dark:text-gray-400">This user has no posts yet.</p>
@endif