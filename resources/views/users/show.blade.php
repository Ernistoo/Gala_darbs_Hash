<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <!-- User info -->
        <div class="inline-flex items-center gap-4 mb-6">
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('default-avatar.png') }}"
                 class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" />
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $user->name }}
                </h2>
                <p class="text-gray-500 dark:text-gray-400">
                    {{ '@' . $user->username }}
                </p>
            </div>
        </div>

        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Posts</h3>

        @if($posts->count())
        <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post) }}"
                   class="break-inside-avoid block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden transition transform hover:-translate-y-1 mb-4">
                    @if($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full object-cover">
                    @endif

                    <div class="p-4">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">
                            {{ $post->title }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">Šim lietotājam vēl nav postu.</p>
        @endif
    </div>
</x-app-layout>
