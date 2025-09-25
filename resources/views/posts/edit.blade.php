<x-app-layout>
    <div class="flex justify-center py-6">
        @include('posts.partials.form', [
            'action' => route('posts.update', $post),
            'post' => $post,
            'update' => true
        ])
    </div>
</x-app-layout>
