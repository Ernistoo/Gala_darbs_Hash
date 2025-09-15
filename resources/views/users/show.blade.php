<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex items-center gap-4 mb-6">
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

        <div class="grid gap-4">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                    @if($post->image)
                        <img src="{{ Storage::url($post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded mb-3">
                    @endif
                    <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                        <a href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </h4>
                    <p class="text-gray-600 dark:text-gray-400">{{ Str::limit($post->content, 100) }}</p>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Šim lietotājam vēl nav postu.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
