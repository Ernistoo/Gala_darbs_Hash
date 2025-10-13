<h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Posts</h3>

@if($posts->count())
<div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
    @foreach($posts as $post)
    <a href="{{ route('posts.show', $post) }}"
        class="group relative break-inside-avoid block rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
        @if($post->image)
        <img src="{{ Storage::url($post->image) }}"
            alt="{{ $post->title }}"
            class="w-full object-cover">
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