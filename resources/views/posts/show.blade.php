<x-app-layout>

    <div class="max-w-4xl mx-auto py-6 space-y-6">

        
        <x-posts.post-card :post="$post" />

        
        <div class="bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-lg p-6 space-y-4">
            <h3 class="text-lg font-semibold">Comments ({{ $post->comments->count() }})</h3>

            @auth
            <x-posts.comment-form :post="$post" />
            @endauth

            @foreach($post->comments->sortByDesc('is_pinned') as $comment)
            <x-posts.comment-card :comment="$comment" />
            @endforeach
        </div>

    </div>
</x-app-layout>
