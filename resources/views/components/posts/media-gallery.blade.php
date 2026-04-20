@php
$mediaItems = [];

// Image
if ($post->image) {
$mediaItems[] = [
'type' => 'image',
'content' => '<img src="'.Storage::url($post->image).'" class="w-full h-80 object-contain rounded-lg cursor-pointer" onclick="openLightbox(\''.Storage::url($post->image).'\')">'
];
}

// Video
if ($post->video) {
$poster = $post->video_thumbnail ? Storage::url($post->video_thumbnail) : '';
$mediaItems[] = [
'type' => 'video',
'content' => '<video src="'.Storage::url($post->video).'" controls class="w-full h-80 object-contain rounded-lg" preload="metadata" poster="'.$poster.'"></video>'
];
}

// YouTube
if ($post->youtube_url && getYoutubeEmbedUrl($post->youtube_url)) {
$mediaItems[] = [
'type' => 'youtube',
'content' => '<iframe src="'.getYoutubeEmbedUrl($post->youtube_url).'" class="w-full h-80 rounded-lg" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
];
}
@endphp

@if(count($mediaItems) > 1)
{{-- Carousel for multiple media --}}
<div x-data="{ 
        index: 0, 
        total: {{ count($mediaItems) }},
        next() { this.index = this.index + 1; this.pauseOtherMedia(); },
        prev() { this.index = this.index - 1; this.pauseOtherMedia(); },
        pauseOtherMedia() {
            document.querySelectorAll('.media-carousel video').forEach(v => v.pause());
        }
    }" class="relative mb-4 overflow-hidden rounded-lg">

    <div class="flex transition-transform duration-300" :style="`transform: translateX(-${index * 100}%)`">
        @foreach($mediaItems as $media)
        <div class="w-full flex-shrink-0 media-carousel">
            {!! $media['content'] !!}
        </div>
        @endforeach
    </div>

    {{-- Navigation arrows --}}
    <button @click="prev()" x-show="index > 0"
        class="absolute top-1/2 left-2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full backdrop-blur-sm transition z-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    <button @click="next()" x-show="index < total - 1"
        class="absolute top-1/2 right-2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full backdrop-blur-sm transition z-10">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    {{-- Dots --}}
    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2 z-10">
        @foreach($mediaItems as $key => $media)
        <button @click="index = {{ $key }}; pauseOtherMedia()"
            class="w-2 h-2 rounded-full transition-all"
            :class="index === {{ $key }} ? 'bg-white w-4' : 'bg-white/50'"></button>
        @endforeach
    </div>

    {{-- Media type badge --}}
    <div class="absolute top-3 left-3 z-10 flex gap-1">
        @foreach($mediaItems as $key => $media)
        <template x-if="index === {{ $key }}">
            <span class="px-2 py-1 bg-black/50 backdrop-blur-sm text-white text-xs rounded-full">
                @if($media['type'] === 'image') 📷
                @elseif($media['type'] === 'video') 🎬
                @else ▶️ YouTube
                @endif
            </span>
        </template>
        @endforeach
    </div>
</div>

@elseif(count($mediaItems) === 1)
{{-- Single media --}}
<div class="mb-4 relative group">
    @if($mediaItems[0]['type'] === 'image')
    <div onclick="openLightbox('{{ Storage::url($post->image) }}')" class="cursor-pointer">
        {!! $mediaItems[0]['content'] !!}
        <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="p-2 bg-black/50 backdrop-blur-sm rounded-full">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                </svg>
            </div>
        </div>
    </div>
    @else
    {!! $mediaItems[0]['content'] !!}
    @endif
</div>
@endif