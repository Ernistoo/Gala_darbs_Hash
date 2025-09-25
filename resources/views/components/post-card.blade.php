@props(['post'])

<div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl shadow-lg p-6 space-y-4 relative border border-gray-200 dark:border-gray-700">
    <!-- Dropdown -->
    @include('posts.partials.post-dropdown', ['post' => $post])

    <!-- User -->
    <a href="{{ route('users.show', $post->user) }}" class="inline-flex items-center gap-3 mb-4 group">
        <img src="{{ $post->user->profile_photo ? asset('storage/'.$post->user->profile_photo) : asset('default-avatar.png') }}"
             class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700 group-hover:border-purple-400 transition">
        <div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition">{{ $post->user->name }}</span>
            <p class="text-xs text-gray-500 dark:text-gray-400">Posted at {{ $post->created_at->format('d M Y H:i') }}</p>
        </div>
    </a>

    <!-- Media -->
    @include('posts.partials.media-gallery', ['post' => $post])

    <!-- Title & Content -->
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $post->title }}</h2>
    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $post->content }}</p>

    <!-- Category -->
    @if($post->category)
        <div class="inline-flex items-center px-3 py-1 bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 rounded-full text-sm mb-4">
            {{ $post->category->name }}
        </div>
    @endif

    <!-- Likes & Save -->
    @include('posts.partials.post-actions', ['post' => $post])
</div>
