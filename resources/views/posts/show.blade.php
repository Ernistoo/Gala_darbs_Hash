<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="max-w-4xl mx-auto py-6 space-y-6">

        
        <x-post-card :post="$post" />

        
        <div class="bg-white/80 dark:bg-gray-800/80 rounded-xl shadow-lg p-6 space-y-4">
            <h3 class="text-lg font-semibold">Comments ({{ $post->comments->count() }})</h3>

            @auth
                @include('posts.partials.comment-form', ['post' => $post])
            @endauth

            @foreach($post->comments as $comment)
                <x-comment-card :comment="$comment" />
            @endforeach
        </div>

    </div>
</x-app-layout>
