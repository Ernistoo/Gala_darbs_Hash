@props(['post'])

<div class="break-inside-avoid bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl overflow-hidden transition-all duration-300 transform hover:-translate-y-1.5 relative mb-4 group border border-gray-100 dark:border-gray-700">
    
    {{-- Media Preview Area --}}
    <a href="{{ route('posts.show', $post) }}" class="block relative">
    @if($post->video)
    <div class="relative w-full h-48 bg-black">
        @if($post->video_thumbnail)
            <img src="{{ Storage::url($post->video_thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-900 flex items-center justify-center">
                <span class="text-white text-sm">No thumbnail</span>
            </div>
        @endif
        {{-- Play icon overlay --}}
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-12 h-12 bg-black/60 backdrop-blur-sm rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                </svg>
            </div>
        </div>
    </div>
@endif
                {{-- Play icon overlay --}}
                <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition">
                    <div class="w-12 h-12 bg-black/60 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </div>
                </div>
            </div>
        @elseif($post->image)
            {{-- Image Post --}}
            <div class="relative overflow-hidden h-48">
                <img src="{{ Storage::url($post->image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
        @elseif($post->youtube_url)
            {{-- YouTube Post --}}
            <div class="relative h-48">
                @php
                    $videoId = null;
                    if (preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $post->youtube_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp
                <img src="{{ $videoId ? 'https://img.youtube.com/vi/'.$videoId.'/hqdefault.jpg' : asset('images/youtube-placeholder.jpg') }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/40 transition">
                    <div class="w-12 h-12 bg-black/60 backdrop-blur-sm rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                        </svg>
                    </div>
                </div>
            </div>
        @else
            {{-- Text-only fallback --}}
            <div class="w-full h-48 bg-gradient-to-br from-purple-100 to-purple-200 dark:from-purple-900/30 dark:to-purple-800/30 flex items-center justify-center">
                <svg class="w-12 h-12 text-purple-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif
    </a>

    {{-- Content --}}
    <div class="p-4">
        <div class="flex items-center justify-between mb-2">
            <a href="{{ route('users.show', $post->user) }}" class="flex items-center gap-2">
                <img src="{{ userAvatar($post->user->profile_photo) }}"
                     class="w-6 h-6 rounded-full object-cover">
                <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
            </a>
            <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-sm line-clamp-2 mb-1">
            <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
        </h3>

        <p class="text-gray-600 dark:text-gray-400 text-xs line-clamp-2 mb-3">
            {{ Str::limit($post->content, 100) }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- Like Button --}}
                <button class="like-btn flex items-center gap-1 text-gray-500 hover:text-red-500 transition"
                        data-post-id="{{ $post->id }}"
                        data-liked="{{ $post->likedBy(auth()->user()) ? 'true' : 'false' }}">
                    <svg class="w-4 h-4 like-icon {{ $post->likedBy(auth()->user()) ? 'text-red-500' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                    </svg>
                    <span class="like-count text-xs">{{ $post->likes()->count() }}</span>
                </button>
                {{-- Comments --}}
                <a href="{{ route('posts.show', $post) }}#comments" class="flex items-center gap-1 text-gray-500 hover:text-purple-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="text-xs">{{ $post->comments()->count() }}</span>
                </a>
            </div>
            @if($post->category)
                <span class="text-xs px-2 py-1 bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 rounded-full">
                    {{ $post->category->name }}
                </span>
            @endif
        </div>
    </div>
</div>