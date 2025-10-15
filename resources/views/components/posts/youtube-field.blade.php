@props(['post' => null])

<div class="mb-6" 
     x-data="{
        youtubeUrl: '{{ old('youtube_url', $post->youtube_url ?? '') }}',
        get videoId() {
            const match = this.youtubeUrl.match(/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
            return match ? match[1] : null;
        },
        get thumbnail() {
            return this.videoId ? `https://img.youtube.com/vi/${this.videoId}/hqdefault.jpg` : null;
        }
     }">

    <label for="youtube_url" class="block mb-2 font-semibold text-gray-800 dark:text-gray-200">
        YouTube URL
    </label>

    <div class="flex items-center">
        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
            </svg>
        </span>
        <input
            type="url"
            id="youtube_url"
            name="youtube_url"
            x-model="youtubeUrl"
            placeholder="https://www.youtube.com/watch?v=XXXX"
            class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-r-lg input-focus focus:outline-none focus:ring-2 focus:ring-purple-500 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition">
    </div>

    @error('youtube_url')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror

    
    <template x-if="thumbnail">
        <div class="mt-4">
            <p class="text-gray-600 dark:text-gray-300 mb-2">Thumbnail preview:</p>
            <img :src="thumbnail" alt="YouTube thumbnail" class="rounded-xl shadow-lg w-full max-w-md">
        </div>
    </template>
</div>
