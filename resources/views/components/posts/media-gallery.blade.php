@php
$mediaItems = [];
if ($post->image) {
    $mediaItems[] = '<img src="'.Storage::url($post->image).'" class="w-full h-80 object-contain rounded-lg">';
}
if ($post->youtube_url && getYoutubeEmbedUrl($post->youtube_url)) {
    $mediaItems[] = '<iframe src="'.getYoutubeEmbedUrl($post->youtube_url).'" class="w-full h-80 rounded-lg" frameborder="0" allowfullscreen></iframe>';
}
@endphp

@if(count($mediaItems) > 1)
    <div x-data="{ index: 0 }" class="relative mb-4 overflow-hidden rounded-lg">
        <div class="flex transition-transform" :style="`transform: translateX(-${index * 100}%)`">
            @foreach($mediaItems as $media)
                <div class="w-full flex-shrink-0">{!! $media !!}</div>
            @endforeach
        </div>
        
        <button @click="index = Math.max(index - 1, 0)" class="absolute top-1/2 left-4 bg-black/40 text-white p-2 rounded-full">‹</button>
        <button @click="index = Math.min(index + 1, {{ count($mediaItems) - 1 }})" class="absolute top-1/2 right-4 bg-black/40 text-white p-2 rounded-full">›</button>
    </div>
@elseif(count($mediaItems) === 1)
    <div class="mb-4">{!! $mediaItems[0] !!}</div>
@endif
